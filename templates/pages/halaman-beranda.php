<?php
date_default_timezone_set('Asia/Jakarta');
$hari_indo = array('Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu');
$bulan_indo = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
$hari_ini_label = $hari_indo[date('l')] . ', ' . date('d') . ' ' . $bulan_indo[(int)date('n')] . ' ' . date('Y');
?>
<style>
	/* =========================================================
	   MINIMALIST SPLIT WORKSPACE — BERANDA
	   ========================================================= */
	.ws-overview-bar {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-left: 4px solid #0f766e;
		padding: 18px 22px;
		margin-bottom: 18px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 18px;
	}
	.ws-overview-left {
		display: flex;
		flex-direction: column;
		gap: 6px;
		min-width: 0;
	}
	.ws-overview-date {
		font-size: 11px;
		font-weight: 700;
		color: #0f766e;
		text-transform: uppercase;
		letter-spacing: 0.8px;
		display: inline-flex;
		align-items: center;
		gap: 6px;
	}
	.ws-overview-left h2 {
		font-size: 20px;
		font-weight: 800;
		color: #0f172a;
		margin: 0;
		letter-spacing: -0.3px;
	}
	.ws-overview-sub {
		font-size: 13px;
		color: #64748b;
		margin: 0;
	}
	.ws-overview-actions {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		margin-top: 6px;
	}
	.ws-btn-primary {
		background: #0f766e;
		color: #ffffff !important;
		border: 1px solid #0f766e;
		padding: 8px 16px;
		font-size: 12.5px;
		font-weight: 700;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		text-decoration: none;
		transition: all 0.18s ease;
	}
	.ws-btn-primary:hover {
		background: #115e59;
		border-color: #115e59;
		color: #ffffff !important;
	}
	.ws-btn-secondary {
		background: #f8fafc;
		color: #1e293b !important;
		border: 1px solid #cbd5e1;
		padding: 8px 15px;
		font-size: 12.5px;
		font-weight: 700;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		text-decoration: none;
		transition: all 0.18s ease;
	}
	.ws-btn-secondary:hover {
		background: #0f172a;
		border-color: #0f172a;
		color: #ffffff !important;
	}

	/* Compact KPI Strip inside Overview Bar */
	.ws-kpi-strip {
		display: flex;
		align-items: stretch;
		gap: 10px;
		flex-wrap: wrap;
	}
	.ws-kpi-tile {
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		padding: 10px 16px;
		min-width: 118px;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}
	.ws-kpi-tile.is-highlight {
		background: #f0fdfa;
		border-color: #99f6e4;
	}
	.ws-kpi-val {
		font-family: 'Roboto', 'Open Sans', sans-serif;
		font-size: 20px;
		font-weight: 800;
		color: #0f172a;
		line-height: 1.15;
	}
	.ws-kpi-tile.is-highlight .ws-kpi-val {
		color: #0f766e;
	}
	.ws-kpi-label {
		font-size: 10.5px;
		font-weight: 700;
		color: #64748b;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		margin-top: 3px;
	}

	/* Split Workspace 2-Column Layout */
	.ws-split-grid {
		display: grid;
		grid-template-columns: minmax(0, 1.6fr) minmax(300px, 1fr);
		gap: 18px;
		align-items: start;
	}
	.ws-panel {
		background: #ffffff;
		border: 1px solid #e2e8f0;
	}
	.ws-panel-head {
		padding: 13px 18px;
		background: #f8fafc;
		border-bottom: 1px solid #e2e8f0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
	}
	.ws-panel-title {
		font-size: 14px;
		font-weight: 800;
		color: #0f172a;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		margin: 0;
	}
	.ws-panel-badge {
		font-size: 11px;
		font-weight: 700;
		color: #0f766e;
		background: #f0fdfa;
		border: 1px solid #99f6e4;
		padding: 2px 8px;
	}

	/* Horizontal Compact Room List */
	.ws-room-list {
		display: flex;
		flex-direction: column;
	}
	.ws-room-row {
		display: flex;
		align-items: stretch;
		gap: 16px;
		padding: 14px 18px;
		border-bottom: 1px solid #f1f5f9;
		transition: background-color 0.16s ease;
	}
	.ws-room-row:last-child {
		border-bottom: none;
	}
	.ws-room-row:hover {
		background: #f8fafc;
	}

	/* Compact Thumbnail Slider inside Horizontal Row */
	.room-slider {
		width: 158px;
		height: 106px;
		flex-shrink: 0;
		position: relative;
		overflow: hidden;
		background: #f1f5f9;
		border: 1px solid #e2e8f0;
		user-select: none;
	}
	.room-slider-track {
		display: flex;
		width: 100%;
		height: 100%;
		transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
		will-change: transform;
	}
	.room-slide {
		flex: 0 0 100%;
		width: 100%;
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
	}
	.room-slide img {
		width: 100%;
		height: 100%;
		display: block;
	}
	.room-slide img.img-dummy {
		object-fit: contain;
		padding: 12px;
		opacity: 0.82;
	}
	.room-slide img.img-real {
		object-fit: cover;
	}
	.room-slider-btn {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		width: 24px;
		height: 24px;
		background: rgba(15, 23, 42, 0.72);
		border: none;
		color: #ffffff;
		font-size: 10px;
		cursor: pointer;
		z-index: 12;
		display: flex;
		align-items: center;
		justify-content: center;
		opacity: 0;
		transition: opacity 0.18s ease, background-color 0.18s ease;
		padding: 0;
	}
	.room-slider-btn.prev-btn { left: 4px; }
	.room-slider-btn.next-btn { right: 4px; }
	.ws-room-row:hover .room-slider-btn,
	.room-slider:hover .room-slider-btn {
		opacity: 1;
	}
	.room-slider-btn:hover {
		background: #0f766e;
	}
	.room-photo-counter {
		position: absolute;
		top: 5px;
		left: 5px;
		background: rgba(15, 23, 42, 0.75);
		color: #ffffff;
		padding: 1px 6px;
		font-size: 9.5px;
		font-weight: 700;
		z-index: 11;
		pointer-events: none;
		display: flex;
		align-items: center;
		gap: 3px;
	}
	.room-slider-dots {
		position: absolute;
		bottom: 6px;
		left: 50%;
		transform: translateX(-50%);
		display: flex;
		align-items: center;
		gap: 4px;
		z-index: 11;
	}
	.room-slider-dot {
		width: 5px;
		height: 5px;
		background: rgba(148, 163, 184, 0.7);
		cursor: pointer;
		transition: all 0.2s ease;
	}
	.room-slider-dot.active {
		width: 12px;
		background: #0d9488;
	}

	/* Middle Info & Right CTA inside Room Row */
	.ws-room-content {
		flex: 1;
		min-width: 0;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		gap: 8px;
	}
	.ws-room-top {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 10px;
		flex-wrap: wrap;
	}
	.ws-room-name {
		font-size: 16px;
		font-weight: 800;
		color: #0f172a;
		margin: 0 0 3px 0;
	}
	.ws-room-specs {
		font-size: 12px;
		color: #64748b;
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 10px;
	}
	.ws-room-cap {
		background: #f1f5f9;
		color: #1e293b;
		border: 1px solid #cbd5e1;
		padding: 2px 8px;
		font-size: 11px;
		font-weight: 700;
		white-space: nowrap;
	}
	.ws-room-bottom {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
		flex-wrap: wrap;
		padding-top: 6px;
		border-top: 1px dashed #e2e8f0;
	}
	.room-status {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 12px;
		font-weight: 700;
		color: #059669;
		background: #ecfdf5;
		border: 1px solid #a7f3d0;
		padding: 3px 9px;
	}
	.room-status.status-busy {
		color: #dc2626;
		background: #fef2f2;
		border-color: #fecaca;
	}
	.room-status-dot {
		width: 7px;
		height: 7px;
		background: #10b981;
	}
	.room-status-dot.dot-busy {
		background: #ef4444;
	}
	.btn-book {
		background: #0f172a;
		color: #ffffff !important;
		border: 1px solid #0f172a;
		padding: 6px 14px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 5px;
		transition: all 0.18s ease;
	}
	.btn-book:hover {
		background: #0f766e;
		border-color: #0f766e;
		color: #ffffff !important;
		text-decoration: none;
	}

	/* Right Column Stack: Agenda Hari Ini + Admin Metrics */
	.ws-side-stack {
		display: flex;
		flex-direction: column;
		gap: 18px;
	}
	.ws-agenda-list {
		display: flex;
		flex-direction: column;
	}
	.ws-agenda-item {
		padding: 12px 16px;
		border-bottom: 1px solid #f1f5f9;
		display: flex;
		gap: 12px;
		align-items: flex-start;
	}
	.ws-agenda-item:last-child {
		border-bottom: none;
	}
	.ws-agenda-time {
		background: #0f172a;
		color: #5eead4;
		font-family: 'Roboto', sans-serif;
		font-size: 11.5px;
		font-weight: 700;
		padding: 5px 8px;
		min-width: 64px;
		text-align: center;
		flex-shrink: 0;
		line-height: 1.3;
	}
	.ws-agenda-time small {
		display: block;
		font-size: 9.5px;
		color: #cbd5e1;
		font-weight: 500;
	}
	.ws-agenda-info {
		flex: 1;
		min-width: 0;
	}
	.ws-agenda-room {
		font-size: 13px;
		font-weight: 800;
		color: #0f172a;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 6px;
	}
	.ws-agenda-meta {
		font-size: 11.5px;
		color: #475569;
		margin-top: 2px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.ws-agenda-desc {
		font-size: 11.5px;
		color: #64748b;
		margin-top: 3px;
	}
	.ws-status-pill {
		font-size: 10px;
		font-weight: 700;
		padding: 2px 6px;
		text-transform: uppercase;
		flex-shrink: 0;
	}
	.ws-status-pill.is-approved { background: #dcfce7; color: #166534; }
	.ws-status-pill.is-pending { background: #fef3c7; color: #92400e; }
	.ws-status-pill.is-done { background: #e2e8f0; color: #334155; }

	.ws-panel-foot {
		padding: 11px 16px;
		background: #f8fafc;
		border-top: 1px solid #e2e8f0;
		text-align: right;
	}
	.ws-panel-foot a {
		font-size: 12px;
		font-weight: 700;
		color: #0f766e;
	}

	/* Compact Admin Analytics */
	.ws-admin-body {
		padding: 16px;
		display: flex;
		flex-direction: column;
		gap: 16px;
	}
	.ws-mini-heading {
		font-size: 11.5px;
		font-weight: 800;
		color: #334155;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		margin-bottom: 8px;
		display: flex;
		justify-content: space-between;
	}
	.room-bar-list {
		display: flex;
		flex-direction: column;
		gap: 9px;
	}
	.bar-meta {
		display: flex;
		justify-content: space-between;
		font-size: 11.5px;
		font-weight: 600;
		color: #334155;
		margin-bottom: 3px;
	}
	.bar-track {
		height: 7px;
		background: #f1f5f9;
		overflow: hidden;
	}
	.bar-fill {
		height: 100%;
		background: #0d9488;
	}
	.ws-stat-row {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 6px;
	}
	.ws-stat-box {
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		padding: 8px 6px;
		text-align: center;
	}
	.ws-stat-box strong {
		display: block;
		font-size: 15px;
		font-weight: 800;
		color: #0f172a;
	}
	.ws-stat-box span {
		font-size: 10px;
		font-weight: 700;
		color: #64748b;
		text-transform: uppercase;
	}
	.dept-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 6px 10px;
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		font-size: 12px;
		margin-bottom: 6px;
	}
	.dept-item:last-child {
		margin-bottom: 0;
	}

	/* Responsive Breakpoints */
	@media (max-width: 991.98px) {
		.ws-split-grid {
			grid-template-columns: 1fr;
		}
	}
	@media (max-width: 767.98px) {
		.ws-overview-bar {
			padding: 14px 16px;
			gap: 14px;
		}
		.ws-overview-left h2 {
			font-size: 17.5px;
		}
		.ws-overview-actions {
			width: 100%;
		}
		.ws-btn-primary,
		.ws-btn-secondary {
			flex: 1 1 0;
			justify-content: center;
			text-align: center;
			padding: 9px 10px;
			font-size: 12px;
		}
		.ws-kpi-strip {
			width: 100%;
			display: grid;
			grid-template-columns: repeat(2, 1fr);
		}
		.ws-kpi-tile {
			min-width: 0;
			padding: 9px 12px;
		}
		.ws-room-row {
			flex-direction: column;
			gap: 12px;
			padding: 14px;
		}
		.room-slider {
			width: 100%;
			height: 165px;
		}
		.room-slider-btn {
			opacity: 0.9;
			width: 30px;
			height: 30px;
		}
		.ws-stat-row {
			grid-template-columns: repeat(2, 1fr);
		}
	}
</style>

<!-- 1. TOP WORKSPACE OVERVIEW BAR -->
<div class="ws-overview-bar">
	<div class="ws-overview-left">
		<span class="ws-overview-date">
			<i class="far fa-calendar"></i> <?php echo $hari_ini_label; ?> &middot; <span id="ws-live-clock"><?php echo date('H:i'); ?></span> WIB
		</span>
		<?php if ($this->session->userdata('status-masuk') == 'masuk' && !empty($this->session->userdata('namalengkap'))): ?>
		<h2>Workspace Booking &mdash; Halo, <?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?></h2>
		<?php else: ?>
		<h2>Workspace Reservasi Ruang Meeting</h2>
		<?php endif; ?>
		<p class="ws-overview-sub">Pantau status ruangan secara real-time, lihat agenda hari ini, dan reservasi slot jam meeting secara langsung.</p>
		<div class="ws-overview-actions">
			<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="ws-btn-primary">
				<i class="far fa-calendar-plus"></i> Booking Ruangan
			</a>
			<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>" class="ws-btn-secondary">
				<i class="fas fa-table"></i> Data Peminjaman
			</a>
		</div>
	</div>

	<div class="ws-kpi-strip">
		<div class="ws-kpi-tile is-highlight">
			<div class="ws-kpi-val"><?php echo isset($rooms_available_now) ? $rooms_available_now : $total_ruangan; ?> / <?php echo $total_ruangan; ?></div>
			<div class="ws-kpi-label">Ruang Tersedia</div>
		</div>
		<div class="ws-kpi-tile">
			<div class="ws-kpi-val"><?php echo $booking_hari_ini; ?></div>
			<div class="ws-kpi-label">Meeting Hari Ini</div>
		</div>
		<?php if($this->session->userdata('level') == 'Admin'): ?>
		<div class="ws-kpi-tile">
			<div class="ws-kpi-val"><?php echo isset($total_agenda) ? $total_agenda : 0; ?></div>
			<div class="ws-kpi-label">Total Arsip Agenda</div>
		</div>
		<?php else: ?>
		<div class="ws-kpi-tile">
			<div class="ws-kpi-val">08–17</div>
			<div class="ws-kpi-label">Jam Operasional</div>
		</div>
		<?php endif; ?>
	</div>
</div>

<!-- 2. SPLIT WORKSPACE: KIRI DAFTAR RUANGAN KOMPAK | KANAN AGENDA HARI INI (+ ANALITIK ADMIN) -->
<div class="ws-split-grid">
	<!-- KOLOM KIRI: LIST HORIZONTAL RUANGAN -->
	<div class="ws-panel">
		<div class="ws-panel-head">
			<h3 class="ws-panel-title"><i class="fas fa-door-open" style="color:#0f766e;"></i> Daftar Ruang Meeting</h3>
			<span class="ws-panel-badge"><?php echo $total_ruangan; ?> Ruangan</span>
		</div>

		<div class="ws-room-list">
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
				$isBusy = !empty($r['is_busy']);
				$statusLabel = isset($r['status_realtime']) ? $r['status_realtime'] : $r['status'];
			?>
			<div class="ws-room-row">
				<!-- Mini Thumbnail Slider -->
				<div class="room-slider" data-room-id="<?php echo $r['id_ruangan']; ?>" data-current-index="0" data-total-slides="<?php echo $totalPhotos; ?>">
					<div class="room-slider-track">
						<?php foreach ($photos as $pIdx => $pPath): ?>
						<?php $isDummy = (strpos($pPath, 'room_dummy') !== false || strpos($pPath, 'rooms/') !== false); ?>
						<div class="room-slide">
							<img src="<?php echo base_url($pPath); ?>" alt="<?php echo htmlspecialchars($r['nama_ruangan'] . ' - Foto ' . ($pIdx + 1)); ?>" class="<?php echo $isDummy ? 'img-dummy' : 'img-real'; ?>">
						</div>
						<?php endforeach; ?>
					</div>
					<div class="room-photo-counter"><i class="far fa-images" style="font-size:9px;"></i> <span class="counter-curr">1</span>/<span class="counter-total"><?php echo $totalPhotos; ?></span></div>
					<button type="button" class="room-slider-btn prev-btn" aria-label="Foto Sebelumnya" onclick="slideRoomPhoto(this, -1, event)"><i class="fas fa-chevron-left"></i></button>
					<button type="button" class="room-slider-btn next-btn" aria-label="Foto Selanjutnya" onclick="slideRoomPhoto(this, 1, event)"><i class="fas fa-chevron-right"></i></button>
					<div class="room-slider-dots">
						<?php for ($d = 0; $d < $totalPhotos; $d++): ?>
						<span class="room-slider-dot <?php echo $d === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $d; ?>" onclick="goToRoomPhoto(this, <?php echo $d; ?>, event)"></span>
						<?php endfor; ?>
					</div>
				</div>

				<!-- Detail & Status Ruangan -->
				<div class="ws-room-content">
					<div class="ws-room-top">
						<div>
							<h4 class="ws-room-name"><?php echo htmlspecialchars($r['nama_ruangan']); ?></h4>
							<div class="ws-room-specs">
								<span><i class="fas fa-tv" style="color:#0f766e; margin-right:3px;"></i> Smart TV</span>
								<span><i class="fas fa-chalkboard" style="color:#0f766e; margin-right:3px;"></i> Whiteboard</span>
								<span><i class="fas fa-video" style="color:#0f766e; margin-right:3px;"></i> Video Conf</span>
							</div>
						</div>
						<span class="ws-room-cap"><i class="fas fa-users" style="margin-right:4px;"></i> <?php echo $r['kapasitas']; ?> Orang</span>
					</div>

					<div class="ws-room-bottom">
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
	</div>

	<!-- KOLOM KANAN: AGENDA HARI INI + ANALITIK ADMIN -->
	<div class="ws-side-stack">
		<!-- Panel Agenda Hari Ini -->
		<div class="ws-panel">
			<div class="ws-panel-head">
				<h3 class="ws-panel-title"><i class="far fa-clock" style="color:#0f766e;"></i> Agenda Hari Ini</h3>
				<span class="ws-panel-badge"><?php echo date('d/m/Y'); ?></span>
			</div>

			<div class="ws-agenda-list">
				<?php if(!empty($today_schedules)): ?>
					<?php foreach($today_schedules as $sch): ?>
					<?php
						$jamMulai = substr($sch['jam_meeting'], 0, 5);
						$jamSelesai = date('H:i', strtotime($sch['jam_meeting']) + 3600);
						$st = $sch['status_pinjam'];
						$stClass = ($st == 'Disetujui') ? 'is-approved' : (($st == 'Menunggu') ? 'is-pending' : 'is-done');
						$peminjamLabel = !empty($sch['nama_peminjam']) ? $sch['nama_peminjam'] : $sch['peminjam'];
					?>
					<div class="ws-agenda-item">
						<div class="ws-agenda-time">
							<?php echo $jamMulai; ?>
							<small>s/d <?php echo $jamSelesai; ?></small>
						</div>
						<div class="ws-agenda-info">
							<div class="ws-agenda-room">
								<span><?php echo htmlspecialchars($sch['ruangan_dipinjam']); ?></span>
								<span class="ws-status-pill <?php echo $stClass; ?>"><?php echo $st; ?></span>
							</div>
							<div class="ws-agenda-meta">
								<strong><?php echo htmlspecialchars($peminjamLabel); ?></strong>
								<?php if(!empty($sch['departemen_peminjam'])): ?>
									&middot; <?php echo htmlspecialchars($sch['departemen_peminjam']); ?>
								<?php endif; ?>
							</div>
							<?php if(!empty($sch['keterangan'])): ?>
							<div class="ws-agenda-desc"><?php echo htmlspecialchars($sch['keterangan']); ?></div>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
				<?php else: ?>
					<div style="padding:28px 18px; text-align:center; color:#64748b; font-size:12.5px;">
						<i class="far fa-calendar-check" style="font-size:24px; color:#94a3b8; display:block; margin-bottom:8px;"></i>
						Belum ada jadwal meeting terdaftar untuk hari ini.
					</div>
				<?php endif; ?>
			</div>

			<div class="ws-panel-foot">
				<a href="<?php echo base_url('dashboard/data-peminjaman?periode=hari_ini'); ?>">Lihat Detail Peminjaman &rarr;</a>
			</div>
		</div>

		<?php if($this->session->userdata('level') == 'Admin'): ?>
		<!-- Panel Ringkasan Analitik Khusus Admin -->
		<div class="ws-panel">
			<div class="ws-panel-head">
				<h3 class="ws-panel-title"><i class="fas fa-chart-bar" style="color:#0f766e;"></i> Analitik Admin</h3>
				<span class="ws-panel-badge">Check-In <?php echo $checkin_rate; ?>%</span>
			</div>

			<div class="ws-admin-body">
				<div>
					<div class="ws-mini-heading"><span>Distribusi Status</span><span>Total <?php echo isset($total_agenda) ? $total_agenda : 0; ?></span></div>
					<div class="ws-stat-row">
						<div class="ws-stat-box"><strong><?php echo $status_counts['selesai']; ?></strong><span>Selesai</span></div>
						<div class="ws-stat-box"><strong><?php echo $status_counts['disetujui']; ?></strong><span>Setuju</span></div>
						<div class="ws-stat-box"><strong><?php echo $status_counts['menunggu']; ?></strong><span>Tunggu</span></div>
						<div class="ws-stat-box"><strong><?php echo $status_counts['batal']; ?></strong><span>Batal</span></div>
					</div>
				</div>

				<div>
					<div class="ws-mini-heading"><span>Utilisasi Ruangan</span><span>Booking</span></div>
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
							<?php $pct = ($ru['total_booking'] == 0) ? 4 : round(($ru['total_booking'] / $maxVal) * 100); ?>
							<div>
								<div class="bar-meta">
									<span><?php echo htmlspecialchars($ru['nama']); ?></span>
									<span style="color:#0f766e; font-weight:700;"><?php echo $ru['total_booking']; ?>x</span>
								</div>
								<div class="bar-track">
									<div class="bar-fill" style="width: <?php echo $pct; ?>%;"></div>
								</div>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<?php if(!empty($top_dept)): ?>
				<div>
					<div class="ws-mini-heading"><span>Departemen Teraktif</span><span>Top 5</span></div>
					<?php $rank = 1; foreach($top_dept as $td): ?>
					<div class="dept-item">
						<span><strong>#<?php echo $rank++; ?></strong> <?php echo htmlspecialchars($td['departemen_peminjam']); ?></span>
						<span style="color:#0f766e; font-weight:700;"><?php echo $td['total']; ?>x</span>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>

<script>
// Jam Live WIB di Workspace Overview Bar
(function() {
	var clockEl = document.getElementById('ws-live-clock');
	if (clockEl) {
		setInterval(function() {
			var now = new Date();
			var wib = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
			var hh = String(wib.getHours()).padStart(2, '0');
			var mm = String(wib.getMinutes()).padStart(2, '0');
			clockEl.textContent = hh + ':' + mm;
		}, 15000);
	}
})();

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
