<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan Peminjaman Ruang Meeting - PT Medquest Jaya Global</title>
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<style>
		@page {
			size: A4 landscape;
			margin: 10mm 12mm 12mm 12mm;
		}
		* {
			box-sizing: border-box;
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
		}
		body {
			background: #f8fafc;
			color: #0f172a;
			margin: 0;
			padding: 24px;
		}
		.print-toolbar {
			background: #0f172a;
			color: #ffffff;
			padding: 12px 24px;
			border-radius: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 24px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
		}
		.print-btn {
			background: #0284c7;
			color: #ffffff;
			border: none;
			padding: 9px 20px;
			border-radius: 6px;
			font-size: 13px;
			font-weight: 700;
			cursor: pointer;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			transition: all 0.2s;
		}
		.print-btn:hover {
			background: #0369a1;
		}
		.back-btn {
			background: rgba(255, 255, 255, 0.15);
			color: #ffffff;
			border: 1px solid rgba(255, 255, 255, 0.25);
			padding: 9px 18px;
			border-radius: 6px;
			font-size: 13px;
			text-decoration: none;
			cursor: pointer;
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}
		.back-btn:hover {
			background: rgba(255, 255, 255, 0.25);
		}
		.report-card {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 12px;
			padding: 30px;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
			max-width: 1100px;
			margin: 0 auto;
		}
		.header-corp {
			display: flex;
			align-items: center;
			justify-content: space-between;
			border-bottom: 3px double #0284c7;
			padding-bottom: 16px;
			margin-bottom: 20px;
			gap: 20px;
		}
		.brand-block {
			display: flex;
			align-items: center;
			gap: 16px;
		}
		.brand-logo-img {
			height: 52px;
			max-width: 190px;
			width: auto;
			object-fit: contain;
			display: block;
		}
		.brand-text {
			display: flex;
			flex-direction: column;
		}
		.brand-name {
			font-size: 20px;
			font-weight: 900;
			color: #0f172a;
			letter-spacing: -0.3px;
			line-height: 1.15;
		}
		.brand-sub {
			font-size: 11px;
			color: #0284c7;
			font-weight: 700;
			letter-spacing: 1.2px;
			text-transform: uppercase;
			margin-top: 3px;
		}
		.brand-dept {
			font-size: 11px;
			color: #64748b;
			margin-top: 2px;
			font-weight: 500;
		}
		.corp-info {
			text-align: right;
			font-size: 10.5px;
			color: #475569;
			line-height: 1.45;
			max-width: 520px;
		}
		.corp-info strong.corp-title {
			color: #0f172a;
			font-size: 12px;
			display: inline-block;
			margin-bottom: 2px;
		}
		.report-title {
			text-align: center;
			margin: 18px 0 20px 0;
		}
		.report-title h2 {
			margin: 0;
			font-size: 18px;
			font-weight: 800;
			color: #0f172a;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.report-title p {
			margin: 5px 0 0 0;
			font-size: 12px;
			color: #64748b;
		}
		.meta-grid {
			display: flex;
			justify-content: space-between;
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			padding: 12px 18px;
			margin-bottom: 20px;
			font-size: 12px;
		}
		.meta-item strong {
			color: #0f172a;
		}
		.meta-item span {
			color: #475569;
		}
		table.data-table {
			width: 100%;
			border-collapse: collapse;
			font-size: 11.5px;
			margin-bottom: 24px;
		}
		table.data-table th {
			background: #0f172a;
			color: #ffffff;
			text-align: left;
			padding: 10px 12px;
			font-weight: 700;
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			border: 1px solid #0f172a;
		}
		table.data-table td {
			padding: 9px 12px;
			border: 1px solid #cbd5e1;
			color: #1e293b;
			vertical-align: top;
		}
		table.data-table tr:nth-child(even) {
			background: #f8fafc;
		}
		.badge {
			display: inline-block;
			padding: 3px 8px;
			border-radius: 4px;
			font-size: 10px;
			font-weight: 700;
			text-transform: uppercase;
		}
		.badge-success { background: #dcfce7; color: #166534; }
		.badge-primary { background: #e0f2fe; color: #0369a1; }
		.badge-warning { background: #fef3c7; color: #92400e; }
		.badge-danger  { background: #fee2e2; color: #991b1b; }
		.signature-section {
			display: flex;
			justify-content: space-between;
			margin-top: 36px;
			page-break-inside: avoid;
		}
		.sig-box {
			text-align: center;
			width: 220px;
			font-size: 12px;
		}
		.sig-space {
			height: 65px;
		}
		.sig-line {
			border-bottom: 1px solid #0f172a;
			margin-bottom: 5px;
			font-weight: 700;
			color: #0f172a;
		}
		.sig-role {
			font-size: 11px;
			color: #64748b;
		}

		@media print {
			body {
				background: #ffffff;
				padding: 0;
			}
			.print-toolbar {
				display: none !important;
			}
			.report-card {
				border: none;
				box-shadow: none;
				padding: 0;
				max-width: 100%;
			}
			table.data-table th {
				background: #1e293b !important;
				color: #ffffff !important;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
		}
	</style>
</head>
<body>

	<div class="print-toolbar">
		<div style="display:flex; align-items:center; gap:12px;">
			<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>" class="back-btn">&larr; Kembali</a>
			<span style="font-size:14px; font-weight:600;">Pratinjau Cetak Laporan Peminjaman Ruang Meeting</span>
		</div>
		<div>
			<button onclick="window.print()" class="print-btn">
				<span style="font-size:15px;">🖨️</span> Cetak / Simpan ke PDF
			</button>
		</div>
	</div>

	<div class="report-card">
		<!-- Kop Surat Perusahaan -->
		<div class="header-corp">
			<div class="brand-block">
				<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="Logo PT Medquest Jaya Global" class="brand-logo-img">
				<div class="brand-text">
					<div class="brand-name">PT MEDQUEST JAYA GLOBAL</div>
					<div class="brand-sub">Medical Equipment &amp; Healthcare Solutions</div>
				</div>
			</div>
			<div class="corp-info">
				<strong class="corp-title">PT MEDQUEST JAYA GLOBAL</strong><br>
				<strong>Head Office:</strong> Menara Salemba Lt. 6 Zona 1, Jl. Salemba Raya No. 5 – 5A, Jakarta Pusat 10440<br>
				Telp: (021) 3984 2961 / (021) 5367 8788 &bull; Email: service.support@medquest.co.id &bull; www.medquest.co.id
			</div>
		</div>

		<!-- Judul Laporan -->
		<div class="report-title">
			<h2>REKAPITULASI AGENDA &amp; PEMINJAMAN RUANG MEETING</h2>
			<p>Periode: <strong><?php echo ucfirst(str_replace('_', ' ', $periode)); ?></strong></p>
		</div>

		<!-- Meta Info -->
		<div class="meta-grid">
			<div class="meta-item">
				<strong>Tanggal Cetak:</strong> <span><?php echo $tanggal_cetak; ?></span>
			</div>
			<div class="meta-item">
				<strong>Dicetak Oleh:</strong> <span><?php echo htmlspecialchars($dicetak_oleh); ?></span>
			</div>
			<div class="meta-item">
				<strong>Total Data:</strong> <span><?php echo count($peminjaman); ?> Agenda</span>
			</div>
		</div>

		<!-- Tabel Data Peminjaman -->
		<table class="data-table">
			<thead>
				<tr>
					<th style="width: 35px; text-align:center;">No</th>
					<th style="width: 90px;">ID Booking</th>
					<th style="width: 140px;">Waktu Meeting</th>
					<th style="width: 130px;">Ruangan</th>
					<th>Agenda / Keterangan</th>
					<th style="width: 160px;">Peminjam / Dept</th>
					<th style="width: 95px; text-align:center;">Status</th>
					<th style="width: 105px; text-align:center;">Check-In</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($peminjaman)): ?>
					<tr>
						<td colspan="8" align="center" style="padding:20px; color:#94a3b8;">
							Tidak ada data peminjaman untuk periode ini.
						</td>
					</tr>
				<?php else: ?>
					<?php $no = 1; foreach ($peminjaman as $row): ?>
					<tr>
						<td align="center"><?php echo $no++; ?></td>
						<td><strong><?php echo $row['id_peminjaman']; ?></strong></td>
						<td>
							<strong><?php echo !empty($row['tanggal_meeting']) ? date('d/m/Y', strtotime($row['tanggal_meeting'])) : '-'; ?></strong><br>
							<span style="color:#64748b; font-size:10.5px;">Pukul <?php echo !empty($row['jam_meeting']) ? substr($row['jam_meeting'], 0, 5) : '-'; ?> WIB</span>
						</td>
						<td>
							<strong style="color:#0284c7;"><?php echo $row['ruangan_dipinjam']; ?></strong>
						</td>
						<td>
							<?php echo htmlspecialchars($row['keterangan']); ?>
						</td>
						<td>
							<strong><?php echo !empty($row['nama_peminjam']) ? htmlspecialchars($row['nama_peminjam']) : htmlspecialchars($row['peminjam']); ?></strong><br>
							<span style="color:#64748b; font-size:10.5px;"><?php echo !empty($row['departemen_peminjam']) ? htmlspecialchars($row['departemen_peminjam']) : 'Umum'; ?></span>
						</td>
						<td align="center">
							<?php 
								$st = $row['status_pinjam'];
								$badgeClass = 'badge-primary';
								if ($st == 'Selesai') $badgeClass = 'badge-success';
								elseif ($st == 'Disetujui') $badgeClass = 'badge-primary';
								elseif ($st == 'Menunggu') $badgeClass = 'badge-warning';
								elseif ($st == 'Dibatalkan') $badgeClass = 'badge-danger';
							?>
							<span class="badge <?php echo $badgeClass; ?>"><?php echo $st; ?></span>
						</td>
						<td align="center" style="font-size:10.5px;">
							<?php if (!empty($row['waktu_checkin'])): ?>
								<span style="color:#166534; font-weight:700;">✓ Checked-In</span><br>
								<span style="color:#64748b; font-size:9.5px;"><?php echo date('H:i', strtotime($row['waktu_checkin'])); ?> WIB</span>
							<?php else: ?>
								<span style="color:#94a3b8;">-</span>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<!-- Tanda Tangan Pengesahan -->
		<div class="signature-section">
			<div class="sig-box">
				<div>Petugas Resepsionis / Front Desk</div>
				<div class="sig-space"></div>
				<div class="sig-line">( ........................................ )</div>
				<div class="sig-role">Resepsionis Operasional</div>
			</div>
			<div class="sig-box">
				<div>Mengetahui &amp; Menyetujui,</div>
				<div class="sig-space"></div>
				<div class="sig-line">( ........................................ )</div>
				<div class="sig-role">General Affairs / Operations Head</div>
			</div>
		</div>
	</div>

</body>
</html>