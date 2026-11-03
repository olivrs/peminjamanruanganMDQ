<?php

/*
|--------------------------------------------------------------------------
| Limitasi Hak Akses Menubar
|--------------------------------------------------------------------------
*/

if($this->session->userdata('level') == "Admin")
{
	$this->load->view('components/menubar-admin');
}
elseif($this->session->userdata('level') == "Resepsionis")
{
	$this->load->view('components/menubar-resepsionis');
}
elseif($this->session->userdata('level') == "Pengguna")
{
	$this->load->view('components/menubar-user');
}

?>