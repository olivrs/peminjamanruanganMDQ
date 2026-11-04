<?php
/*
|--------------------------------------------------------------------------
| Limitasi Hak Akses Menubar (Open Website + Akses Superadmin & Resepsionis)
|--------------------------------------------------------------------------
*/

if ($this->session->userdata('status-masuk') == 'masuk' && $this->session->userdata('level') == "Admin")
{
	$this->load->view('components/menubar-admin');
}
elseif ($this->session->userdata('status-masuk') == 'masuk' && $this->session->userdata('level') == "Resepsionis")
{
	$this->load->view('components/menubar-resepsionis');
}
else
{
	$this->load->view('components/menubar-user');
}
?>
