<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $hal; ?> &middot; Peminjaman Ruang Meeting</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>?v=6.0">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/linearicons.min.css'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> 
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/img/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url('assets/img/favicon-192x192.png'); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/img/favicon-180x180.png'); ?>">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
</head>
<body>
	<!-- Header Navigasi Utama -->
	<header id="main-header" class="menubar-bg">
		<div class="app-container app-navbar-inner">
			<div class="app-brand">
				<a href="<?php echo base_url('dashboard'); ?>" class="app-logo-link">
					<span class="app-logo-box"><i class="fas fa-calendar-check"></i></span>
					<span class="app-brand-title">Peminjaman Ruang Meeting</span>
				</a>
			</div>
			<nav class="menubar"><?php echo $menubar; ?></nav>
			<div class="app-user-area"><?php echo $dropdown; ?></div>
		</div>
	</header>

	<div class="container-fluid app-page-wrapper">
		<!-- Baris Judul (hanya tampil jika bukan halaman Beranda) -->
		<?php if($hal != "Beranda"): ?>
		<div class="row">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 title-pg">
				<div class="main-title">
					<div class="app-page-heading"><?php echo $hal; ?></div>
				</div>

				<div class="app-title-actions">
					<?php if($hal == "Kelola Data Ruangan" && $this->session->userdata('level') == "Admin"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatruangan" data-backdrop="static"><i class="fas fa-plus-circle" style="margin-right:6px;"></i> Tambah Ruangan</a>
					</div>
					<?php endif; ?>

					<?php if($hal == "Data Peminjaman"): ?>
						<?php if($this->session->userdata('level') == "Admin"): ?>
						<div class="button-datapick">
							<a href="" data-toggle="modal" data-target="#lap-peminjaman" data-backdrop="static"><i class="far fa-calendar-alt" style="margin-right:5px;"></i> Pilih Rentang Waktu</a>
						</div>
						<?php endif; ?>

						<div class="button-add">
							<a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static"><i class="fas fa-plus-circle" style="margin-right:6px;"></i> Ajukan Peminjaman</a>
						</div>
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
		</div>
		<?php endif; ?>

		<!-- Baris Konten -->
		<div class="row" style="<?php if($hal == 'Beranda') echo 'margin-top: 22px;'; ?>">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 outer-main" style="<?php if($hal == 'Beranda') echo 'padding-top: 0;'; ?>">
				<div class="main <?php if($hal == 'Beranda') echo 'main-beranda'; ?>"><?php echo $content; ?></div>
			</div>
		</div>
	</div>

	<!-- Footer Sederhana -->
	<footer class="app-footer">
		<div class="app-container">
			&copy; <?php echo date('Y'); ?> Sistem Manajemen &amp; Peminjaman Ruang Meeting
		</div>
	</footer>

	<script>
	$(document).ready(function () {
		$('.modal').appendTo('body');
		$(document).on('show.bs.modal', '.modal', function () {
			if (this.parentNode !== document.body) {
				document.body.appendChild(this);
			}
		});
	});
	</script>
</body>
</html>
