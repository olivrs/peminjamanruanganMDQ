<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('model_login');
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