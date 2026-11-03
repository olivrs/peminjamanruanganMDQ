<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title><?php echo $hal; ?> · PT Medquest Jaya Global</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<style>
		body {
			background: #f1f5f9;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			margin: 0;
		}
		.qr-card {
			background: #ffffff;
			border-radius: 16px;
			box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
			padding: 40px;
			text-align: center;
			max-width: 420px;
			width: 100%;
			border-top: 6px solid #009688;
		}
		.qr-title {
			font-size: 22px;
			font-weight: 700;
			color: #1e293b;
			margin-bottom: 4px;
		}
		.qr-subtitle {
			font-size: 14px;
			color: #64748b;
			margin-bottom: 24px;
		}
		.qr-box {
			background: #ffffff;
			padding: 16px;
			display: inline-block;
			border: 2px dashed #cbd5e1;
			border-radius: 12px;
			margin-bottom: 20px;
		}
		.qr-box img {
			display: block;
			width: 220px;
			height: 220px;
		}
		.qr-desc {
			font-size: 13px;
			color: #475569;
			line-height: 1.5;
			margin-bottom: 24px;
		}
		.badge-timer {
			background: #fee2e2;
			color: #dc2626;
			padding: 6px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			display: inline-block;
			margin-bottom: 15px;
		}
	</style>
</head>
<body>
	<div class="qr-card">
		<div class="badge-timer">⏱️ Batas Check-in: 10 Menit dari Jam Booking</div>
		<div class="qr-title"><?php echo $room['nama_ruangan']; ?></div>
		<div class="qr-subtitle">PT Medquest Jaya Global · Kapasitas: <?php echo $room['kapasitas']; ?> Orang</div>

		<div class="qr-box">
			<?php 
				$scanUrl = base_url('dashboard/scan-qr/' . $room['room_qr_key']);
				$qrApi = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($scanUrl);
			?>
			<img src="<?php echo $qrApi; ?>" alt="QR Code Ruangan" />
		</div>

		<div class="qr-desc">
			<strong>Pindai QR ini saat tiba di ruangan.</strong><br>
			Jika tidak melakukan check-in dalam 10 menit setelah jam mulai, sistem otomatis membatalkan peminjaman agar ruangan dapat dipesan oleh rekan kerja lain.
		</div>

		<a href="javascript:window.print()" class="btn btn-primary btn-block">🖨️ Cetak QR Code Tempel Pintu</a>
	</div>
</body>
</html>