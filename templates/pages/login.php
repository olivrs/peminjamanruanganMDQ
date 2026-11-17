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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>?v=6.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/img/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url('assets/img/favicon-192x192.png'); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/img/favicon-180x180.png'); ?>">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row baris-utama">
			<!-- Kolom Offset -->
			<div class="col-sm-2-offset col-sm-2"></div>

			<div class="col-sm-8 kotak-login clearfix">
				<!-- Kolom Gambar Selamat Datang -->
				<div class="gambar-login">
					<p>Selamat <br><b>datang<font color="#f6ad55">.</font></b></p>
				</div>
				
				<!-- Form Login -->
				<div class="login-form">
					<div class="login-icon-badge"><i class="fas fa-calendar-check"></i></div>
					<h3>Login Admin</h3>
					<p class="login-sub">Sistem Manajemen Peminjaman Ruang Meeting</p>

					<?php echo form_open('login/proses'); ?>
					<ul>
						<li>
							<input type="text" name="username" placeholder="Username" required />
						</li>
						<li>
							<input type="password" name="password" placeholder="Kata sandi (Password)" required />
						</li>
						<li>
							<input type="submit" name="tombol_login" value="Masuk" />
						</li>
						<li style="margin-top: 12px;">
							<a href="<?php echo base_url('dashboard'); ?>" style="font-size:12.5px; font-weight:700; color:#2c5282; text-decoration:none;"><i class="fas fa-arrow-left" style="margin-right:4px;"></i> Kembali ke Halaman Booking Ruangan (Tanpa Login)</a>
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		<div class="row baris-footer">
			<div class="col-sm-12">&copy; <?php echo date('Y'); ?> Sistem Manajemen &amp; Peminjaman Ruang Meeting</div>
		</div>
	</div>
</body>
</html>
