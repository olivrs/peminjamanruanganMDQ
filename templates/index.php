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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>?v=2.1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/linearicons.min.css'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> 
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
</head>
<body>
	<!-- Top Utility Bar ala medquest.co.id (#top-header) -->
	<div id="top-header" class="mq-top-header">
		<div class="mq-container">
			<div class="mq-top-left">
				<span class="mq-top-item"><i class="fas fa-phone-volume"></i> +62 21 39842961</span>
				<a href="mailto:info@medquest.co.id" class="mq-top-item"><i class="fas fa-envelope"></i> info@medquest.co.id</a>
				<span class="mq-top-item mq-hide-mobile"><i class="fas fa-map-marker-alt"></i> Menara Salemba 6th Fl Zone 1, Jakarta Pusat</span>
			</div>
			<div class="mq-top-right">
				<span class="mq-hotline-pill"><i class="fas fa-headset"></i> Hotline 24h: +62-21-29260000</span>
				<div class="mq-top-socials">
					<a href="https://www.facebook.com/MedquestID" target="_blank" rel="noopener" title="Facebook Medquest"><i class="fab fa-facebook-f"></i></a>
					<a href="https://twitter.com/medquest_id" target="_blank" rel="noopener" title="X / Twitter Medquest"><i class="fab fa-twitter"></i></a>
					<a href="https://www.instagram.com/medquest_id/" target="_blank" rel="noopener" title="Instagram Medquest"><i class="fab fa-instagram"></i></a>
					<a href="https://medquest.co.id/" target="_blank" rel="noopener" title="Website Resmi medquest.co.id"><i class="fas fa-globe"></i></a>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Navigation Header ala medquest.co.id (#main-header) -->
	<header id="main-header" class="menubar-bg">
		<div class="mq-container mq-navbar-inner">
			<div class="mq-brand">
				<a href="<?php echo base_url('dashboard'); ?>" class="mq-logo-link">
					<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="PT Medquest Jaya Global" class="mq-logo-img">
					<span class="mq-brand-divider"></span>
					<span class="mq-brand-subtitle">Room Booking<br><small>Corporate Portal</small></span>
				</a>
			</div>
			<nav class="menubar"><?php echo $menubar; ?></nav>
			<div class="mq-user-area"><?php echo $dropdown; ?></div>
		</div>
	</header>

	<div class="container-fluid mq-page-wrapper">
		<!-- Baris Judul (hanya tampil jika bukan halaman Beranda) -->
		<?php if($hal != "Beranda"): ?>
		<div class="row">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 title-pg">
				<div class="main-title">
					<span class="mq-breadcrumb-label">PT MEDQUEST JAYA GLOBAL &middot; INTERNAL PORTAL</span>
					<div class="mq-page-heading"><?php echo $hal; ?></div>
				</div>

				<div class="mq-title-actions">
					<?php if($hal == "Kelola Akun Pengguna"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatuser" data-backdrop="static"><i class="fas fa-user-plus" style="margin-right:6px;"></i> Tambah Akun</a>
					</div>
					<?php endif; ?>

					<?php if($hal == "Kelola Data Ruangan"): ?>
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

						<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
						<div class="button-add">
							<a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static"><i class="fas fa-plus-circle" style="margin-right:6px;"></i> Ajukan Peminjaman</a>
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

	<!-- Corporate Footer ala medquest.co.id (et_pb_section_0_tb_footer) -->
	<footer class="mq-footer">
		<div class="mq-footer-main">
			<div class="mq-container mq-footer-grid">
				<!-- Kolom 1: Logo, Profil Perusahaan & Kontak -->
				<div class="mq-footer-col mq-footer-about">
					<div class="mq-footer-logo-box">
						<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="PT Medquest Jaya Global">
					</div>
					<p class="mq-footer-desc">
						PT. Medquest Jaya Global since its establishment in 2004 concentrating in distributing medical device and pharmaceutical, by promoting innovation and latest technology. We currently distribute more than 30 leading brands in the world, which includes the equipment in the field of blood bank, diagnostics, research and industry.
					</p>
					<ul class="mq-footer-contacts">
						<li><i class="fas fa-phone-volume"></i> <span>+62-21 39842961</span></li>
						<li><i class="fas fa-envelope"></i> <a href="mailto:info@medquest.co.id">info@medquest.co.id</a></li>
						<li><i class="fas fa-map-marker-alt"></i> <span>Menara Salemba 6th Fl Zone 1, Jl. Salemba Raya No. 5 - 5A, Jakarta Pusat 10440</span></li>
					</ul>
					<div class="mq-iso-badges">
						<span class="mq-iso-pill"><i class="fas fa-certificate"></i> ISO 9001:2015 SGS Certified</span>
						<span class="mq-iso-pill"><i class="fas fa-shield-alt"></i> ISO 37001:2016 Anti-Bribery</span>
					</div>
				</div>

				<!-- Kolom 2: Explore & Navigasi Cepat -->
				<div class="mq-footer-col mq-footer-links">
					<h4 class="mq-footer-title">Explore</h4>
					<ul>
						<li><a href="<?php echo base_url('dashboard'); ?>">Beranda Portal</a></li>
						<li><a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>">Ketersediaan Ruang Meeting</a></li>
						<li><a href="<?php echo base_url('dashboard/data-peminjaman'); ?>">Data & Agenda Peminjaman</a></li>
						<li><a href="<?php echo base_url('dashboard/panduan'); ?>">Buku Panduan Sistem</a></li>
						<li><a href="https://medquest.co.id/" target="_blank" rel="noopener">Official Website (medquest.co.id)</a></li>
						<li><a href="https://medquest.co.id/products/" target="_blank" rel="noopener">Products & Calibration</a></li>
						<li><a href="https://medquest.co.id/whistle-blowing-system/" target="_blank" rel="noopener">Whistle Blowing System (WBS)</a></li>
					</ul>
				</div>

				<!-- Kolom 3: Hotline 24 Hours & Kantor Operasional -->
				<div class="mq-footer-col mq-footer-hotline">
					<h4 class="mq-footer-title">Customer & Internal Support</h4>
					<div class="mq-hotline-card">
						<div class="mq-hotline-icon"><i class="fas fa-headset"></i></div>
						<div>
							<div class="mq-hotline-label">Hotline Service 24 Hours</div>
							<div class="mq-hotline-number">+62-21-29260000</div>
						</div>
					</div>
					<div class="mq-operational-box">
						<strong><i class="fas fa-building"></i> Operational Office:</strong>
						<p>Wisma 77 Tower 1, 8th Fl, Jl. Letjen S. Parman Kav. 77, Slipi, Jakarta Barat 11410</p>
					</div>
					<div class="mq-footer-socials">
						<a href="https://www.instagram.com/medquest_id/" target="_blank" rel="noopener" title="Instagram"><i class="fab fa-instagram"></i></a>
						<a href="https://www.facebook.com/MedquestID" target="_blank" rel="noopener" title="Facebook"><i class="fab fa-facebook-f"></i></a>
						<a href="https://twitter.com/medquest_id" target="_blank" rel="noopener" title="X / Twitter"><i class="fab fa-twitter"></i></a>
						<a href="https://medquest.co.id/contact-us/" target="_blank" rel="noopener" title="Contact Us"><i class="fas fa-external-link-alt"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="mq-footer-bottom">
			<div class="mq-container">
				&copy; <?php echo date('Y'); ?> <strong>PT Medquest Jaya Global</strong> &middot; Sistem Manajemen &amp; Peminjaman Ruang Meeting Terintegrasi. All Rights Reserved.
			</div>
		</div>
	</footer>
</body>
</html>