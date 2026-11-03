<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $hal; ?> · Peminjaman Ruang Meeting - PT Medquest Jaya Global</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/linearicons.min.css'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> 
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
</head>
<body>
	<div class="container-fluid">
		<!-- Baris Menubar dan Dropdown Profil dengan Logo Medquest -->
		<div class="row menubar-bg" style="display:flex; align-items:center;">
			<div class="col-sm-3" style="padding-left:35px; display:flex; align-items:center;">
				<a href="<?php echo base_url('dashboard'); ?>" style="text-decoration:none; display:inline-flex; align-items:center;">
					<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="Medquest Logo" style="height:36px; max-width:180px; width:auto; object-fit:contain; filter:drop-shadow(0 1px 2px rgba(0,0,0,0.08));">
				</a>
			</div>
			<div class="col-sm-6 menubar" style="padding:0;"><?php echo $menubar; ?></div>
			<div class="col-sm-3" style="padding-right:35px;"><?php echo $dropdown; ?></div>
		</div>

		<!-- Baris Judul (hanya tampil jika bukan halaman Beranda) -->
		<?php if($hal != "Beranda"): ?>
		<div class="row" style="margin-top:10px;">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 title-pg">
				<div class="main-title"><?php echo $hal; ?></div>

				<?php if($hal == "Kelola Akun Pengguna"): ?>
				<div class="button-add">
				    <a href="" data-toggle="modal" data-target="#buatuser" data-backdrop="static"><i class="fas fa-user-plus"></i></a>
				</div>
				<?php endif; ?>

				<?php if($hal == "Kelola Data Ruangan"): ?>
				<div class="button-add">
				    <a href="" data-toggle="modal" data-target="#buatruangan" data-backdrop="static"><i class="fas fa-plus-circle"></i></a>
				</div>
				<?php endif; ?>

				<?php if($hal == "Data Peminjaman"): ?>
					<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
					<div class="button-add">
					    <a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static"><i class="fas fa-plus-circle"></i></a>
					</div>
					<?php endif; ?>

					<?php if($this->session->userdata('level') == "Admin"): ?>
					<div class="button-datapick">
						<a href="" data-toggle="modal" data-target="#lap-peminjaman" data-backdrop="static">Pilih Rentang Waktu</a>
					</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if($hal == "Riwayat Akses Ruangan"): ?>
					<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
					<div class="button-datapick">
						<a href="<?php echo base_url('dashboard/unduh-akses-ruangan'); ?>"><span class="lnr lnr-download"></span> Unduh Data</a>
					</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if($hal == "Laporan Peminjaman"): ?>
					<?php if($this->session->userdata('level') == "Admin"): ?>
					<div class="button-datapick">
						<a href="" data-toggle="modal" data-target="#unduh-lap-peminjaman" data-backdrop="static"><span class="lnr lnr-download"></span> Unduh Data</a>
					</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- Baris Konten -->
		<div class="row" style="<?php if($hal == 'Beranda') echo 'margin-top: 15px;'; ?>">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 outer-main" style="<?php if($hal == 'Beranda') echo 'padding-top: 0;'; ?>"><div class="main"><?php echo $content; ?></div></div>
		</div>

		<!-- Baris Copyright -->
		<div class="row footer">
			<div class="col-sm-12">&copy; <?php echo date('Y'); ?> PT Medquest Jaya Global · Sistem Peminjaman Ruang Meeting</div>
		</div>
	</div>
</body>
</html>