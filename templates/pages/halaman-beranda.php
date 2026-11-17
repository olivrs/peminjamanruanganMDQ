<style>
	.beranda-hero {
		background: linear-gradient(130deg, #1a365d 0%, #2c5282 65%, #3b6ea5 100%);
		border-radius: 0;
		padding: 24px 30px;
		color: #ffffff;
		margin-bottom: 24px;
		box-shadow: 0 10px 24px -8px rgba(26, 54, 93, 0.3);
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 20px;
		position: relative;
		overflow: hidden;
	}
	.hero-text h2 {
		font-family: 'Open Sans', sans-serif;
		font-size: 22px;
		font-weight: 800;
		margin-top: 0;
		margin-bottom: 6px;
		letter-spacing: -0.3px;
		color: #ffffff;
	}
	.hero-text p {
		font-size: 13px;
		color: #e2e8f0;
		max-width: 600px;
		margin-bottom: 14px;
		line-height: 1.55;
	}
	.hero-actions {
		display: flex;
		align-items: center;
		gap: 10px;
		flex-wrap: wrap;
	}
	.hero-actions .btn-cta {
		background: #ffffff;
		color: #1a365d;
		padding: 9px 18px;
		border-radius: 2px;
		font-weight: 800;
		text-decoration: none;
		font-size: 12.5px;
		display: inline-flex;
		align-items: center;
		box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
		transition: all 0.2s ease;
	}
	.hero-actions .btn-cta:hover {
		background: #edf2f7;
		transform: translateY(-2px);
		color: #1a365d;
	}
	.hero-actions .btn-cta-outline {
		background: rgba(255, 255, 255, 0.12);
		border: 1px solid rgba(255, 255, 255, 0.35);
		color: #ffffff;
		padding: 8px 16px;
		border-radius: 2px;
		font-weight: 700;
		text-decoration: none;
		font-size: 12.5px;
		display: inline-flex;
		align-items: center;
		transition: all 0.2s ease;
	}
	.hero-actions .btn-cta-outline:hover {
		background: rgba(255, 255, 255, 0.22);
		color: #ffffff;
	}
	.hero-stats {
		display: flex;
		gap: 12px;
		flex-wrap: wrap;
	}
	.stat-card {
		background: rgba(255, 255, 255, 0.12);
		border: 1px solid rgba(255, 255, 255, 0.24);
		border-radius: 0;
		padding: 12px 18px;
		text-align: center;
		min-width: 108px;
	}
	.stat-number {
		font-size: 24px;
		font-weight: 800;
		color: #ffffff;
		line-height: 1;
	}
	.stat-label {
		font-size: 11px;
		color: #e2e8f0;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		margin-top: 6px;
	}

	/* Analytics Section Styling */
	.analytics-grid {
		display: grid;
		grid-template-columns: 1.2fr 1fr 1fr;
		gap: 20px;
		margin-bottom: 28px;
	}
	@media (max-width: 992px) {
		.analytics-grid {
			grid-template-columns: 1fr;
		}
	}
	.analytic-card {
		background: #ffffff;
		border: 1px solid #dce3ec;
		border-radius: 0;
		padding: 20px;
		box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.card-head {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 16px;
		padding-bottom: 12px;
		border-bottom: 1px solid #edf2f7;
	}
	.card-head-title {
		font-size: 14px;
		font-weight: 800;
		color: #1e293b;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.card-head-badge {
		font-size: 10px;
		font-weight: 700;
		background: #edf2f7;
		color: #2c5282;
		padding: 3px 8px;
		border-radius: 2px;
		text-transform: uppercase;
	}

	/* Horizontal Room Bar Chart */
	.room-bar-list {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}
	.bar-item {
		display: flex;
		flex-direction: column;
		gap: 4px;
	}
	.bar-meta {
		display: flex;
		justify-content: space-between;
		font-size: 12px;
		font-weight: 600;
		color: #334155;
	}
	.bar-track {
		height: 9px;
		background: #f1f5f9;
		border-radius: 0;
		overflow: hidden;
		position: relative;
	}
	.bar-fill {
		height: 100%;
		border-radius: 0;
		background: linear-gradient(90deg, #1a365d 0%, #3182ce 100%);
		transition: width 0.6s ease;
	}

	/* Donut Chart SVG */
	.donut-wrapper {
		display: flex;
		align-items: center;
		justify-content: space-around;
		gap: 12px;
		flex-wrap: wrap;
	}
	.donut-legend {
		display: flex;
		flex-direction: column;
		gap: 8px;
		font-size: 11.5px;
	}
	.legend-item {
		display: flex;
		align-items: center;
		gap: 8px;
		color: #475569;
		font-weight: 600;
	}
	.legend-dot {
		width: 10px;
		height: 10px;
		border-radius: 50%;
	}

	/* Leaderboard Dept */
	.dept-list {
		display: flex;
		flex-direction: column;
		gap: 8px;
	}
	.dept-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		background: #f8fafc;
		border: 1px solid #edf2f7;
		padding: 8px 12px;
		border-radius: 0;
		font-size: 12px;
	}
	.dept-rank {
		width: 20px;
		height: 20px;
		border-radius: 2px;
		background: #e2e8f0;
		color: #0f172a;
		font-size: 10px;
		font-weight: 800;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		margin-right: 8px;
	}
	.dept-rank-1 { background: #fef08a; color: #854d0e; }
	.dept-rank-2 { background: #e2e8f0; color: #475569; }
	.dept-rank-3 { background: #fed7aa; color: #9a3412; }

	.section-title {
		font-family: 'Open Sans', sans-serif;
		font-size: 18px;
		font-weight: 800;
		color: #1e293b;
		margin-bottom: 18px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 8px;
	}
	.room-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 20px;
		margin-bottom: 25px;
	}
	.room-card {
		background: #ffffff;
		border-radius: 0;
		overflow: hidden;
		border: 1px solid #dce3ec;
		box-shadow: 0 3px 10px rgba(15, 23, 42, 0.05);
		transition: all 0.25s ease;
		display: flex;
		flex-direction: column;
	}
	.room-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 12px 24px -8px rgba(44, 82, 130, 0.18);
		border-color: #2c5282;
	}

	/* Room Slider / Carousel */
	.room-slider {
		height: 220px;
		width: 100%;
		position: relative;
		overflow: hidden;
		background: #f8fafc;
		user-select: none;
	}
	.room-slider-track {
		display: flex;
		width: 100%;
		height: 100%;
		transition: transform 0.38s cubic-bezier(0.25, 1, 0.5, 1);
		will-change: transform;
	}
	.room-slide {
		flex: 0 0 100%;
		width: 100%;
		height: 100%;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
	}
	.room-slide img {
		width: 100%;
		height: 100%;
		display: block;
		transition: transform 0.4s ease;
	}
	.room-slide img.img-dummy {
		object-fit: contain;
		padding: 22px;
		opacity: 0.8;
	}
	.room-slide img.img-real {
		object-fit: cover;
	}
	.room-card:hover .room-slide img.img-real {
		transform: scale(1.05);
	}

	/* Tombol Geser Prev & Next */
	.room-slider-btn {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		width: 28px;
		height: 28px;
		border-radius: 2px;
		background: rgba(255, 255, 255, 0.92);
		border: 1px solid #cbd5e1;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
		display: flex;
		align-items: center;
		justify-content: center;
		color: #1e293b;
		font-size: 11px;
		cursor: pointer;
		z-index: 12;
		opacity: 0.8;
		transition: all 0.2s ease;
		padding: 0;
		outline: none;
	}
	.room-slider-btn.prev-btn {
		left: 8px;
	}
	.room-slider-btn.next-btn {
		right: 8px;
	}
	.room-card:hover .room-slider-btn,
	.room-slider:hover .room-slider-btn {
		opacity: 1;
		background: #ffffff;
	}
	.room-slider-btn:hover {
		background: #2c5282 !important;
		color: #ffffff !important;
		border-color: #2c5282 !important;
	}

	/* Counter Badge Kiri Atas (1/3) */
	.room-photo-counter {
		position: absolute;
		top: 10px;
		left: 10px;
		background: rgba(15, 23, 42, 0.72);
		color: #ffffff;
		padding: 3px 8px;
		border-radius: 2px;
		font-size: 10.5px;
		font-weight: 700;
		letter-spacing: 0.4px;
		z-index: 11;
		pointer-events: none;
		display: flex;
		align-items: center;
		gap: 3px;
	}

	/* Dots Navigation */
	.room-slider-dots {
		position: absolute;
		bottom: 10px;
		left: 50%;
		transform: translateX(-50%);
		display: flex;
		align-items: center;
		gap: 5px;
		z-index: 11;
	}
	.room-slider-dot {
		width: 6px;
		height: 6px;
		border-radius: 50%;
		background: rgba(148, 163, 184, 0.65);
		cursor: pointer;
		transition: all 0.25s ease;
	}
	.room-slider-dot.active {
		width: 16px;
		border-radius: 2px;
		background: #2c5282;
	}
	.room-slider-dot:hover:not(.active) {
		background: #64748b;
	}

	.room-tag {
		position: absolute;
		top: 10px;
		right: 10px;
		background: rgba(26, 54, 93, 0.9);
		color: #ffffff;
		padding: 4px 10px;
		border-radius: 2px;
		font-size: 11px;
		font-weight: 700;
	}
	.room-body {
		padding: 20px 20px 18px;
		flex-grow: 1;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.room-name {
		font-size: 18px;
		font-weight: 800;
		color: #1e293b;
		margin-bottom: 4px;
	}
	.room-info {
		font-size: 12.5px;
		color: #64748b;
		margin-bottom: 18px;
	}
	.room-footer {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding-top: 14px;
		border-top: 1px solid #f1f5f9;
	}
	.room-status {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		font-weight: 700;
		color: #059669;
		transition: all 0.25s ease;
	}
	.room-status.status-busy {
		color: #dc2626;
	}
	.room-status-dot {
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: #10b981;
		transition: all 0.25s ease;
	}
	.room-status-dot.dot-busy {
		background: #ef4444;
		box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25);
	}
	.btn-book {
		background: #edf2f7;
		color: #1a365d;
		border: 1px solid #cbd5e1;
		padding: 7px 14px;
		border-radius: 2px;
		font-size: 12.5px;
		font-weight: 700;
		text-decoration: none;
		transition: all 0.2s;
	}
	.btn-book:hover {
		background: #2c5282;
		border-color: #2c5282;
		color: #ffffff;
		text-decoration: none;
	}

	/* Responsive Mobile & Tablet untuk Halaman Beranda */
	@media (max-width: 767.98px) {
		.beranda-hero {
			padding: 18px 16px;
			margin-bottom: 18px;
			gap: 16px;
		}
		.hero-text {
			width: 100%;
		}
		.hero-text h2 {
			font-size: 18.5px;
			line-height: 1.3;
		}
		.hero-text p {
			font-size: 12.5px;
			margin-bottom: 14px;
			line-height: 1.5;
		}
		.hero-actions {
			width: 100%;
			flex-direction: column;
			align-items: stretch;
			gap: 8px;
		}
		.hero-actions .btn-cta,
		.hero-actions .btn-cta-outline {
			width: 100%;
			justify-content: center;
			text-align: center;
			padding: 10px 14px;
			font-size: 12.5px;
		}
		.hero-stats {
			width: 100%;
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 10px;
		}
		.stat-card {
			min-width: 0;
			padding: 12px 10px;
		}
		.stat-number {
			font-size: 22px;
		}
		.stat-label {
			font-size: 10px;
		}
		.analytics-grid {
			gap: 14px;
			margin-bottom: 22px;
		}
		.analytic-card {
			padding: 16px;
		}
		.section-title {
			font-size: 16px;
			margin-bottom: 14px;
			gap: 4px;
		}
		.section-title small {
			width: 100%;
			font-size: 11.5px;
		}
		.room-grid {
			grid-template-columns: 1fr;
			gap: 16px;
		}
		.room-slider {
			height: 200px;
		}
		.room-slider-btn {
			width: 32px;
			height: 32px;
			opacity: 0.92;
		}
		.room-body {
			padding: 18px 16px 16px;
		}
		.room-name {
			font-size: 17px;
		}
	}
</style>

<!-- Banner Hero -->
<div class="beranda-hero">
	<div class="hero-text">
		<?php if ($this->session->userdata('status-masuk') == 'masuk' && !empty($this->session->userdata('namalengkap'))): ?>
		<h2>Selamat Datang, <?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?></h2>
		<?php else: ?>
		<h2>Selamat Datang di Peminjaman Ruang Meeting</h2>
		<?php endif; ?>
		<p>Cek ketersediaan ruang meeting secara langsung, ajukan jadwal peminjaman, sinkronkan ke kalender kerja, atau lakukan verifikasi check-in QR.</p>
		<div class="hero-actions">
			<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="btn-cta">
				<i class="far fa-calendar-alt" style="margin-right:7px;"></i> Cek Ketersediaan &amp; Booking Ruang
			</a>
			<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>" class="btn-cta-outline">
				<i class="fas fa-list-ul" style="margin-right:6px;"></i> Lihat Daftar Agenda
			</a>
		</div>
	</div>
	<div class="hero-stats">
		<div class="stat-card">
			<div class="stat-number"><?php echo $total_ruangan; ?></div>
			<div class="stat-label">Ruang Meeting</div>
		</div>
		<div class="stat-card">
			<div class="stat-number"><?php echo $booking_hari_ini; ?></div>
			<div class="stat-label">Meeting Hari Ini</div>
		</div>
		<?php if($this->session->userdata('level') == 'Admin'): ?>
		<div class="stat-card">
			<div class="stat-number"><?php echo isset($total_agenda) ? $total_agenda : 0; ?></div>
			<div class="stat-label">Total Agenda</div>
		</div>
		<?php endif; ?>
	</div>
</div>


<?php if($this->session->userdata('level') == 'Admin'): ?>
<!-- BAGIAN ANALITIK & UTILISASI RUANG MEETING (KHUSUS ADMIN) -->
<div class="section-title">
	<span><i class="fas fa-chart-pie" style="color:#2c5282; margin-right:6px;"></i> Analitik &amp; Utilisasi Ruang Meeting</span>
	<small style="font-size:12px; color:#64748b; font-weight:normal;">Laporan metrik keterisian &amp; performa reservasi ruangan</small>
</div>

<div class="analytics-grid">
	<!-- Card 1: Frekuensi Ruangan -->
	<div class="analytic-card">
		<div class="card-head">
			<span class="card-head-title"><i class="fas fa-building" style="color:#2c5282;"></i> Utilisasi Ruangan</span>
			<span class="card-head-badge">Total Booking</span>
		</div>
		<div class="room-bar-list">
			<?php 
				$maxVal = 1;
				if (!empty($room_utilization)) {
					foreach ($room_utilization as $ru) {
						if ($ru['total_booking'] > $maxVal) $maxVal = $ru['total_booking'];
					}
				}
			?>
			<?php if(!empty($room_utilization)): ?>
				<?php foreach($room_utilization as $ru): ?>
				<?php 
					$pct = round(($ru['total_booking'] / $maxVal) * 100);
					if ($ru['total_booking'] == 0) $pct = 4;
				?>
				<div class="bar-item">
					<div class="bar-meta">
						<span><?php echo $ru['nama']; ?> <small style="color:#94a3b8; font-weight:normal;">(<?php echo $ru['kapasitas']; ?> Org)</small></span>
						<span style="color:#2c5282; font-weight:700;"><?php echo $ru['total_booking']; ?> Agenda</span>
					</div>
					<div class="bar-track">
						<div class="bar-fill" style="width: <?php echo $pct; ?>%;"></div>
					</div>
				</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div style="color:#94a3b8; font-size:12px; text-align:center; padding:20px;">Belum ada data utilisasi.</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Card 2: Status Distribusi & On-Time Check-In Donut -->
	<div class="analytic-card">
		<div class="card-head">
			<span class="card-head-title"><i class="fas fa-chart-pie" style="color:#10b981;"></i> Tingkat Kehadiran &amp; Status</span>
			<span class="card-head-badge">KPI</span>
		</div>
		<div class="donut-wrapper">
			<?php
				$totStatus = array_sum($status_counts);
				if ($totStatus == 0) $totStatus = 1;
				$cCircum = 251.2;
				$pSelesai   = ($status_counts['selesai'] / $totStatus);
				$pDisetujui = ($status_counts['disetujui'] / $totStatus);
				$pMenunggu  = ($status_counts['menunggu'] / $totStatus);
				$pBatal     = ($status_counts['batal'] / $totStatus);

				$dashSelesai   = $pSelesai * $cCircum;
				$dashDisetujui = $pDisetujui * $cCircum;
				$dashMenunggu  = $pMenunggu * $cCircum;
				$dashBatal     = $pBatal * $cCircum;
			?>
			<div style="position:relative; width:130px; height:130px;">
				<svg width="130" height="130" viewBox="0 0 100 100" style="transform: rotate(-90deg);">
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#f1f5f9" stroke-width="14"></circle>
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#10b981" stroke-width="14"
						stroke-dasharray="<?php echo $dashSelesai; ?> <?php echo $cCircum - $dashSelesai; ?>"
						stroke-dashoffset="0"></circle>
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#2c5282" stroke-width="14"
						stroke-dasharray="<?php echo $dashDisetujui; ?> <?php echo $cCircum - $dashDisetujui; ?>"
						stroke-dashoffset="-<?php echo $dashSelesai; ?>"></circle>
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#f59e0b" stroke-width="14"
						stroke-dasharray="<?php echo $dashMenunggu; ?> <?php echo $cCircum - $dashMenunggu; ?>"
						stroke-dashoffset="-<?php echo ($dashSelesai + $dashDisetujui); ?>"></circle>
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#f43f5e" stroke-width="14"
						stroke-dasharray="<?php echo $dashBatal; ?> <?php echo $cCircum - $dashBatal; ?>"
						stroke-dashoffset="-<?php echo ($dashSelesai + $dashDisetujui + $dashMenunggu); ?>"></circle>
				</svg>
				<div style="position:absolute; top:0; left:0; width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center;">
					<span style="font-size:20px; font-weight:900; color:#0f172a; line-height:1;"><?php echo $checkin_rate; ?>%</span>
					<span style="font-size:9px; color:#64748b; font-weight:700; text-transform:uppercase; margin-top:2px;">Check-In</span>
				</div>
			</div>
			<div class="donut-legend">
				<div class="legend-item">
					<span class="legend-dot" style="background:#10b981;"></span>
					<span>Selesai: <strong><?php echo $status_counts['selesai']; ?></strong></span>
				</div>
				<div class="legend-item">
					<span class="legend-dot" style="background:#2c5282;"></span>
					<span>Disetujui: <strong><?php echo $status_counts['disetujui']; ?></strong></span>
				</div>
				<div class="legend-item">
					<span class="legend-dot" style="background:#f59e0b;"></span>
					<span>Menunggu: <strong><?php echo $status_counts['menunggu']; ?></strong></span>
				</div>
				<div class="legend-item">
					<span class="legend-dot" style="background:#f43f5e;"></span>
					<span>Batal: <strong><?php echo $status_counts['batal']; ?></strong></span>
				</div>
			</div>
		</div>
	</div>

	<!-- Card 3: Top Departemen Peminjam -->
	<div class="analytic-card">
		<div class="card-head">
			<span class="card-head-title"><i class="fas fa-trophy" style="color:#f59e0b;"></i> Departemen Teraktif</span>
			<span class="card-head-badge">Top 5</span>
		</div>
		<div class="dept-list">
			<?php if(!empty($top_dept)): ?>
				<?php $rank = 1; foreach($top_dept as $td): ?>
				<?php 
					$rankClass = ($rank == 1) ? 'dept-rank-1' : (($rank == 2) ? 'dept-rank-2' : (($rank == 3) ? 'dept-rank-3' : ''));
				?>
				<div class="dept-item">
					<div>
						<span class="dept-rank <?php echo $rankClass; ?>"><?php echo $rank++; ?></span>
						<strong><?php echo htmlspecialchars($td['departemen_peminjam']); ?></strong>
					</div>
					<span style="font-weight:700; color:#2c5282; background:#edf2f7; padding:2px 8px; border-radius:2px; font-size:11px;">
						<?php echo $td['total']; ?> Meeting
					</span>
				</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div style="color:#94a3b8; font-size:12px; text-align:center; padding:20px;">Belum ada data departemen.</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Katalog Ruangan Meeting Pilihan -->
<div class="section-title">
	<span><i class="fas fa-door-open" style="color:#2c5282; margin-right:6px;"></i> Pilihan Ruang Meeting Kantor</span>
	<small style="font-size:12px; color:#64748b; font-weight:normal;">Dilengkapi fasilitas Smart TV, Whiteboard &amp; Video Conference</small>
</div>

<div class="room-grid">
	<?php 
		$roomGalleries = array(
			'Pulau Jawa' => array(
				'assets/img/rooms/pulau_jawa_1.png',
				'assets/img/rooms/pulau_jawa_2.png',
				'assets/img/rooms/pulau_jawa_3.png',
			),
			'Pulau Bali' => array(
				'assets/img/rooms/pulau_bali_1.png',
				'assets/img/rooms/pulau_bali_2.png',
				'assets/img/rooms/pulau_bali_3.png',
			),
			'Pulau Papua' => array(
				'assets/img/rooms/pulau_papua_1.png',
				'assets/img/rooms/pulau_papua_2.png',
				'assets/img/rooms/pulau_papua_3.png',
			),
			'Pulau Sumatra' => array(
				'assets/img/rooms/pulau_sumatra_1.png',
				'assets/img/rooms/pulau_sumatra_2.png',
				'assets/img/rooms/pulau_sumatra_3.png',
			),
			'Pulau Kalimantan' => array(
				'assets/img/rooms/pulau_kalimantan_1.png',
				'assets/img/rooms/pulau_kalimantan_2.png',
				'assets/img/rooms/pulau_kalimantan_3.png',
			),
		);
	?>
	<?php foreach ($rooms as $r): ?>
	<?php 
		$roomName = $r['nama_ruangan'];
		$photos = isset($roomGalleries[$roomName]) ? $roomGalleries[$roomName] : (
			isset($roomGalleries[$r['id_ruangan']]) ? $roomGalleries[$r['id_ruangan']] : array(
				'assets/img/rooms/default_1.png',
				'assets/img/rooms/default_2.png',
				'assets/img/rooms/default_3.png',
			)
		);
		$totalPhotos = count($photos);
	?>
	<div class="room-card">
		<div class="room-slider" data-room-id="<?php echo $r['id_ruangan']; ?>" data-current-index="0" data-total-slides="<?php echo $totalPhotos; ?>">
			<div class="room-slider-track">
				<?php foreach ($photos as $pIdx => $pPath): ?>
				<?php $isDummy = (strpos($pPath, 'room_dummy') !== false || strpos($pPath, 'rooms/') !== false); ?>
				<div class="room-slide">
					<img src="<?php echo base_url($pPath); ?>" alt="<?php echo htmlspecialchars($r['nama_ruangan'] . ' - Foto ' . ($pIdx + 1)); ?>" class="<?php echo $isDummy ? 'img-dummy' : 'img-real'; ?>">
				</div>
				<?php endforeach; ?>
			</div>

			<!-- Tag Kapasitas (Kanan Atas) -->
			<div class="room-tag"><i class="fas fa-users" style="margin-right:4px;"></i> <?php echo $r['kapasitas']; ?> Orang</div>

			<!-- Counter Foto (Kiri Atas) -->
			<div class="room-photo-counter"><i class="far fa-images" style="font-size:9.5px;"></i> <span class="counter-curr">1</span>/<span class="counter-total"><?php echo $totalPhotos; ?></span></div>

			<!-- Tombol Navigasi Geser (Prev & Next) -->
			<button type="button" class="room-slider-btn prev-btn" aria-label="Foto Sebelumnya" onclick="slideRoomPhoto(this, -1, event)">
				<i class="fas fa-chevron-left"></i>
			</button>
			<button type="button" class="room-slider-btn next-btn" aria-label="Foto Selanjutnya" onclick="slideRoomPhoto(this, 1, event)">
				<i class="fas fa-chevron-right"></i>
			</button>

			<!-- Indikator Dots -->
			<div class="room-slider-dots">
				<?php for ($d = 0; $d < $totalPhotos; $d++): ?>
				<span class="room-slider-dot <?php echo $d === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $d; ?>" onclick="goToRoomPhoto(this, <?php echo $d; ?>, event)"></span>
				<?php endfor; ?>
			</div>
		</div>
		<div class="room-body">
			<div>
				<div class="room-name"><?php echo $r['nama_ruangan']; ?></div>
				<div class="room-info">Ruang Meeting Kantor &middot; Lantai Operasional</div>
			</div>
			<div class="room-footer">
				<?php 
					$isBusy = !empty($r['is_busy']);
					$statusLabel = isset($r['status_realtime']) ? $r['status_realtime'] : $r['status'];
				?>
				<div class="room-status <?php echo $isBusy ? 'status-busy' : ''; ?>" data-room-id="<?php echo $r['id_ruangan']; ?>" data-room-name="<?php echo htmlspecialchars($r['nama_ruangan']); ?>">
					<span class="room-status-dot <?php echo $isBusy ? 'dot-busy' : ''; ?>"></span>
					<span class="room-status-text"><?php echo $statusLabel; ?></span>
				</div>
				<a href="<?php echo base_url('dashboard/ketersediaan-ruangan?ruangan=' . rawurlencode($r['nama_ruangan'])); ?>" class="btn-book">
					Pilih Slot &rarr;
				</a>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<script>
// Navigasi Slider Foto Ruangan
window.slideRoomPhoto = function(btn, direction, event) {
	if (event) {
		event.preventDefault();
		event.stopPropagation();
	}
	var slider = btn.closest('.room-slider');
	if (!slider) return;

	var currentIndex = parseInt(slider.getAttribute('data-current-index') || '0', 10);
	var totalSlides = parseInt(slider.getAttribute('data-total-slides') || '3', 10);

	var nextIndex = currentIndex + direction;
	if (nextIndex < 0) {
		nextIndex = totalSlides - 1;
	} else if (nextIndex >= totalSlides) {
		nextIndex = 0;
	}

	updateRoomSliderPosition(slider, nextIndex);
};

window.goToRoomPhoto = function(dot, targetIndex, event) {
	if (event) {
		event.preventDefault();
		event.stopPropagation();
	}
	var slider = dot.closest('.room-slider');
	if (!slider) return;

	updateRoomSliderPosition(slider, targetIndex);
};

function updateRoomSliderPosition(slider, index) {
	slider.setAttribute('data-current-index', index);
	var track = slider.querySelector('.room-slider-track');
	if (track) {
		track.style.transform = 'translateX(-' + (index * 100) + '%)';
	}

	var currCounter = slider.querySelector('.counter-curr');
	if (currCounter) {
		currCounter.textContent = (index + 1);
	}

	var dots = slider.querySelectorAll('.room-slider-dot');
	dots.forEach(function(d, dIdx) {
		if (dIdx === index) {
			d.classList.add('active');
		} else {
			d.classList.remove('active');
		}
	});
}

(function() {
	var HOVER_FIRST_DELAY = 600;
	var HOVER_INTERVAL    = 1800;

	function autoNext(slider) {
		var curr  = parseInt(slider.getAttribute('data-current-index') || '0', 10);
		var total = parseInt(slider.getAttribute('data-total-slides') || '1', 10);
		if (total <= 1) return;
		updateRoomSliderPosition(slider, (curr + 1) % total);
	}

	function stopHoverSlide(slider) {
		if (slider._hoverTimeout) { clearTimeout(slider._hoverTimeout); slider._hoverTimeout = null; }
		if (slider._hoverInterval) { clearInterval(slider._hoverInterval); slider._hoverInterval = null; }
	}

	function startHoverSlide(slider) {
		stopHoverSlide(slider);
		slider._hoverTimeout = setTimeout(function() {
			autoNext(slider);
			slider._hoverInterval = setInterval(function() { autoNext(slider); }, HOVER_INTERVAL);
		}, HOVER_FIRST_DELAY);
	}

	document.querySelectorAll('.room-slider').forEach(function(slider) {
		slider.addEventListener('mouseenter', function() { startHoverSlide(slider); });
		slider.addEventListener('mouseleave', function() { stopHoverSlide(slider); });
		slider.addEventListener('click', function() {
			if (slider.matches(':hover')) startHoverSlide(slider);
		}, true);
	});

	document.querySelectorAll('.room-slider').forEach(function(slider) {
		var startX = 0;
		slider.addEventListener('touchstart', function(e) {
			if (e.changedTouches && e.changedTouches[0]) {
				startX = e.changedTouches[0].screenX;
			}
		}, { passive: true });
		slider.addEventListener('touchend', function(e) {
			if (e.changedTouches && e.changedTouches[0]) {
				var endX = e.changedTouches[0].screenX;
				var diff = startX - endX;
				if (Math.abs(diff) > 40) {
					if (diff > 0) {
						var nextBtn = slider.querySelector('.next-btn');
						if (nextBtn) slideRoomPhoto(nextBtn, 1, e);
					} else {
						var prevBtn = slider.querySelector('.prev-btn');
						if (prevBtn) slideRoomPhoto(prevBtn, -1, e);
					}
				}
			}
		}, { passive: true });
	});

	function syncRealtimeRoomStatus() {
		fetch('<?php echo base_url("dashboard/status-ruangan-realtime"); ?>')
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (!Array.isArray(data)) return;
				data.forEach(function(room) {
					var el = document.querySelector('.room-status[data-room-id="' + room.id_ruangan + '"]');
					if (!el) return;
					var dot = el.querySelector('.room-status-dot');
					var text = el.querySelector('.room-status-text');

					if (room.is_busy) {
						el.classList.add('status-busy');
						if (dot) dot.classList.add('dot-busy');
					} else {
						el.classList.remove('status-busy');
						if (dot) dot.classList.remove('dot-busy');
					}
					if (text) {
						text.textContent = room.status;
					}
				});
			})
			.catch(function(err) {});
	}

	setInterval(syncRealtimeRoomStatus, 30000);
})();
</script>
