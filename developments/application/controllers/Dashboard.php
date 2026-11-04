<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->_ensure_tables_exist();

		// Memanggil library untuk templating halaman (Open Website: Tanpa wajib login di halaman depan)
		$this->load->library('template');

		// Memanggil Model
		$this->load->model('Model_User', 'model_user');
		$this->load->model('Model_Ruangan', 'model_ruangan');
		$this->load->model('Model_Peminjaman', 'model_peminjaman');
		$this->load->model('Model_Tap', 'model_tap');
	}

	private function _ensure_tables_exist()
	{
		try
		{
			if ( ! $this->db->table_exists('tb_user'))
			{
				$this->db->query("CREATE TABLE IF NOT EXISTS `tb_user` (
				  `username` varchar(30) NOT NULL,
				  `fullname` varchar(50) NOT NULL,
				  `password` varchar(255) NOT NULL,
				  `level` varchar(20) NOT NULL,
				  PRIMARY KEY (`username`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
			}

			$check_super = $this->db->get_where('tb_user', array('username' => 'superadmin'))->row_array();
			if (empty($check_super) || ! password_verify('123123', $check_super['password']))
			{
				$default_pass = password_hash('123123', PASSWORD_DEFAULT);
				$default_users = array(
					array('username' => 'superadmin', 'fullname' => 'Superadmin Medquest', 'password' => $default_pass, 'level' => 'Admin'),
					array('username' => 'ryan', 'fullname' => 'Ryan (Superadmin)', 'password' => $default_pass, 'level' => 'Admin'),
					array('username' => 'operator', 'fullname' => 'Operator Resepsionis', 'password' => $default_pass, 'level' => 'Resepsionis'),
					array('username' => 'resepsionis', 'fullname' => 'Resepsionis Medquest', 'password' => $default_pass, 'level' => 'Resepsionis')
				);
				foreach ($default_users as $u)
				{
					$this->db->replace('tb_user', $u);
				}
			}

			if ( ! $this->db->table_exists('tb_ruangan'))
			{
				$this->db->query("CREATE TABLE IF NOT EXISTS `tb_ruangan` (
				  `id_ruangan` varchar(10) NOT NULL,
				  `nama_ruangan` varchar(50) NOT NULL,
				  `status` varchar(16) NOT NULL,
				  `kapasitas` int unsigned NOT NULL DEFAULT '10',
				  `room_qr_key` varchar(64) DEFAULT NULL,
				  PRIMARY KEY (`id_ruangan`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

				$this->db->query("INSERT IGNORE INTO `tb_ruangan` VALUES 
				('R001','Pulau Jawa','Tersedia',5,'425df689b3da49a46d8cca03ea61d525'),
				('R002','Pulau Bali','Tersedia',6,'ac21c50087cad0659cb183baff9aa63e'),
				('R003','Pulau Papua','Tersedia',10,'e508f4e4b5ae301725c43aa005070b3b'),
				('R004','Pulau Sumatra','Tersedia',15,'df39d8e0a2144bc7c7b111093bac81fa'),
				('R005','Pulau Kalimantan','Tersedia',7,'d97cbc1e96b14db386d7d205b813a62f');");
			}

			if ( ! $this->db->table_exists('tb_peminjaman'))
			{
				$this->db->query("CREATE TABLE IF NOT EXISTS `tb_peminjaman` (
				  `id_peminjaman` varchar(10) NOT NULL,
				  `peminjam` varchar(25) NOT NULL,
				  `ruangan_dipinjam` varchar(50) NOT NULL,
				  `keterangan` varchar(255) NOT NULL,
				  `waktu_pengajuan` datetime NOT NULL,
				  `waktu_penyetujuan` datetime DEFAULT NULL,
				  `waktu_pembatalan` datetime DEFAULT NULL,
				  `waktu_pengembalian` datetime DEFAULT NULL,
				  `verifikasi_bp` varchar(5) NOT NULL,
				  `verifikasi_kabag` varchar(5) NOT NULL,
				  `status_pinjam` varchar(15) NOT NULL,
				  `tanggal_meeting` date DEFAULT NULL,
				  `jam_meeting` time DEFAULT NULL,
				  `nama_peminjam` varchar(50) DEFAULT NULL,
				  `departemen_peminjam` varchar(50) DEFAULT NULL,
				  `telepon_peminjam` varchar(20) DEFAULT NULL,
				  `waktu_checkin` datetime DEFAULT NULL,
				  PRIMARY KEY (`id_peminjaman`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
			}

			if ( ! $this->db->table_exists('tb_tap'))
			{
				$this->db->query("CREATE TABLE IF NOT EXISTS `tb_tap` (
				  `id` int NOT NULL AUTO_INCREMENT,
				  `id_kartu` varchar(20) NOT NULL,
				  `nama_ruangan` varchar(50) NOT NULL,
				  `waktu_akses` datetime NOT NULL,
				  `waktu_tutup` datetime NOT NULL,
				  `status_akses` varchar(10) NOT NULL DEFAULT 'Dibuka',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;");
			}
		}
		catch (Exception $e)
		{
			log_message('error', 'Auto-table init error: ' . $e->getMessage());
		}
	}

	public function index()
	{
		$this->model_peminjaman->auto_cancel_no_show();

		$halaman['hal'] = "Beranda";
		date_default_timezone_set('Asia/Jakarta');
		$today = date('Y-m-d');
		$now_time = date('H:i:s');

		$rooms = $this->model_ruangan->tampil()->result_array();

		// Evaluasi status ruangan secara real-time pada jam saat ini
		foreach ($rooms as &$r) {
			if ($r['status'] == 'Tersedia') {
				// Cek apakah ada jadwal meeting yang sedang aktif di ruangan ini pada jam saat membuka website
				$active_meeting = $this->db
					->where('ruangan_dipinjam', $r['nama_ruangan'])
					->where('tanggal_meeting', $today)
					->where('jam_meeting <=', $now_time)
					->where("ADDTIME(jam_meeting, '01:00:00') >", $now_time)
					->where_not_in('status_pinjam', array('Dibatalkan', 'Selesai'))
					->get('tb_peminjaman')
					->row_array();

				if ($active_meeting) {
					$r['status_realtime'] = 'Sedang Digunakan';
					$r['is_busy'] = true;
				} else {
					$r['status_realtime'] = 'Tersedia';
					$r['is_busy'] = false;
				}
			} else {
				$r['status_realtime'] = $r['status'];
				$r['is_busy'] = false;
			}
		}
		unset($r);

		$halaman['rooms'] = $rooms;
		$halaman['total_ruangan'] = count($rooms);
		$halaman['booking_hari_ini'] = $this->db
			->where('tanggal_meeting', date('Y-m-d'))
			->where('status_pinjam !=', 'Dibatalkan')
			->count_all_results('tb_peminjaman');

		// Analytics - Total Semua Peminjaman
		$halaman['total_agenda'] = $this->db->count_all_results('tb_peminjaman');

		// Analytics - Status Breakdown
		$disetujui = $this->db->where('status_pinjam', 'Disetujui')->count_all_results('tb_peminjaman');
		$selesai   = $this->db->where('status_pinjam', 'Selesai')->count_all_results('tb_peminjaman');
		$menunggu  = $this->db->where('status_pinjam', 'Menunggu')->count_all_results('tb_peminjaman');
		$batal     = $this->db->where('status_pinjam', 'Dibatalkan')->count_all_results('tb_peminjaman');
		$halaman['status_counts'] = array(
			'disetujui' => $disetujui,
			'selesai'   => $selesai,
			'menunggu'  => $menunggu,
			'batal'     => $batal
		);

		// Analytics - Utilisasi per Ruangan
		$room_counts = array();
		foreach ($rooms as $r) {
			$c = $this->db
				->where('ruangan_dipinjam', $r['nama_ruangan'])
				->where('status_pinjam !=', 'Dibatalkan')
				->count_all_results('tb_peminjaman');
			$room_counts[] = array(
				'id' => $r['id_ruangan'],
				'nama' => $r['nama_ruangan'],
				'kapasitas' => $r['kapasitas'],
				'total_booking' => $c
			);
		}
		usort($room_counts, function($a, $b) {
			return $b['total_booking'] - $a['total_booking'];
		});
		$halaman['room_utilization'] = $room_counts;

		// Analytics - Top Departemen
		$halaman['top_dept'] = $this->db
			->select('departemen_peminjam, COUNT(*) as total')
			->where('departemen_peminjam IS NOT NULL', NULL, FALSE)
			->where('departemen_peminjam !=', '')
			->group_by('departemen_peminjam')
			->order_by('total', 'DESC')
			->limit(5)
			->get('tb_peminjaman')
			->result_array();

		// Check-in on-time rate (%)
		$total_verified = $selesai + $disetujui;
		$checked_in = $this->db->where('waktu_checkin IS NOT NULL')->count_all_results('tb_peminjaman');
		$halaman['checkin_rate'] = ($total_verified > 0) ? round(($checked_in / $total_verified) * 100) : 100;

		$this->template->utama('pages/halaman-beranda', $halaman);
	}

	private function wajib_admin()
	{
		if ($this->session->userdata('status-masuk') != 'masuk' || $this->session->userdata('level') != 'Admin')
		{
			redirect(base_url('dashboard'));
		}
	}

	private function wajib_admin_atau_resepsionis()
	{
		if ($this->session->userdata('status-masuk') != 'masuk' || !in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE))
		{
			redirect(base_url('dashboard'));
		}
	}

	public function notifikasi_pengajuan()
	{
		$this->wajib_admin_atau_resepsionis();
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('jumlah' => $this->model_peminjaman->jumlah_menunggu())));
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD User (Dinonaktifkan di Menu - Hanya Akses Internal)
	|-----------------------------------------------------------------
	*/

	public function akun_pengguna()
	{
		redirect(base_url('dashboard'));
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD Ruangan (Khusus Superadmin)
	|-----------------------------------------------------------------
	*/

	public function data_ruangan()
	{
		$this->wajib_admin();

		$query   = $this->model_ruangan->tampil()->result_array();

		$halaman = array
		(
			'tb'   => $query,
			'hal'  => 'Kelola Data Ruangan'
		);

		$this->template->utama('pages/halaman-ruangan', $halaman);
	}

	public function daftar_ruangan()
	{
		$halaman = array
		(
			'tb'  => $this->model_ruangan->tampil()->result_array(),
			'hal' => 'Daftar Ruang Meeting'
		);

		$this->template->utama('pages/daftar-ruangan', $halaman);
	}

	public function ketersediaan_ruangan()
	{
		$rooms = $this->model_ruangan->tampil()->result_array();
		$tanggal = $this->input->get('tanggal', TRUE);
		$nama_ruangan = $this->input->get('ruangan', TRUE);
		if (!$tanggal || date('Y-m-d', strtotime($tanggal)) != $tanggal || $tanggal < date('Y-m-d'))
		{
			$tanggal = date('Y-m-d');
		}
		if (!$nama_ruangan && !empty($rooms))
		{
			$nama_ruangan = $rooms[0]['nama_ruangan'];
		}
		$room_names = array_column($rooms, 'nama_ruangan');
		if (!in_array($nama_ruangan, $room_names))
		{
			$nama_ruangan = !empty($rooms) ? $rooms[0]['nama_ruangan'] : '';
		}

		$slots = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$slots[] = sprintf('%02d:00', $hour);
		}

		$booked_slots = array();
		$elapsed_slots = array();
		if ($nama_ruangan)
		{
			$reservations = $this->model_peminjaman->slot_terpakai($nama_ruangan, $tanggal)->result_array();
			foreach ($reservations as $reservation)
			{
				$booked_slots[] = substr($reservation['jam_meeting'], 0, 5);
			}
		}
		if ($tanggal == date('Y-m-d'))
		{
			$currentHourSlot = date('H:00');
			$currentMinute = (int)date('i');

			foreach ($slots as $slot)
			{
				if ($slot < $currentHourSlot)
				{
					$elapsed_slots[] = $slot;
				}
				elseif ($slot == $currentHourSlot && $currentMinute >= 45)
				{
					$elapsed_slots[] = $slot;
				}
			}
		}

		$halaman = array
		(
			'tb'            => $rooms,
			'tb_idpinjam'   => $this->model_peminjaman->tampil_id()->result_array(),
			'slots'         => $slots,
			'booked_slots'  => $booked_slots,
			'elapsed_slots' => $elapsed_slots,
			'tanggal'       => $tanggal,
			'nama_ruangan'  => $nama_ruangan,
			'hal'           => 'Ketersediaan Ruangan'
		);

		$this->template->utama('pages/ketersediaan-ruangan', $halaman);
	}

	public function buat_ruangan()
	{
		$this->wajib_admin();

		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		$data = array
		(
			'id_ruangan'   => $id_ruangan,
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas,
			'status'       => 'Tersedia'
		);

		$query = $this->model_ruangan->buat($data);

		if ($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_ruangan()
	{
		$this->wajib_admin();

		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		$data = array
		(
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas
		);

		$where = array('id_ruangan' => $id_ruangan);
		$query = $this->model_ruangan->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_ruangan()
	{
		$this->wajib_admin();

		$id_ruangan = $this->input->post('id_ruangan');
		$where      = array('id_ruangan' => $id_ruangan);
		$query      = $this->model_ruangan->hapus($where);

		if($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD Peminjaman (Open Booking & Kelola Superadmin/Resepsionis)
	|-----------------------------------------------------------------
	*/

	public function data_peminjaman()
	{
		$this->model_peminjaman->auto_cancel_no_show();

		$filter_periode = $this->input->get('periode', TRUE);
		if (!in_array($filter_periode, array('semua', 'hari_ini', 'kemarin'), TRUE))
		{
			$filter_periode = 'semua';
		}

		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime('-1 day'));

		$this->db->order_by('id_peminjaman', 'DESC');

		if ($filter_periode == 'hari_ini')
		{
			$this->db->where('tanggal_meeting', $today);
		}
		elseif ($filter_periode == 'kemarin')
		{
			$this->db->where('tanggal_meeting', $yesterday);
		}

		$query = $this->db->get('tb_peminjaman')->result_array();
		
		$query_b = $this->model_ruangan->tampil()->result_array();
		$query_c = $this->model_peminjaman->tampil_id()->result_array();
		$selected_date = $this->input->get('tanggal_meeting', TRUE);
		if (!$selected_date || date('Y-m-d', strtotime($selected_date)) != $selected_date)
		{
			$selected_date = date('Y-m-d');
		}
		$selected_room = $this->input->get('nama_ruangan', TRUE);
		$selected_time = $this->input->get('jam_meeting', TRUE);
		$room_names = array_column($query_b, 'nama_ruangan');
		if (!in_array($selected_room, $room_names))
		{
			$selected_room = !empty($query_b) ? $query_b[0]['nama_ruangan'] : '';
		}
		$booking_slots = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$booking_slots[] = sprintf('%02d:00', $hour);
		}
		if (!in_array($selected_time, $booking_slots))
		{
			$selected_time = '';
		}
		$occupied_slots = array();
		$elapsed_booking_slots = array();
		if ($selected_room)
		{
			$rows = $this->model_peminjaman->slot_terpakai($selected_room, $selected_date)->result_array();
			foreach ($rows as $row)
			{
				$occupied_slots[] = substr($row['jam_meeting'], 0, 5);
			}
		}
		if ($selected_date == date('Y-m-d'))
		{
			$currentHourSlot = date('H:00');
			$currentMinute = (int)date('i');

			foreach ($booking_slots as $booking_slot)
			{
				if ($booking_slot < $currentHourSlot)
				{
					$elapsed_booking_slots[] = $booking_slot;
				}
				elseif ($booking_slot == $currentHourSlot && $currentMinute >= 45)
				{
					$elapsed_booking_slots[] = $booking_slot;
				}
			}
		}

		$halaman = array
		(
			'tb'                    => $query,
			'tb_ruangan'            => $query_b,
			'tb_idpinjam'           => $query_c,
			'booking_slots'         => $booking_slots,
			'occupied_slots'        => $occupied_slots,
			'elapsed_booking_slots' => $elapsed_booking_slots,
			'selected_date'         => $selected_date,
			'selected_room'         => $selected_room,
			'selected_time'         => $selected_time,
			'filter_periode'        => $filter_periode,
			'hal'                   => 'Data Peminjaman'
		);

		$this->template->utama('pages/halaman-peminjaman', $halaman);
	}

	public function laporan_peminjaman()
	{
		$this->wajib_admin();

		$tgl_awal  = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		if(empty($tgl_awal && $tgl_akhir))
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}

		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query = $this->model_peminjaman->tampil_detail($where)->result_array();

		$halaman = array
		(
			'tb'            => $query,
			'tanggal_awal'  => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal'           => 'Laporan Peminjaman'
		);

		$this->template->utama('pages/halaman-laporan', $halaman);
	}

	public function pinjam_ruang()
	{
		$id_peminjaman       = $this->input->post('id_peminjaman');
		$peminjam_post       = trim((string) $this->input->post('peminjam'));
		$w_pengajuan         = $this->input->post('waktu_pengajuan');
		$keterangan          = trim((string) $this->input->post('keterangan'));
		$nama_ruangan        = $this->input->post('nama_ruangan');
		$tanggal_meeting     = $this->input->post('tanggal_meeting');
		$jam_meeting         = $this->input->post('jam_meeting');
		$nama_peminjam       = trim((string) $this->input->post('nama_peminjam'));
		$departemen_peminjam = trim((string) $this->input->post('departemen_peminjam'));
		$telepon_peminjam    = trim((string) $this->input->post('telepon_peminjam'));

		// Pada mode Open Website, peminjam diambil dari nama_peminjam yang diisi di form
		$peminjam = !empty($nama_peminjam) ? substr($nama_peminjam, 0, 25) : (!empty($peminjam_post) ? substr($peminjam_post, 0, 25) : 'Tamu');

		$valid_slots = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$valid_slots[] = sprintf('%02d:00', $hour);
		}

		$date_parts = explode('-', (string) $tanggal_meeting);
		$date_is_valid = count($date_parts) == 3 && checkdate((int) $date_parts[1], (int) $date_parts[2], (int) $date_parts[0]);
		if (!$date_is_valid || $tanggal_meeting < date('Y-m-d') || !in_array($jam_meeting, $valid_slots))
		{
			$this->session->set_flashdata('pesan_error', 'Tanggal atau jam meeting tidak valid.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		$currentHourSlot = date('H:00');
		$currentMinute = (int)date('i');

		if ($tanggal_meeting == date('Y-m-d'))
		{
			if ($jam_meeting < $currentHourSlot || ($jam_meeting == $currentHourSlot && $currentMinute >= 45))
			{
				$this->session->set_flashdata('pesan_error', 'Jam meeting tersebut sudah lewat atau sisa waktu terlalu mepet (<15 menit). Silakan pilih jam lain.');
				redirect(base_url('dashboard/data-peminjaman'));
				return;
			}
		}

		$room_exists = $this->db->get_where('tb_ruangan', array('nama_ruangan' => $nama_ruangan))->num_rows() > 0;
		if (!$room_exists || $this->model_peminjaman->slot_sudah_dipesan($nama_ruangan, $tanggal_meeting, $jam_meeting . ':00'))
		{
			$this->session->set_flashdata('pesan_error', 'Slot ruangan tersebut baru saja dipesan orang lain. Silakan pilih ruang atau jam lain.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}
		
		$data_isi = array
		(
			'id_peminjaman'       => $id_peminjaman,
			'peminjam'            => $peminjam,
			'nama_peminjam'       => $nama_peminjam,
			'departemen_peminjam' => $departemen_peminjam,
			'telepon_peminjam'    => $telepon_peminjam,
			'waktu_pengajuan'     => !empty($w_pengajuan) ? $w_pengajuan : date('Y-m-d H:i:s'),
			'tanggal_meeting'     => $tanggal_meeting,
			'jam_meeting'         => $jam_meeting,
			'keterangan'          => $keterangan,
			'ruangan_dipinjam'    => $nama_ruangan,
			'verifikasi_bp'       => '-',
			'verifikasi_kabag'    => '-',
			'status_pinjam'       => 'Menunggu'
		);

		$query = $this->model_peminjaman->buat($data_isi);

		if ($query)
		{
			$this->session->set_flashdata('pesan_sukses', 'Pengajuan booking Ruang ' . $nama_ruangan . ' (' . date('d/m/Y', strtotime($tanggal_meeting)) . ' pukul ' . $jam_meeting . ' WIB) atas nama ' . $nama_peminjam . ' berhasil dikirim!');
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			$this->session->set_flashdata('pesan_error', 'Proses penambahan data peminjaman gagal.');
			redirect(base_url('dashboard/data-peminjaman'));
		}
	}

	public function perbarui_peminjaman()
	{
		$this->wajib_admin_atau_resepsionis();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$keterangan    = $this->input->post('keterangan');
		
		$data  = array('keterangan' => $keterangan);
		$where = array('id_peminjaman' => $id_peminjaman);
		$query = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function verifikasi_bp()
	{
		$this->wajib_admin();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$data          = array('verifikasi_bp' => 'OK');
		$where         = array('id_peminjaman' => $id_peminjaman);
		$query         = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function verifikasi_kabag()
	{
		$this->wajib_admin();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$data          = array('verifikasi_kabag' => 'OK');
		$where         = array('id_peminjaman' => $id_peminjaman);
		$query         = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function setujui_peminjaman()
	{
		$this->wajib_admin_atau_resepsionis();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_penyetujuan = $this->input->post('waktu_penyetujuan');
		
		$data_isi = array
		(
			'waktu_penyetujuan' => $w_penyetujuan,
			'verifikasi_bp'     => 'OK',
			'verifikasi_kabag'  => 'OK',
			'status_pinjam'     => 'Disetujui'
		);

		$where = array('id_peminjaman' => $id_peminjaman);
		$query = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function batalkan_peminjaman()
	{
		$this->wajib_admin_atau_resepsionis();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_pembatalan  = $this->input->post('waktu_pembatalan');
		
		$data_isi = array
		(
			'waktu_pembatalan' => $w_pembatalan,
			'status_pinjam'    => 'Dibatalkan'
		);

		$where = array('id_peminjaman' => $id_peminjaman);
		$query = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function selesaikan_peminjaman()
	{
		$this->wajib_admin_atau_resepsionis();

		$id_peminjaman  = $this->input->post('id_peminjaman');
		$w_pengembalian = $this->input->post('waktu_pengembalian');
		
		$data_isi = array
		(
			'waktu_pengembalian' => $w_pengembalian,
			'status_pinjam'      => 'Selesai'
		);

		$where = array('id_peminjaman' => $id_peminjaman);
		$query = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_peminjaman()
	{
		$this->wajib_admin();

		$id_peminjaman = $this->input->post('id_peminjaman');
		$where         = array('id_peminjaman' => $id_peminjaman);
		$query         = $this->model_peminjaman->hapus($where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Riwayat Akses Ruangan (Khusus Superadmin & Resepsionis)
	|-----------------------------------------------------------------
	*/

	public function akses_ruangan()
	{
		$this->wajib_admin_atau_resepsionis();

		$query = $this->model_tap->tampil()->result_array();

		$halaman = array
		(
			'tb'  => $query,
			'hal' => 'Riwayat Akses Ruangan'
		);

		$this->template->utama('pages/halaman-akses-ruangan', $halaman);
	}


	/*
	|-----------------------------------------------------------------
	| Fitur Unduh Data
	|-----------------------------------------------------------------
	*/

	public function unduh_akses_ruangan()
	{
		$this->wajib_admin_atau_resepsionis();

		$query = $this->model_tap->tampil()->result_array();

		$halaman = array
		(
			'tb'  => $query,
			'hal' => 'Riwayat Akses Ruangan'
		);

		$this->load->view('pages/unduh-akses-ruangan', $halaman);
	}

	public function unduh_laporan_peminjaman()
	{
		$this->wajib_admin();

		$tgl_awal  = $this->input->post('tanggal_awal');
		$tgl_akhir = $this->input->post('tanggal_akhir');

		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query = $this->model_peminjaman->tampil_detail($where)->result_array();

		$halaman = array
		(
			'tb'            => $query,
			'tanggal_awal'  => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal'           => 'Laporan Peminjaman'
		);

		$this->load->view('pages/unduh-laporan', $halaman);
	}


	/*
	|-----------------------------------------------------------------
	| Fitur Logout Petugas (Superadmin / Resepsionis)
	|-----------------------------------------------------------------
	*/

	public function logout()
	{
		$sesi = array
		(
			'namalengkap',
			'level',
			'status-masuk'
		);

		$this->session->unset_userdata($sesi);

		redirect(base_url('dashboard'));
	}

	/*
	|-----------------------------------------------------------------
	| Fitur Verifikasi Check-In Ruangan (Tombol / QR Code - Open Access)
	|-----------------------------------------------------------------
	*/

	public function checkin_ruangan()
	{
		$id_peminjaman = $this->input->post('id_peminjaman', TRUE);
		$this->proses_checkin($id_peminjaman);
	}

	public function scan_qr($room_key = '')
	{
		if (empty($room_key))
		{
			show_404();
		}

		$room = $this->db->get_where('tb_ruangan', array('room_qr_key' => $room_key))->row_array();
		if (!$room)
		{
			show_error('QR Code Ruangan tidak valid!', 400);
		}

		$today = date('Y-m-d');

		// Cari booking aktif yang sudah disetujui untuk ruangan ini hari ini
		$this->db->where('ruangan_dipinjam', $room['nama_ruangan']);
		$this->db->where('tanggal_meeting', $today);
		$this->db->where('status_pinjam', 'Disetujui');
		$this->db->where('waktu_checkin IS NULL', NULL, FALSE);
		$this->db->order_by('jam_meeting', 'ASC');
		$active_booking = $this->db->get('tb_peminjaman')->row_array();

		if ($active_booking)
		{
			$meeting_start = strtotime($active_booking['tanggal_meeting'] . ' ' . $active_booking['jam_meeting']);
			$now = time();
			$tolerance_limit = $meeting_start + (10 * 60);

			if ($now < $meeting_start)
			{
				$this->session->set_flashdata('pesan_error', 'Belum waktunya check-in. Check-in hanya bisa dilakukan mulai jam ' . substr($active_booking['jam_meeting'], 0, 5) . '.');
			}
			elseif ($now > $tolerance_limit)
			{
				$this->model_peminjaman->perbarui(array(
					'status_pinjam' => 'Dibatalkan',
					'waktu_pembatalan' => date('Y-m-d H:i:s'),
					'keterangan' => $active_booking['keterangan'] . ' [Auto-Cancel: Melewati batas check-in 10 menit]'
				), array('id_peminjaman' => $active_booking['id_peminjaman']));

				$this->session->set_flashdata('pesan_error', 'Batas check-in 10 menit telah habis. Booking dibatalkan.');
			}
			else
			{
				$waktu_sekarang = date('Y-m-d H:i:s');
				$this->model_peminjaman->perbarui(array('waktu_checkin' => $waktu_sekarang), array('id_peminjaman' => $active_booking['id_peminjaman']));

				$nama_log = !empty($active_booking['nama_peminjam']) ? $active_booking['nama_peminjam'] : $active_booking['peminjam'];
				$this->db->insert('tb_tap', array(
					'id_kartu'     => 'QR-' . substr($nama_log, 0, 10),
					'nama_ruangan' => $room['nama_ruangan'],
					'waktu_akses'  => $waktu_sekarang,
					'waktu_tutup'  => '0000-00-00 00:00:00',
					'status_akses' => 'Dibuka'
				));

				$this->session->set_flashdata('pesan_sukses', 'Check-in via Scan QR Berhasil untuk Ruang ' . $room['nama_ruangan'] . '!');
			}
		}
		else
		{
			$this->session->set_flashdata('pesan_error', 'Tidak ada jadwal booking aktif yang membutuhkan check-in untuk Ruangan ' . $room['nama_ruangan']);
		}

		redirect(base_url('dashboard/data-peminjaman'));
	}

	public function qr_ruangan($room_key = '')
	{
		$room = $this->db->get_where('tb_ruangan', array('room_qr_key' => $room_key))->row_array();
		if (!$room)
		{
			show_404();
		}

		$halaman = array(
			'hal'  => 'QR Code Ruangan ' . $room['nama_ruangan'],
			'room' => $room
		);

		$this->load->view('pages/qr-ruangan', $halaman);
	}

	public function proses_checkin($id_peminjaman = '')
	{
		if (empty($id_peminjaman))
		{
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		$booking = $this->db->get_where('tb_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();

		if (!$booking)
		{
			$this->session->set_flashdata('pesan_error', 'Data peminjaman tidak ditemukan.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		if ($booking['status_pinjam'] != 'Disetujui')
		{
			$this->session->set_flashdata('pesan_error', 'Peminjaman belum disetujui atau sudah tidak aktif.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		if (!empty($booking['waktu_checkin']))
		{
			$this->session->set_flashdata('pesan_sukses', 'Ruangan sudah di-check in sebelumnya pada ' . date('H:i', strtotime($booking['waktu_checkin'])));
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		$meeting_start = strtotime($booking['tanggal_meeting'] . ' ' . $booking['jam_meeting']);
		$now = time();
		$tolerance_limit = $meeting_start + (10 * 60);
		$today = date('Y-m-d');

		// 1. Cek jika belum hari H atau belum jamnya
		if ($booking['tanggal_meeting'] != $today || $now < $meeting_start)
		{
			$this->session->set_flashdata('pesan_error', 'Belum waktunya check-in. Check-in hanya dapat dilakukan pada hari meeting mulai jam ' . substr($booking['jam_meeting'], 0, 5) . '.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// 2. Cek apakah sudah lewat 10 menit dari jadwal booking
		if ($now > $tolerance_limit)
		{
			$this->model_peminjaman->perbarui(array(
				'status_pinjam' => 'Dibatalkan',
				'waktu_pembatalan' => date('Y-m-d H:i:s'),
				'keterangan' => $booking['keterangan'] . ' [Auto-Cancel: Melewati batas check-in 10 menit]'
			), array('id_peminjaman' => $id_peminjaman));

			$this->session->set_flashdata('pesan_error', 'Maaf, batas waktu check-in (10 menit setelah jam booking) telah habis. Ruangan otomatis dibatalkan.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// Lakukan Check-In Berhasil
		$waktu_sekarang = date('Y-m-d H:i:s');
		$this->model_peminjaman->perbarui(array('waktu_checkin' => $waktu_sekarang), array('id_peminjaman' => $id_peminjaman));

		$nama_log = !empty($booking['nama_peminjam']) ? $booking['nama_peminjam'] : $booking['peminjam'];
		$this->db->insert('tb_tap', array(
			'id_kartu'     => 'CHECKIN-' . substr($nama_log, 0, 10),
			'nama_ruangan' => $booking['ruangan_dipinjam'],
			'waktu_akses'  => $waktu_sekarang,
			'waktu_tutup'  => '0000-00-00 00:00:00',
			'status_akses' => 'Dibuka'
		));

		$this->session->set_flashdata('pesan_sukses', 'Verifikasi Check-in Berhasil! Ruangan ' . $booking['ruangan_dipinjam'] . ' resmi digunakan.');
		redirect(base_url('dashboard/data-peminjaman'));
	}

	// ==========================================
	// FITUR INTEGRASI KALENDER & EKSPOR LAPORAN
	// ==========================================

	public function kalender_google($id_peminjaman = '')
	{
		$booking = $this->db->get_where('tb_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();
		if (!$booking)
		{
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		$jam = !empty($booking['jam_meeting']) ? $booking['jam_meeting'] : '09:00:00';
		$tgl = !empty($booking['tanggal_meeting']) ? $booking['tanggal_meeting'] : date('Y-m-d');
		
		$start_ts = strtotime($tgl . ' ' . $jam);
		$end_ts   = $start_ts + 3600;

		$dtstart = gmdate('Ymd\THis\Z', $start_ts);
		$dtend   = gmdate('Ymd\THis\Z', $end_ts);

		$peminjam_label = !empty($booking['nama_peminjam']) ? $booking['nama_peminjam'] : $booking['peminjam'];
		$dept_label     = !empty($booking['departemen_peminjam']) ? $booking['departemen_peminjam'] : 'Umum';

		$title   = 'Meeting: ' . $booking['keterangan'] . ' (' . $booking['ruangan_dipinjam'] . ')';
		$details = "Agenda Meeting: " . $booking['keterangan'] . "\n"
		         . "Peminjam: " . $peminjam_label . " (" . $dept_label . ")\n"
		         . "Ruangan: " . $booking['ruangan_dipinjam'] . "\n"
		         . "ID Booking: " . $booking['id_peminjaman'] . "\n"
		         . "Sistem Peminjaman Ruang Meeting PT Medquest Jaya Global";
		$loc     = "Ruang " . $booking['ruangan_dipinjam'] . ", PT Medquest Jaya Global";

		$url = "https://calendar.google.com/calendar/render?action=TEMPLATE"
		     . "&text=" . urlencode($title)
		     . "&dates=" . $dtstart . "/" . $dtend
		     . "&details=" . urlencode($details)
		     . "&location=" . urlencode($loc);

		redirect($url);
	}

	public function kalender_ics($id_peminjaman = '')
	{
		$booking = $this->db->get_where('tb_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();
		if (!$booking)
		{
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		$jam = !empty($booking['jam_meeting']) ? $booking['jam_meeting'] : '09:00:00';
		$tgl = !empty($booking['tanggal_meeting']) ? $booking['tanggal_meeting'] : date('Y-m-d');
		
		$start_ts = strtotime($tgl . ' ' . $jam);
		$end_ts   = $start_ts + 3600;

		$dtstamp = gmdate('Ymd\THis\Z');
		$dtstart = gmdate('Ymd\THis\Z', $start_ts);
		$dtend   = gmdate('Ymd\THis\Z', $end_ts);

		$peminjam_label = !empty($booking['nama_peminjam']) ? $booking['nama_peminjam'] : $booking['peminjam'];
		$dept_label     = !empty($booking['departemen_peminjam']) ? $booking['departemen_peminjam'] : 'Umum';

		$summary = 'Meeting: ' . $booking['keterangan'] . ' (' . $booking['ruangan_dipinjam'] . ')';
		$desc    = 'Agenda: ' . $booking['keterangan'] . '\nPeminjam: ' . $peminjam_label . ' (' . $dept_label . ')\nID: ' . $booking['id_peminjaman'] . '\nPT Medquest Jaya Global';
		$loc     = 'Ruang ' . $booking['ruangan_dipinjam'] . ', PT Medquest Jaya Global';

		$ics  = "BEGIN:VCALENDAR\r\n";
		$ics .= "VERSION:2.0\r\n";
		$ics .= "PRODID:-//PT Medquest Jaya Global//Meeting Room Booking//ID\r\n";
		$ics .= "CALSCALE:GREGORIAN\r\n";
		$ics .= "METHOD:PUBLISH\r\n";
		$ics .= "BEGIN:VEVENT\r\n";
		$ics .= "UID:booking-" . $booking['id_peminjaman'] . "@medquest.co.id\r\n";
		$ics .= "DTSTAMP:" . $dtstamp . "\r\n";
		$ics .= "DTSTART:" . $dtstart . "\r\n";
		$ics .= "DTEND:" . $dtend . "\r\n";
		$ics .= "SUMMARY:" . str_replace(array("\r", "\n"), " ", $summary) . "\r\n";
		$ics .= "DESCRIPTION:" . str_replace(array("\r", "\n"), array("", "\\n"), $desc) . "\r\n";
		$ics .= "LOCATION:" . $loc . "\r\n";
		$ics .= "STATUS:CONFIRMED\r\n";
		$ics .= "END:VEVENT\r\n";
		$ics .= "END:VCALENDAR\r\n";

		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="Meeting-Medquest-' . $booking['id_peminjaman'] . '.ics"');
		echo $ics;
		exit;
	}

	public function ekspor_excel()
	{
		$this->wajib_admin_atau_resepsionis();
		$this->model_peminjaman->auto_cancel_no_show();

		$periode = $this->input->get('periode', TRUE);
		if (!in_array($periode, array('hari_ini', 'kemarin', 'semua'), TRUE))
		{
			$periode = 'semua';
		}

		$format = $this->input->get('format', TRUE);
		if ($format != 'xls')
		{
			$format = 'csv';
		}

		$this->db->order_by('tanggal_meeting', 'DESC');
		$this->db->order_by('jam_meeting', 'DESC');

		if ($periode == 'hari_ini')
		{
			$this->db->where('tanggal_meeting', date('Y-m-d'));
		}
		elseif ($periode == 'kemarin')
		{
			$this->db->where('tanggal_meeting', date('Y-m-d', strtotime('-1 day')));
		}

		$data = $this->db->get('tb_peminjaman')->result_array();

		if (ob_get_level())
		{
			ob_end_clean();
		}

		if ($format == 'xls')
		{
			$filename = 'Laporan_Peminjaman_Medquest_' . $periode . '.xls';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Transfer-Encoding: binary');

			echo "\xEF\xBB\xBF";
			echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>';
			echo 'table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }';
			echo 'th { background-color: #0284c7; color: #ffffff; border: 1px solid #0f172a; padding: 10px; font-weight: bold; text-align: left; }';
			echo 'td { border: 1px solid #cbd5e1; padding: 8px 10px; font-size: 11pt; vertical-align: top; }';
			echo '.text-center { text-align: center; }';
			echo '.title { font-size: 16pt; font-weight: bold; color: #0f172a; }';
			echo '.subtitle { font-size: 11pt; color: #64748b; margin-bottom: 12px; }';
			echo '</style></head><body>';
			echo '<div class="title">PT MEDQUEST JAYA GLOBAL</div>';
			echo '<div class="subtitle">Rekapitulasi Peminjaman Ruang Meeting (Periode: ' . ucfirst(str_replace('_', ' ', $periode)) . ') - Diunduh: ' . date('d/m/Y H:i') . ' WIB</div><br/>';
			echo '<table border="1">';
			echo '<thead><tr>';
			echo '<th class="text-center" style="width: 40px;">No</th>';
			echo '<th>ID Booking</th>';
			echo '<th>Tanggal Meeting</th>';
			echo '<th>Jam Mulai</th>';
			echo '<th>Ruang Meeting</th>';
			echo '<th>Agenda / Keterangan</th>';
			echo '<th>Nama Peminjam</th>';
			echo '<th>Departemen</th>';
			echo '<th>No Telepon</th>';
			echo '<th class="text-center">Status</th>';
			echo '<th class="text-center">Waktu Check-In</th>';
			echo '<th>Waktu Pengajuan</th>';
			echo '<th>Waktu Disetujui</th>';
			echo '<th>Waktu Dibatalkan</th>';
			echo '</tr></thead><tbody>';

			if (empty($data)) {
				echo '<tr><td colspan="14" class="text-center" style="padding: 20px;">Tidak ada data peminjaman untuk periode ini.</td></tr>';
			} else {
				$no = 1;
				foreach ($data as $row) {
					$pem = !empty($row['nama_peminjam']) ? $row['nama_peminjam'] : $row['peminjam'];
					$dept = !empty($row['departemen_peminjam']) ? $row['departemen_peminjam'] : '-';
					$telp = !empty($row['telepon_peminjam']) ? $row['telepon_peminjam'] : '-';
					$tgl = !empty($row['tanggal_meeting']) ? date('d/m/Y', strtotime($row['tanggal_meeting'])) : '-';
					$jam = !empty($row['jam_meeting']) ? substr($row['jam_meeting'], 0, 5) . ' WIB' : '-';
					$checkin = !empty($row['waktu_checkin']) ? date('d/m/Y H:i', strtotime($row['waktu_checkin'])) : 'Belum Check-In';
					$ajukan = !empty($row['waktu_pengajuan']) ? date('d/m/Y H:i', strtotime($row['waktu_pengajuan'])) : '-';
					$setuju = !empty($row['waktu_penyetujuan']) ? date('d/m/Y H:i', strtotime($row['waktu_penyetujuan'])) : '-';
					$batal = !empty($row['waktu_pembatalan']) ? date('d/m/Y H:i', strtotime($row['waktu_pembatalan'])) : '-';

					echo '<tr>';
					echo '<td class="text-center">' . $no++ . '</td>';
					echo '<td>' . htmlspecialchars($row['id_peminjaman']) . '</td>';
					echo '<td>' . $tgl . '</td>';
					echo '<td>' . $jam . '</td>';
					echo '<td><strong>' . htmlspecialchars($row['ruangan_dipinjam']) . '</strong></td>';
					echo '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
					echo '<td>' . htmlspecialchars($pem) . '</td>';
					echo '<td>' . htmlspecialchars($dept) . '</td>';
					echo '<td>' . htmlspecialchars($telp) . '</td>';
					echo '<td class="text-center">' . htmlspecialchars($row['status_pinjam']) . '</td>';
					echo '<td class="text-center">' . $checkin . '</td>';
					echo '<td>' . $ajukan . '</td>';
					echo '<td>' . $setuju . '</td>';
					echo '<td>' . $batal . '</td>';
					echo '</tr>';
				}
			}
			echo '</tbody></table></body></html>';
			exit;
		}

		// FORMAT CSV
		$filename = 'Laporan_Peminjaman_Medquest_' . $periode . '.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');

		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
		fwrite($output, "sep=;\r\n");

		fputcsv($output, array(
			'No',
			'ID Booking',
			'Tanggal Meeting',
			'Jam Mulai',
			'Ruang Meeting',
			'Agenda / Keterangan',
			'Nama Peminjam',
			'Departemen',
			'No Telepon',
			'Status Pengajuan',
			'Waktu Check-In',
			'Waktu Pengajuan',
			'Waktu Disetujui',
			'Waktu Dibatalkan'
		), ';');

		$no = 1;
		foreach ($data as $row) {
			$pem = !empty($row['nama_peminjam']) ? $row['nama_peminjam'] : $row['peminjam'];
			$dept = !empty($row['departemen_peminjam']) ? $row['departemen_peminjam'] : '-';
			$telp = !empty($row['telepon_peminjam']) ? $row['telepon_peminjam'] : '-';
			$tgl = !empty($row['tanggal_meeting']) ? date('d/m/Y', strtotime($row['tanggal_meeting'])) : '-';
			$jam = !empty($row['jam_meeting']) ? substr($row['jam_meeting'], 0, 5) . ' WIB' : '-';
			$checkin = !empty($row['waktu_checkin']) ? date('d/m/Y H:i', strtotime($row['waktu_checkin'])) : 'Belum Check-In';
			$ajukan = !empty($row['waktu_pengajuan']) ? date('d/m/Y H:i', strtotime($row['waktu_pengajuan'])) : '-';
			$setuju = !empty($row['waktu_penyetujuan']) ? date('d/m/Y H:i', strtotime($row['waktu_penyetujuan'])) : '-';
			$batal = !empty($row['waktu_pembatalan']) ? date('d/m/Y H:i', strtotime($row['waktu_pembatalan'])) : '-';

			fputcsv($output, array(
				$no++,
				$row['id_peminjaman'],
				$tgl,
				$jam,
				$row['ruangan_dipinjam'],
				$row['keterangan'],
				$pem,
				$dept,
				$telp,
				$row['status_pinjam'],
				$checkin,
				$ajukan,
				$setuju,
				$batal
			), ';');
		}

		fclose($output);
		exit;
	}

	public function cetak_laporan()
	{
		$this->wajib_admin_atau_resepsionis();
		$this->model_peminjaman->auto_cancel_no_show();

		$periode = $this->input->get('periode', TRUE);
		if (!in_array($periode, array('hari_ini', 'kemarin', 'semua'), TRUE))
		{
			$periode = 'semua';
		}

		$this->db->order_by('tanggal_meeting', 'DESC');
		$this->db->order_by('jam_meeting', 'DESC');

		if ($periode == 'hari_ini')
		{
			$this->db->where('tanggal_meeting', date('Y-m-d'));
		}
		elseif ($periode == 'kemarin')
		{
			$this->db->where('tanggal_meeting', date('Y-m-d', strtotime('-1 day')));
		}

		$data['peminjaman'] = $this->db->get('tb_peminjaman')->result_array();
		$data['periode'] = $periode;
		$data['tanggal_cetak'] = date('d F Y, H:i') . ' WIB';
		$data['dicetak_oleh'] = $this->session->userdata('namalengkap') . ' (' . $this->session->userdata('level') . ')';

		$this->load->view('pages/cetak-laporan', $data);
	}

	public function panduan()
	{
		$this->model_peminjaman->auto_cancel_no_show();
		$halaman['hal'] = "Buku Panduan";
		$this->template->utama('pages/halaman-panduan', $halaman);
	}

	public function status_ruangan_realtime()
	{
		date_default_timezone_set('Asia/Jakarta');
		$today = date('Y-m-d');
		$now_time = date('H:i:s');

		$rooms = $this->model_ruangan->tampil()->result_array();
		$result = array();

		foreach ($rooms as $r) {
			$status_text = $r['status'];
			$is_busy = false;

			if ($r['status'] == 'Tersedia') {
				$active_meeting = $this->db
					->where('ruangan_dipinjam', $r['nama_ruangan'])
					->where('tanggal_meeting', $today)
					->where('jam_meeting <=', $now_time)
					->where("ADDTIME(jam_meeting, '01:00:00') >", $now_time)
					->where_not_in('status_pinjam', array('Dibatalkan', 'Selesai'))
					->get('tb_peminjaman')
					->row_array();

				if ($active_meeting) {
					$status_text = 'Sedang Digunakan';
					$is_busy = true;
				} else {
					$status_text = 'Tersedia';
					$is_busy = false;
				}
			}

			$result[] = array(
				'id_ruangan'   => $r['id_ruangan'],
				'nama_ruangan' => $r['nama_ruangan'],
				'status'       => $status_text,
				'is_busy'      => $is_busy
			);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}
}
