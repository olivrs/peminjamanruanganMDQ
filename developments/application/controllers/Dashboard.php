<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		// Memanggil library untuk templating halaman
		$this->load->library('template');

		// Pemeriksaan session masuk (login)
		if($this->session->userdata('status-masuk') != 'masuk')
		{
			redirect(base_url());
		}

		// Memanggil Model
		$this->load->model('model_user');
		$this->load->model('model_ruangan');
		$this->load->model('model_peminjaman');
		$this->load->model('model_tap');
	}

	public function index()
	{
		$this->model_peminjaman->auto_cancel_no_show();

		$halaman['hal'] = "Beranda";
		$rooms = $this->model_ruangan->tampil()->result_array();
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
		if ($this->session->userdata('level') != 'Admin')
		{
			redirect(base_url('dashboard'));
		}
	}

	private function wajib_admin_atau_resepsionis()
	{
		if (!in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE))
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
	| Fitur CRUD User
	|-----------------------------------------------------------------
	*/

	public function akun_pengguna()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model User
		$query   = $this->model_user->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'   => $query,
			'hal'  => 'Kelola Akun Pengguna'
		);

		$this->template->utama('pages/halaman-user', $halaman);
	}

	public function buat_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = trim($this->input->post('fullname') ?? '');
		$username = trim($this->input->post('username') ?? '');
		$password = $this->input->post('password') ?? '';
		$level    = $this->input->post('level') ?? '';

		if (!in_array($level, array('Admin', 'Resepsionis', 'Pengguna'), TRUE))
		{
			redirect(base_url('dashboard/akun-pengguna'));
			return;
		}

		if (empty($fullname) || empty($username) || empty($password))
		{
			redirect(base_url('dashboard/akun-pengguna'));
			return;
		}

		// Cek duplikasi username
		$cek = $this->model_user->lihat(array('username' => $username))->num_rows();
		if ($cek > 0)
		{
			echo "<script>alert('Username sudah digunakan! Silakan gunakan username lain.'); window.location.href='" . base_url('dashboard/akun-pengguna') . "';</script>";
			return;
		}

		// Data yang akan disimpan/dibuat
		$data = array(
			'fullname' => $fullname,
			'username' => $username,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'level'    => $level
		);

		$query = $this->model_user->buat($data);

		if ($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
			return;
		}
		else
		{
			echo "Proses penambahan data gagal.";
			return;
		}
	}

	public function perbarui_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$level    = $this->input->post('level');
		if (!in_array($level, array('Admin', 'Resepsionis', 'Pengguna'), TRUE))
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		
		// Data yang akan diperbarui
		$data     = array
		(
			'fullname' => $fullname,
			'level'    => $level
		);

		// Username digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('username' => $username);

		$query    = $this->model_user->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$username = $this->input->post('username');

		// Username digunakan sebagai pengenal data mana yang akan dihapus
		$where   = array('username' => $username);

		$query   = $this->model_user->hapus($where);

		if($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD Ruangan
	|-----------------------------------------------------------------
	*/

	public function data_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Ruangan
		$query   = $this->model_ruangan->tampil()->result_array();

		// Data disimpan sementara pada array
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
					// Jam sebelumnya pasti sudah lewat total
					$elapsed_slots[] = $slot;
				}
				elseif ($slot == $currentHourSlot && $currentMinute >= 45)
				{
					// Jika sudah menit ke-45 ke atas dari jam berjalan, sisa waktu terlalu mepet
					$elapsed_slots[] = $slot;
				}
			}
		}

		$halaman = array
		(
			'tb'           => $rooms,
			'slots'        => $slots,
			'booked_slots' => $booked_slots,
			'elapsed_slots' => $elapsed_slots,
			'tanggal'      => $tanggal,
			'nama_ruangan' => $nama_ruangan,
			'hal'          => 'Ketersediaan Ruangan'
		);

		$this->template->utama('pages/ketersediaan-ruangan', $halaman);
	}

	public function buat_ruangan()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		// Data yang akan disimpan/dibuat
		$data     = array
		(
			'id_ruangan'   => $id_ruangan,
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas,
			'status'       => 'Tersedia'
		);

		$query    = $this->model_ruangan->buat($data);

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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		// Data yang akan diperbarui
		$data     = array
		(
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas
		);

		// ID ruangan digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_ruangan' => $id_ruangan);

		$query    = $this->model_ruangan->perbarui($data, $where);

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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan = $this->input->post('id_ruangan');

		// ID ruangan digunakan sebagai pengenal data mana yang akan dihapus
		$where   = array('id_ruangan' => $id_ruangan);

		$query   = $this->model_ruangan->hapus($where);

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
	| Fitur CRUD Peminjaman
	|-----------------------------------------------------------------
	*/

	public function data_peminjaman()
	{
		$this->model_peminjaman->auto_cancel_no_show();

		// Filter Waktu: 'semua', 'hari_ini', 'kemarin' (Default: 'hari_ini' agar cepat dan rapi)
		$filter_periode = $this->input->get('periode', TRUE);
		if (!in_array($filter_periode, array('semua', 'hari_ini', 'kemarin'), TRUE))
		{
			$filter_periode = 'semua'; // default menampilkan semua data atau bisa difilter
		}

		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime('-1 day'));

		$this->db->order_by('id_peminjaman', 'DESC');
		if ($this->session->userdata('level') == "Pengguna")
		{
			$this->db->where('peminjam', $this->session->userdata('namalengkap'));
		}

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

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'          => $query,
			'tb_ruangan'  => $query_b,
			'tb_idpinjam' => $query_c,
			'booking_slots' => $booking_slots,
			'occupied_slots' => $occupied_slots,
			'elapsed_booking_slots' => $elapsed_booking_slots,
			'selected_date' => $selected_date,
			'selected_room' => $selected_room,
			'selected_time' => $selected_time,
			'filter_periode' => $filter_periode,
			'hal'         => 'Data Peminjaman'
		);

		$this->template->utama('pages/halaman-peminjaman', $halaman);
	}

	public function laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal  = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		// Mencegah halaman diakses langsung melalui tautan dengan kondisi data yang kosong
		if(empty($tgl_awal && $tgl_akhir))
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query     = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
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
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$peminjam      = $this->input->post('peminjam');
		$w_pengajuan   = $this->input->post('waktu_pengajuan');
		$keterangan    = $this->input->post('keterangan');
		$nama_ruangan  = $this->input->post('nama_ruangan');
		$tanggal_meeting = $this->input->post('tanggal_meeting');
		$jam_meeting   = $this->input->post('jam_meeting');
		$nama_peminjam = trim((string) $this->input->post('nama_peminjam'));
		$departemen_peminjam = trim((string) $this->input->post('departemen_peminjam'));
		$telepon_peminjam = trim((string) $this->input->post('telepon_peminjam'));
		$valid_slots   = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$valid_slots[] = sprintf('%02d:00', $hour);
		}

		$date_parts = explode('-', (string) $tanggal_meeting);
		$date_is_valid = count($date_parts) == 3 && checkdate((int) $date_parts[1], (int) $date_parts[2], (int) $date_parts[0]);
		if (!$date_is_valid || $tanggal_meeting < date('Y-m-d') || !in_array($jam_meeting, $valid_slots))
		{
			echo 'Tanggal atau jam meeting tidak valid.';
			return;
		}

		$currentHourSlot = date('H:00');
		$currentMinute = (int)date('i');

		if ($tanggal_meeting == date('Y-m-d'))
		{
			if ($jam_meeting < $currentHourSlot || ($jam_meeting == $currentHourSlot && $currentMinute >= 45))
			{
				echo 'Jam meeting tersebut sudah lewat atau sisa waktu terlalu mepet (<15 menit). Silakan pilih jam lain.';
				return;
			}
		}

		$room_exists = $this->db->get_where('tb_ruangan', array('nama_ruangan' => $nama_ruangan))->num_rows() > 0;
		if (!$room_exists || $this->model_peminjaman->slot_sudah_dipesan($nama_ruangan, $tanggal_meeting, $jam_meeting . ':00'))
		{
			echo 'Slot tersebut baru saja dipesan. Silakan pilih ruang atau jam lain.';
			return;
		}
		
		// Data yang akan disimpan/dibuat
		$data_isi = array
		(
			'id_peminjaman'    => $id_peminjaman,
			'peminjam'         => $peminjam,
			'nama_peminjam'    => $nama_peminjam,
			'departemen_peminjam' => $departemen_peminjam,
			'telepon_peminjam' => $telepon_peminjam,
			'waktu_pengajuan'  => $w_pengajuan,
			'tanggal_meeting'  => $tanggal_meeting,
			'jam_meeting'      => $jam_meeting,
			'keterangan'       => $keterangan,
			'ruangan_dipinjam' => $nama_ruangan,
			'verifikasi_bp'    => '-',
			'verifikasi_kabag' => '-',
			'status_pinjam'    => 'Menunggu'
		);

		$query    = $this->model_peminjaman->buat($data_isi);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_peminjaman()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$keterangan    = $this->input->post('keterangan');
		
		// Data yang akan diperbarui
		$data  = array('keterangan' => $keterangan);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		
		// Pengubahan status pada tabel peminjaman dari "-" menjadi "OK"
		// Data yang akan diperbarui
		$data = array
		(
			'verifikasi_bp'     => 'OK'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data, $where);

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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		
		// Pengubahan status pada tabel peminjaman dari "-" menjadi "OK"
		// Data yang akan diperbarui
		$data = array
		(
			'verifikasi_kabag'     => 'OK'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data, $where);

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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_penyetujuan = $this->input->post('waktu_penyetujuan');
		
		// Pengubahan status pada tabel peminjaman dari "Menunggu" menjadi "Disetujui"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_penyetujuan' => $w_penyetujuan,
			'verifikasi_bp'     => 'OK',
			'verifikasi_kabag'  => 'OK',
			'status_pinjam'     => 'Disetujui'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

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
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_pembatalan  = $this->input->post('waktu_pembatalan');
		
		// Pengubahan status pada tabel peminjaman dari "Menunggu" menjadi "Dibatalkan"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pembatalan' => $w_pembatalan,
			'status_pinjam'    => 'Dibatalkan'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

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

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman  = $this->input->post('id_peminjaman');
		$w_pengembalian = $this->input->post('waktu_pengembalian');
		
		// Pengubahan status pada tabel peminjaman dari "Disetujui" menjadi "Selesai"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pengembalian' => $w_pengembalian,
			'status_pinjam'      => 'Selesai'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

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

		// Menerima input dan lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');

		// ID peminjaman digunakan sebagai pengenal data mana yang akan dihapus
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->hapus($where);

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
	| Riwayat Akses Ruangan
	|-----------------------------------------------------------------
	*/

	public function akses_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman (Admin & Resepsionis)
		if(!in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE))
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Tap
		$query   = $this->model_tap->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'hal'           => 'Riwayat Akses Ruangan'
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
		// Membatasi level pengguna yang dapat mengakses halaman (Admin & Resepsionis)
		if(!in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE))
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Tap
		$query   = $this->model_tap->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'hal'           => 'Riwayat Akses Ruangan'
		);

		$this->load->view('pages/unduh-akses-ruangan', $halaman);
	}

	public function unduh_laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal  = $this->input->post('tanggal_awal');
		$tgl_akhir = $this->input->post('tanggal_akhir');

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query     = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'tanggal_awal'  => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal'           => 'Laporan Peminjaman'
		);

		$unduh = $this->load->view('pages/unduh-laporan', $halaman);
	}


	/*
	|-----------------------------------------------------------------
	| Fitur Logout
	|-----------------------------------------------------------------
	*/

	public function logout()
	{
		$sesi	= array
		(
			'namalengkap',
			'level',
			'status-masuk'
		);

		$this->session->unset_userdata($sesi);

		redirect(base_url());
	}
	/*
	|-----------------------------------------------------------------
	| Fitur Verifikasi Check-In Ruangan (Tombol / QR Code)
	|-----------------------------------------------------------------
	*/

	public function checkin_ruangan()
	{
		$id_peminjaman = $this->input->post('id_peminjaman', TRUE);
		$user_level    = $this->session->userdata('level');
		$user_fullname = $this->session->userdata('namalengkap');

		$booking = $this->db->get_where('tb_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();

		if (!$booking)
		{
			$this->session->set_flashdata('pesan_error', 'Data peminjaman tidak ditemukan.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// Validasi otorisasi
		if ($user_level != 'Admin' && $booking['peminjam'] != $user_fullname)
		{
			$this->session->set_flashdata('pesan_error', 'Anda tidak berhak melakukan check-in untuk peminjaman ini.');
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
			$this->session->set_flashdata('pesan_error', 'Belum waktunya check-in. Check-in hanya dapat dilakukan pada hari meeting mulai jam ' . substr($booking['jam_meeting'], 0, 5) . ' hingga 10 menit setelahnya.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// 2. Cek apakah sudah lewat 10 menit dari jadwal booking
		if ($now > $tolerance_limit)
		{
			// Batalkan otomatis
			$this->model_peminjaman->perbarui(array(
				'status_pinjam' => 'Dibatalkan',
				'waktu_pembatalan' => date('Y-m-d H:i:s'),
				'keterangan' => $booking['keterangan'] . ' [Auto-Cancel: Melewati batas check-in 10 menit]'
			), array('id_peminjaman' => $id_peminjaman));

			$this->session->set_flashdata('pesan_error', 'Maaf, batas waktu check-in (10 menit setelah jam booking) telah habis. Ruangan telah otomatis dibatalkan.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// Lakukan Check-In
		$waktu_sekarang = date('Y-m-d H:i:s');
		$this->model_peminjaman->perbarui(array('waktu_checkin' => $waktu_sekarang), array('id_peminjaman' => $id_peminjaman));

		// Catat ke riwayat akses ruangan (tb_tap)
		$this->db->insert('tb_tap', array(
			'id_kartu'     => 'CHECKIN-' . substr($booking['peminjam'], 0, 10),
			'nama_ruangan' => $booking['ruangan_dipinjam'],
			'waktu_akses'  => $waktu_sekarang,
			'status_akses' => 'Dibuka'
		));

		$this->session->set_flashdata('pesan_sukses', 'Verifikasi Check-in Berhasil! Ruangan ' . $booking['ruangan_dipinjam'] . ' resmi digunakan.');
		redirect(base_url('dashboard/data-peminjaman'));
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
		$now_time = date('H:i:s');
		$user_fullname = $this->session->userdata('namalengkap');

		// Cari booking aktif untuk ruangan ini hari ini
		$this->db->where('ruangan_dipinjam', $room['nama_ruangan']);
		$this->db->where('tanggal_meeting', $today);
		$this->db->where('status_pinjam', 'Disetujui');
		$this->db->where('waktu_checkin IS NULL', NULL, FALSE);
		if ($this->session->userdata('level') != 'Admin')
		{
			$this->db->where('peminjam', $user_fullname);
		}
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

				$this->db->insert('tb_tap', array(
					'id_kartu'     => 'QR-' . substr($active_booking['peminjam'], 0, 10),
					'nama_ruangan' => $room['nama_ruangan'],
					'waktu_akses'  => $waktu_sekarang,
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

		$user_level    = $this->session->userdata('level');
		$user_fullname = $this->session->userdata('namalengkap');

		$booking = $this->db->get_where('tb_peminjaman', array('id_peminjaman' => $id_peminjaman))->row_array();

		if (!$booking)
		{
			$this->session->set_flashdata('pesan_error', 'Data peminjaman tidak ditemukan.');
			redirect(base_url('dashboard/data-peminjaman'));
			return;
		}

		// Validasi otorisasi: Admin atau peminjam bersangkutan
		$is_owner = (strcasecmp(trim($booking['peminjam']), trim($user_fullname)) === 0) || 
		            (isset($booking['nama_peminjam']) && strcasecmp(trim($booking['nama_peminjam']), trim($user_fullname)) === 0);

		if ($user_level != 'Admin' && !$is_owner)
		{
			$this->session->set_flashdata('pesan_error', 'Anda tidak berhak melakukan check-in untuk peminjaman ini.');
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

		// Catat ke log riwayat akses ruangan
		$this->db->insert('tb_tap', array(
			'id_kartu'     => 'CHECKIN-' . substr($booking['peminjam'], 0, 10),
			'nama_ruangan' => $booking['ruangan_dipinjam'],
			'waktu_akses'  => $waktu_sekarang,
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
		$end_ts   = $start_ts + 3600; // default 1 jam

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

		if ($this->session->userdata('level') == "Pengguna")
		{
			$this->db->where('peminjam', $this->session->userdata('namalengkap'));
		}

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

		// FORMAT CSV (Default - 100% universal in Microsoft Excel without warnings)
		$filename = 'Laporan_Peminjaman_Medquest_' . $periode . '.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');

		$output = fopen('php://output', 'w');
		// UTF-8 BOM
		fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
		// Instruksi Excel untuk auto-detect pemisah semicolon
		fwrite($output, "sep=;\r\n");

		// Header kolom
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
		$this->model_peminjaman->auto_cancel_no_show();

		$periode = $this->input->get('periode', TRUE);
		if (!in_array($periode, array('hari_ini', 'kemarin', 'semua'), TRUE))
		{
			$periode = 'semua';
		}

		$this->db->order_by('tanggal_meeting', 'DESC');
		$this->db->order_by('jam_meeting', 'DESC');

		if ($this->session->userdata('level') == "Pengguna")
		{
			$this->db->where('peminjam', $this->session->userdata('namalengkap'));
		}

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
}
