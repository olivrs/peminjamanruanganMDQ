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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>?v=5.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/img/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url('assets/img/favicon-192x192.png'); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/img/favicon-180x180.png'); ?>">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</head>
<body>
	<div class="ws-login-shell">
		<div class="kotak-login">
			<!-- Panel Kiri: Identitas Workspace Internal -->
			<div class="gambar-login">
				<div>
					<div class="ws-login-kicker">
						<i class="fas fa-shield-alt"></i> Akses Petugas &amp; Superadmin
					</div>
					<h2>RoomSpace Workspace.</h2>
					<p>Panel kendali untuk pengelolaan data ruangan, persetujuan booking, dan laporan pemakaian ruang meeting internal.</p>
				</div>
				<div class="ws-login-note">
					Karyawan umum dapat langsung memesan ruang meeting tanpa login melalui halaman workspace utama.
				</div>
			</div>

			<!-- Panel Kanan: Form Login -->
			<div class="login-form">
				<div class="ws-login-brand">
					<i class="fas fa-th-large"></i>
					<span>RoomSpace &middot; MDQ Internal</span>
				</div>
				<h3>Login Petugas</h3>
				<div class="mq-login-sub">Masuk menggunakan akun Superadmin atau Resepsionis.</div>

				<?php echo form_open('login/proses'); ?>
				<ul>
					<li>
						<label for="ws-username">Username</label>
						<input id="ws-username" type="text" name="username" placeholder="Masukkan username" required />
					</li>
					<li>
						<label for="ws-password">Kata Sandi</label>
						<input id="ws-password" type="password" name="password" placeholder="Masukkan kata sandi" required />
					</li>
					<li style="margin-top:18px;">
						<input type="submit" name="tombol_login" value="Masuk ke Workspace" />
					</li>
					<li style="margin-top:16px; text-align:center;">
						<a href="<?php echo base_url('dashboard'); ?>" style="font-size:12.5px; font-weight:700; color:#0f766e; text-decoration:none;">
							<i class="fas fa-arrow-left" style="margin-right:4px;"></i> Kembali ke Workspace Booking (Tanpa Login)
						</a>
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="baris-footer">
		&copy; <?php echo date('Y'); ?> RoomSpace &middot; Sistem Reservasi Ruang Meeting Internal PT Medquest Jaya Global
	</div>
</body>
</html>
