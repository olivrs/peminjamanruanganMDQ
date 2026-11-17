<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $hal; ?> &middot; RoomSpace MDQ</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>?v=5.0">
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
	<!-- Slim Internal Workspace Topbar (Dark Slate + Teal Accent) -->
	<header id="ws-header" class="ws-topbar">
		<div class="ws-container ws-topbar-inner">
			<div class="ws-brand">
				<a href="<?php echo base_url('dashboard'); ?>" class="ws-brand-link">
					<span class="ws-brand-mark"><i class="fas fa-th-large"></i></span>
					<span class="ws-brand-text">
						<span class="ws-brand-name">RoomSpace</span>
						<span class="ws-brand-sub">MDQ Workspace</span>
					</span>
				</a>
			</div>

			<nav class="menubar"><?php echo $menubar; ?></nav>

			<div class="ws-user-area"><?php echo $dropdown; ?></div>
		</div>
	</header>

	<main class="ws-page-wrapper">
		<div class="ws-container">
			<!-- Baris Judul Halaman (tampil jika bukan Beranda) -->
			<?php if($hal != "Beranda"): ?>
			<div class="title-pg">
				<div class="main-title">
					<span class="ws-page-kicker">Internal Meeting Room System</span>
					<div class="ws-page-heading"><?php echo $hal; ?></div>
				</div>

				<div class="ws-title-actions">
					<?php if($hal == "Kelola Data Ruangan" && $this->session->userdata('level') == "Admin"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatruangan" data-backdrop="static"><i class="fas fa-plus" style="margin-right:6px;"></i> Tambah Ruangan</a>
					</div>
					<?php endif; ?>

					<?php if($hal == "Data Peminjaman"): ?>
						<?php if($this->session->userdata('level') == "Admin"): ?>
						<div class="button-datapick">
							<a href="" data-toggle="modal" data-target="#lap-peminjaman" data-backdrop="static"><i class="far fa-calendar-alt" style="margin-right:5px;"></i> Pilih Rentang Waktu</a>
						</div>
						<?php endif; ?>

						<div class="button-add">
							<a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static"><i class="fas fa-plus" style="margin-right:6px;"></i> Ajukan Peminjaman</a>
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
			<?php endif; ?>

			<!-- Konten Utama -->
			<div class="outer-main <?php if($hal == 'Beranda') echo 'outer-main-beranda'; ?>">
				<div class="main <?php if($hal == 'Beranda') echo 'main-beranda'; ?>"><?php echo $content; ?></div>
			</div>
		</div>
	</main>

	<!-- Slim Internal App Footer (Tanpa profil website utama) -->
	<footer class="ws-footer">
		<div class="ws-container ws-footer-inner">
			<span>&copy; <?php echo date('Y'); ?> RoomSpace &middot; Sistem Reservasi Ruang Meeting Internal PT Medquest Jaya Global</span>
			<span class="ws-footer-meta">Zona Waktu: WIB (Asia/Jakarta)</span>
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
