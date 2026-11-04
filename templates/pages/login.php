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
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>?v=2.1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
</head>
<body>
	<!-- Top Bar Medquest (#top-header) -->
	<div class="mq-login-topbar">
		<div class="mq-login-topbar-inner">
			<div>
				<span><i class="fas fa-phone-volume"></i> +62 21 39842961</span>
				<span style="margin-left:16px;"><i class="fas fa-envelope"></i> info@medquest.co.id</span>
			</div>
			<div>
				<span><i class="fas fa-headset"></i> Hotline 24h: +62-21-29260000</span>
				<a href="https://medquest.co.id/" target="_blank" rel="noopener" style="color:#fff; margin-left:14px; font-weight:700;"><i class="fas fa-globe"></i> medquest.co.id</a>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row baris-utama">
			<!-- Kolom Offset -->
			<div class="col-sm-2-offset col-sm-2"></div>

			<div class="col-sm-8 kotak-login clearfix">
				<!-- Kolom Gambar Selamat Datang -->
				<div class="gambar-login">
					<p>Selamat <br><b>datang<font color="#ffc000">.</font></b></p>
					<div class="mq-login-caption">
						<strong style="font-size: 14.5px; letter-spacing: 0.3px;">PT Medquest Jaya Global</strong>
						<div style="margin-top: 14px; background: #ffffff; padding: 10px 14px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 20, 60, 0.18);">
							<img src="<?php echo base_url('assets/img/quest_horizontal.png'); ?>" alt="Medquest Core Values (Q.U.E.S.T)" style="width: 100%; height: auto; display: block;">
						</div>
					</div>
				</div>
				
				<!-- Form Login -->
				<div class="login-form">
					<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="PT Medquest Jaya Global">
					<h3>Login Admin</h3>

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
						<li style="margin-top: 10px;">
							<a href="<?php echo base_url('dashboard'); ?>" style="font-size:12.5px; font-weight:700; color:#0059fb; text-decoration:none;"><i class="fas fa-arrow-left" style="margin-right:4px;"></i> Kembali ke Halaman Booking Ruangan (Tanpa Login)</a>
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		<div class="row baris-footer">
			<div class="col-sm-12">&copy; <?php echo date('Y'); ?> <strong>PT Medquest Jaya Global</strong> &middot; Menara Salemba 6th Fl Zone 1, Jakarta Pusat &middot; Sistem Peminjaman Ruang Meeting</div>
		</div>
	</div>
</body>
</html>