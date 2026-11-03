<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->_ensure_tables_exist();
		$this->load->model('Model_Login', 'model_login');
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

			// Ensure standard default users exist with valid bcrypt hash
			$check_ryan = $this->db->get_where('tb_user', array('username' => 'ryan'))->row_array();
			if (empty($check_ryan) || ! password_verify('123123', $check_ryan['password']))
			{
				$default_pass = password_hash('123123', PASSWORD_DEFAULT);
				$default_users = array(
					array('username' => 'ryan', 'fullname' => 'Ryan', 'password' => $default_pass, 'level' => 'Admin'),
					array('username' => 'operator', 'fullname' => 'Operator Resepsionis', 'password' => $default_pass, 'level' => 'Resepsionis'),
					array('username' => 'resepsionis', 'fullname' => 'Resepsionis Medquest', 'password' => $default_pass, 'level' => 'Resepsionis'),
					array('username' => 'nawal', 'fullname' => 'nawwal fadhil', 'password' => $default_pass, 'level' => 'Pengguna'),
					array('username' => '123123', 'fullname' => '123', 'password' => $default_pass, 'level' => 'Resepsionis')
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

				$this->db->query("INSERT IGNORE INTO `tb_peminjaman` VALUES 
				('MDQ-00016','Ryan','Pulau Bali','itd','2026-10-26 15:54:10','2026-10-26 15:54:53','0000-00-00 00:00:00','2026-10-27 10:57:22','-','-','Selesai','2026-10-28','14:00:00',NULL,NULL,NULL,NULL),
				('MDQ-00020','nawwal fadhil ','Pulau Jawa','Meeting Uji Coba Check-In Langsung','2026-10-27 09:28:45','2026-10-27 09:28:45','2026-10-27 09:31:46','2026-10-27 10:11:28','OK','OK','Selesai','2026-10-27','09:40:00','Nawwal Fadhil','Marketing','08123456789','2026-10-27 09:43:20'),
				('MDQ-00091','Ryan','Pulau Bali','Rapat Bulanan','2026-11-03 10:12:55','2026-11-03 10:13:10',NULL,'2026-11-03 10:13:15','OK','OK','Selesai','2026-11-03','11:00:00','Nawal','ITD','0812345678',NULL),
				('MDQ-00092','Ryan','Pulau Kalimantan','Monthly Evaulation','2026-11-03 10:58:33',NULL,NULL,NULL,'-','-','Menunggu','2026-11-03','11:00:00','nawel','ITD','0812345678',NULL),
				('MDQ-00093','nawwal fadhil ','Pulau Bali','Rapat Bulanan','2026-11-03 13:22:38',NULL,NULL,NULL,'-','-','Menunggu','2026-11-03','14:00:00','nawwal fadhil','Information Technology Departement','081383790998',NULL);");
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

				$this->db->query("INSERT IGNORE INTO `tb_tap` VALUES 
				(45,'CHECKIN-nawwal fad','Pulau Jawa','2026-10-27 09:43:20','0000-00-00 00:00:00','Dibuka'),
				(46,'CHECKIN-nawwal fad','Board Room','2026-10-27 09:45:40','0000-00-00 00:00:00','Dibuka');");
			}
		}
		catch (Exception $e)
		{
			log_message('error', 'Auto-table init error: ' . $e->getMessage());
		}
	}

	public function index()
	{
		$halaman ['hal'] = "Halaman Login";
		$this->load->view('pages/login', $halaman);
	}

	public function proses()
	{
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		$user = $this->model_login
			->periksa_login('tb_user', array('username' => $username))
			->row_array();

		$password_valid = FALSE;
		if (!empty($user))
		{
			if (password_verify($password, $user['password']))
			{
				$password_valid = TRUE;
			}
			elseif (strlen($user['password']) == 32 && ctype_xdigit($user['password']) && hash_equals($user['password'], md5($password)))
			{
				$password_valid = TRUE;
			}
		}

		if ($password_valid)
		{
			if (!password_verify($password, $user['password']) || password_needs_rehash($user['password'], PASSWORD_DEFAULT))
			{
				$this->db->where('username', $username)->update('tb_user', array(
					'password' => password_hash($password, PASSWORD_DEFAULT)
				));
			}

			$this->session->sess_regenerate(TRUE);

			$sesi	= array(
				'namalengkap'  => $user['fullname'],
				'level'        => $user['level'],
				'status-masuk' => 'masuk'
				);

			$this->session->set_userdata($sesi);

			redirect('dashboard');
		}
		else
		{
			echo "Username atau password salah!";
		}
	}
}