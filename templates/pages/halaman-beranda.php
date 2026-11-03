<style>
	.beranda-hero {
		background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f766e 100%);
		border-radius: 16px;
		padding: 24px 32px;
		color: #ffffff;
		margin-bottom: 22px;
		box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
	}
	.hero-text h2 {
		font-size: 26px;
		font-weight: 800;
		margin-bottom: 8px;
		letter-spacing: -0.5px;
	}
	.hero-text p {
		font-size: 14px;
		color: #cbd5e1;
		max-width: 580px;
		margin-bottom: 20px;
		line-height: 1.6;
	}
	.hero-actions .btn-cta {
		background: #0284c7;
		color: #ffffff;
		padding: 10px 22px;
		border-radius: 8px;
		font-weight: 700;
		text-decoration: none;
		font-size: 13px;
		display: inline-block;
		box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4);
		transition: all 0.2s ease;
	}
	.hero-actions .btn-cta:hover {
		background: #0369a1;
		transform: translateY(-2px);
		color: #ffffff;
	}
	.hero-stats {
		display: flex;
		gap: 16px;
	}
	.stat-card {
		background: rgba(255, 255, 255, 0.08);
		backdrop-filter: blur(8px);
		border: 1px solid rgba(255, 255, 255, 0.15);
		border-radius: 12px;
		padding: 15px 22px;
		text-align: center;
		min-width: 110px;
	}
	.stat-number {
		font-size: 28px;
		font-weight: 900;
		color: #38bdf8;
		line-height: 1;
	}
	.stat-label {
		font-size: 11px;
		color: #94a3b8;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-top: 5px;
	}

	/* Analytics Section Styling */
	.analytics-grid {
		display: grid;
		grid-template-columns: 1.2fr 1fr 1fr;
		gap: 20px;
		margin-bottom: 26px;
	}
	@media (max-width: 992px) {
		.analytics-grid {
			grid-template-columns: 1fr;
		}
	}
	.analytic-card {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-radius: 14px;
		padding: 20px;
		box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
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
		border-bottom: 1px solid #f1f5f9;
	}
	.card-head-title {
		font-size: 14px;
		font-weight: 800;
		color: #0f172a;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.card-head-badge {
		font-size: 10px;
		font-weight: 700;
		background: #f1f5f9;
		color: #475569;
		padding: 3px 8px;
		border-radius: 12px;
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
		border-radius: 6px;
		overflow: hidden;
		position: relative;
	}
	.bar-fill {
		height: 100%;
		border-radius: 6px;
		background: linear-gradient(90deg, #0284c7 0%, #38bdf8 100%);
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
		border: 1px solid #f1f5f9;
		padding: 8px 12px;
		border-radius: 8px;
		font-size: 12px;
	}
	.dept-rank {
		width: 20px;
		height: 20px;
		border-radius: 50%;
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
		font-size: 18px;
		font-weight: 700;
		color: #1e293b;
		margin-bottom: 18px;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	.room-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 24px;
		margin-bottom: 25px;
	}
	.room-card {
		background: #ffffff;
		border-radius: 14px;
		overflow: hidden;
		border: 1px solid #e2e8f0;
		box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
		transition: all 0.3s ease;
		display: flex;
		flex-direction: column;
	}
	.room-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.12);
		border-color: #0284c7;
	}
	.room-img-wrapper {
		height: 165px;
		width: 100%;
		overflow: hidden;
		position: relative;
	}
	.room-img-wrapper img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.4s ease;
	}
	.room-card:hover .room-img-wrapper img {
		transform: scale(1.05);
	}
	.room-tag {
		position: absolute;
		top: 12px;
		right: 12px;
		background: rgba(15, 23, 42, 0.75);
		backdrop-filter: blur(4px);
		color: #ffffff;
		padding: 4px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
	}
	.room-body {
		padding: 18px;
		flex-grow: 1;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.room-name {
		font-size: 16px;
		font-weight: 700;
		color: #0f172a;
		margin-bottom: 4px;
	}
	.room-info {
		font-size: 12px;
		color: #64748b;
		margin-bottom: 16px;
	}
	.room-footer {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding-top: 12px;
		border-top: 1px solid #f1f5f9;
	}
	.room-status {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 12px;
		font-weight: 600;
		color: #059669;
	}
	.room-status-dot {
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: #10b981;
	}
	.btn-book {
		background: #f0fdf4;
		color: #15803d;
		border: 1px solid #bbf7d0;
		padding: 6px 14px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		transition: all 0.2s;
	}
	.btn-book:hover {
		background: #15803d;
		color: #ffffff;
		text-decoration: none;
	}
</style>

<!-- Banner Hero Medquest -->
<div class="beranda-hero">
	<div class="hero-text">
		<h2>Selamat Datang, <?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?> </h2>
		<p>Sistem Manajemen & Peminjaman Ruang Meeting Terintegrasi PT Medquest Jaya Global. Cek ketersediaan ruang, sinkronkan ke kalender kerja, atau lakukan verifikasi check-in langsung.</p>
		<div class="hero-actions">
			<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="btn-cta">
				<i class="far fa-calendar-alt" style="margin-right:6px;"></i> Cek Ketersediaan & Booking Ruang
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
<!-- ========================================== -->
<!-- BAGIAN ANALITIK & UTILISASI RUANG MEETING (KHUSUS ADMIN) -->
<!-- ========================================== -->
<div class="section-title">
	<span><i class="fas fa-chart-pie" style="color:#0284c7; margin-right:6px;"></i> Analitik & Utilisasi Ruang Meeting</span>
	<small style="font-size:12px; color:#64748b; font-weight:normal;">Laporan metrik keterisian & performa reservasi ruangan</small>
</div>

<div class="analytics-grid">
	<!-- Card 1: Frekuensi Ruangan -->
	<div class="analytic-card">
		<div class="card-head">
			<span class="card-head-title"><i class="fas fa-building" style="color:#0284c7;"></i> Utilisasi Ruangan</span>
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
						<span style="color:#0284c7; font-weight:700;"><?php echo $ru['total_booking']; ?> Agenda</span>
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
			<span class="card-head-title"><i class="fas fa-chart-pie" style="color:#10b981;"></i> Tingkat Kehadiran & Status</span>
			<span class="card-head-badge">KPI</span>
		</div>
		<div class="donut-wrapper">
			<!-- SVG Donut Chart -->
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
					<!-- Selesai (Green) -->
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#10b981" stroke-width="14"
						stroke-dasharray="<?php echo $dashSelesai; ?> <?php echo $cCircum - $dashSelesai; ?>"
						stroke-dashoffset="0"></circle>
					<!-- Disetujui (Sky Blue) -->
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#0284c7" stroke-width="14"
						stroke-dasharray="<?php echo $dashDisetujui; ?> <?php echo $cCircum - $dashDisetujui; ?>"
						stroke-dashoffset="-<?php echo $dashSelesai; ?>"></circle>
					<!-- Menunggu (Amber) -->
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#f59e0b" stroke-width="14"
						stroke-dasharray="<?php echo $dashMenunggu; ?> <?php echo $cCircum - $dashMenunggu; ?>"
						stroke-dashoffset="-<?php echo ($dashSelesai + $dashDisetujui); ?>"></circle>
					<!-- Dibatalkan (Rose) -->
					<circle cx="50" cy="50" r="40" fill="transparent" stroke="#f43f5e" stroke-width="14"
						stroke-dasharray="<?php echo $dashBatal; ?> <?php echo $cCircum - $dashBatal; ?>"
						stroke-dashoffset="-<?php echo ($dashSelesai + $dashDisetujui + $dashMenunggu); ?>"></circle>
				</svg>
				<div style="position:absolute; top:0; left:0; width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center;">
					<span style="font-size:20px; font-weight:900; color:#0f172a; line-height:1;"><?php echo $checkin_rate; ?>%</span>
					<span style="font-size:9px; color:#64748b; font-weight:700; text-transform:uppercase; margin-top:2px;">Check-In</span>
				</div>
			</div>
			<!-- Legend -->
			<div class="donut-legend">
				<div class="legend-item">
					<span class="legend-dot" style="background:#10b981;"></span>
					<span>Selesai: <strong><?php echo $status_counts['selesai']; ?></strong></span>
				</div>
				<div class="legend-item">
					<span class="legend-dot" style="background:#0284c7;"></span>
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
					<span style="font-weight:700; color:#0284c7; background:#e0f2fe; padding:2px 8px; border-radius:10px; font-size:11px;">
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
<?php endif; ?><!-- Katalog Ruangan Meeting Pilihan -->
<div class="section-title">
	<span><i class="fas fa-door-open" style="color:#0284c7; margin-right:6px;"></i> Pilihan Ruang Meeting Kantor</span>
	<small style="font-size:12px; color:#64748b; font-weight:normal;">Dilengkapi fasilitas Smart TV, Whiteboard & Video Conference</small>
</div>

<div class="room-grid">
	<?php 
		$roomImages = array(
			'R001' => 'assets/img/room_focus.jpg',
			'R002' => 'assets/img/room_huddle.jpg',
			'R003' => 'assets/img/room_board.jpg',
			'R004' => 'assets/img/room_focus.jpg',
			'R005' => 'assets/img/room_board.jpg'
		);
	?>
	<?php foreach ($rooms as $r): ?>
	<?php 
		$img = isset($roomImages[$r['id_ruangan']]) ? $roomImages[$r['id_ruangan']] : 'assets/img/interior.jpg';
	?>
	<div class="room-card">
		<div class="room-img-wrapper">
			<img src="<?php echo base_url($img); ?>" alt="<?php echo $r['nama_ruangan']; ?>">
			<div class="room-tag"><i class="fas fa-users" style="margin-right:4px;"></i> <?php echo $r['kapasitas']; ?> Orang</div>
		</div>
		<div class="room-body">
			<div>
				<div class="room-name"><?php echo $r['nama_ruangan']; ?></div>
				<div class="room-info">PT Medquest Jaya Global · Lantai Operasional</div>
			</div>
			<div class="room-footer">
				<div class="room-status">
					<span class="room-status-dot"></span> <?php echo $r['status']; ?>
				</div>
				<a href="<?php echo base_url('dashboard/ketersediaan-ruangan?ruangan=' . rawurlencode($r['nama_ruangan'])); ?>" class="btn-book">
					Pilih Slot ?
				</a>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>


