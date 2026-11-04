<?php date_default_timezone_set('Asia/Jakarta'); ?>

<style>
	.table-card {
		background: #ffffff;
		border-radius: 14px;
		border: 1px solid #e2e8f0;
		box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.05);
		overflow: hidden;
		margin-bottom: 30px;
	}
	.table-custom {
		width: 100%;
		border-collapse: separate;
		border-spacing: 0;
	}
	.table-custom th {
		background: #f8fafc;
		color: #475569;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		padding: 14px 16px;
		border-bottom: 2px solid #e2e8f0;
		border-top: none;
	}
	.table-custom td {
		padding: 14px 16px;
		vertical-align: middle;
		border-bottom: 1px solid #f1f5f9;
		font-size: 13px;
		color: #1e293b;
	}
	.table-custom tr:last-child td {
		border-bottom: none;
	}
	.table-custom tr:hover td {
		background-color: #f8fafc;
	}
	.badge-status {
		display: inline-flex;
		align-items: center;
		padding: 5px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 700;
	}
	.status-menunggu {
		background: #fef3c7;
		color: #b45309;
		border: 1px solid #fde68a;
	}
	.status-disetujui {
		background: #dcfce7;
		color: #15803d;
		border: 1px solid #bbf7d0;
	}
	.status-dibatalkan {
		background: #fee2e2;
		color: #b91c1c;
		border: 1px solid #fca5a5;
	}
	.status-selesai {
		background: #e0f2fe;
		color: #0369a1;
		border: 1px solid #bae6fd;
	}
	.btn-action-group {
		display: inline-flex;
		gap: 6px;
		align-items: center;
	}
	.btn-approve {
		background: #059669;
		color: #ffffff;
		border: none;
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 4px;
		box-shadow: 0 2px 4px rgba(5, 150, 105, 0.25);
		transition: all 0.2s;
	}
	.btn-approve:hover {
		background: #047857;
		color: #ffffff;
		text-decoration: none;
		transform: translateY(-1px);
	}
	.btn-cancel {
		background: #fee2e2;
		color: #b91c1c;
		border: 1px solid #fca5a5;
		padding: 5px 10px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 600;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 4px;
		transition: all 0.2s;
	}
	.btn-cancel:hover {
		background: #ef4444;
		color: #ffffff;
		border-color: #ef4444;
		text-decoration: none;
	}
	.btn-complete {
		background: #0059fb;
		color: #ffffff;
		border: none;
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 4px;
	}
	.btn-complete:hover {
		background: #0369a1;
		color: #ffffff;
		text-decoration: none;
	}
	.badge-room {
		background: #f1f5f9;
		color: #0f172a;
		border: 1px solid #cbd5e1;
		padding: 4px 10px;
		border-radius: 6px;
		font-weight: 700;
		font-size: 12px;
		display: inline-block;
	}
	.schedule-pill {
		display: flex;
		flex-direction: column;
		line-height: 1.3;
	}
	.schedule-date {
		font-weight: 700;
		color: #1e293b;
	}
	.schedule-time {
		font-size: 11px;
		color: #0059fb;
		font-weight: 600;
	}
	.btn-export-excel {
		background: #f0fdf4;
		color: #166534;
		border: 1px solid #bbf7d0;
		padding: 7px 14px;
		border-radius: 8px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		transition: all 0.2s;
	}
	.btn-export-excel:hover {
		background: #16a34a;
		color: #ffffff;
		text-decoration: none;
		box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);
	}
	.btn-print-report {
		background: #f8fafc;
		color: #334155;
		border: 1px solid #cbd5e1;
		padding: 7px 14px;
		border-radius: 8px;
		font-size: 12px;
		font-weight: 700;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		transition: all 0.2s;
	}
	.btn-print-report:hover {
		background: #0f172a;
		color: #ffffff;
		border-color: #0f172a;
		text-decoration: none;
		box-shadow: 0 2px 6px rgba(15, 23, 42, 0.25);
	}
	.btn-cal-menu {
		background: #f0f9ff;
		border: 1px solid #bae6fd;
		color: #0369a1;
		font-size: 11px;
		font-weight: 700;
		padding: 3px 8px;
		border-radius: 5px;
		display: inline-flex;
		align-items: center;
		gap: 4px;
		cursor: pointer;
	}
	.btn-cal-menu:hover {
		background: #e0f2fe;
		color: #0059fb;
	}
</style>

<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE) && !empty($jumlah_menunggu)): ?>
<div class="alert alert-warning" role="status" style="background:#fffbeb; border-color:#fde68a; color:#92400e; font-weight:600; border-radius:10px; padding:12px 18px; margin-bottom:18px;">
	<i class="fas fa-bell" style="margin-right:6px;"></i> Ada <strong><?php echo $jumlah_menunggu; ?> pengajuan peminjaman</strong> yang menunggu keputusan (Setujui / Batalkan).
</div>
<?php endif; ?>

<?php if($this->session->flashdata('pesan_sukses')): ?>
<div class="alert alert-success" role="alert" style="background:#dcfce7; border-color:#86efac; color:#166534; font-weight:600; border-radius:10px; padding:12px 18px; margin-bottom:18px;">
	<i class="fas fa-check-circle" style="color:#16a34a; margin-right:6px;"></i> <?php echo $this->session->flashdata('pesan_sukses'); ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('pesan_error')): ?>
<div class="alert alert-danger" role="alert" style="background:#fee2e2; border-color:#fca5a5; color:#991b1b; font-weight:600; border-radius:10px; padding:12px 18px; margin-bottom:18px;">
	<i class="fas fa-exclamation-triangle" style="color:#dc2626; margin-right:6px;"></i> <?php echo $this->session->flashdata('pesan_error'); ?>
</div>
<?php endif; ?>

<!-- Filter Tab / Dropdown Periode Data Peminjaman -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:12px;">
	<div style="display:inline-flex; background:#f1f5f9; padding:4px; border-radius:10px; border:1px solid #e2e8f0;">
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=hari_ini'); ?>" 
		   style="padding:7px 18px; font-size:12px; font-weight:700; border-radius:8px; text-decoration:none; transition:all 0.2s; <?php echo (isset($filter_periode) && $filter_periode == 'hari_ini') ? 'background:#0059fb; color:#ffffff; box-shadow:0 2px 6px rgba(2,132,199,0.3);' : 'color:#64748b;'; ?>">
			<i class="far fa-calendar-check" style="margin-right:4px;"></i> Hari Ini (<?php echo date('d M'); ?>)
		</a>
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=kemarin'); ?>" 
		   style="padding:7px 18px; font-size:12px; font-weight:700; border-radius:8px; text-decoration:none; transition:all 0.2s; <?php echo (isset($filter_periode) && $filter_periode == 'kemarin') ? 'background:#0059fb; color:#ffffff; box-shadow:0 2px 6px rgba(2,132,199,0.3);' : 'color:#64748b;'; ?>">
			<i class="far fa-calendar" style="margin-right:4px;"></i> Kemarin
		</a>
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=semua'); ?>" 
		   style="padding:7px 18px; font-size:12px; font-weight:700; border-radius:8px; text-decoration:none; transition:all 0.2s; <?php echo (!isset($filter_periode) || $filter_periode == 'semua') ? 'background:#0059fb; color:#ffffff; box-shadow:0 2px 6px rgba(2,132,199,0.3);' : 'color:#64748b;'; ?>">
			<i class="fas fa-bars" style="margin-right:4px;"></i> Semua Data
		</a>
	</div>

		<!-- Info Jumlah Ditampilkan & Tombol Ekspor -->
	<div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
		<div style="font-size:13px; color:#64748b; font-weight:600;">
			Menampilkan: <span style="color:#0f172a; font-weight:700;"><?php echo count($tb); ?> Data</span>
			<?php if(isset($filter_periode) && $filter_periode == 'hari_ini'): ?>
				<span style="color:#0059fb;">(Jadwal Hari Ini)</span>
			<?php elseif(isset($filter_periode) && $filter_periode == 'kemarin'): ?>
				<span style="color:#64748b;">(Jadwal Kemarin)</span>
			<?php else: ?>
				<span style="color:#64748b;">(Keseluruhan Arsip)</span>
			<?php endif; ?>
		</div>
		<div style="display:flex; align-items:center; gap:8px;">
			<a href="<?php echo base_url('dashboard/ekspor-excel?periode=' . (isset($filter_periode) ? $filter_periode : 'semua')); ?>" target="_blank" class="btn-export-excel" 
			   title="Download Laporan Format Excel / CSV">
				<i class="fas fa-file-excel" style="color:#16a34a; margin-right:5px;"></i> Ekspor Excel
			</a>
			<a href="<?php echo base_url('dashboard/cetak-laporan?periode=' . (isset($filter_periode) ? $filter_periode : 'semua')); ?>" 
			   target="_blank"
			   class="btn-print-report" 
			   title="Cetak atau Simpan PDF Laporan Resmi">
				<i class="fas fa-print" style="margin-right:5px;"></i> Cetak / PDF
			</a>
		</div>
	</div>
</div>
<!-- Tabel Data Peminjaman Modern -->
<div class="table-card">
	<table class="table-custom">
		<thead>
			<tr>
				<th style="width: 45px; text-align:center;">No.</th>
				<th>ID & Peminjam</th>
				<th>Ruang Meeting</th>
				<th>Jadwal Pelaksanaan</th>
				<th>Agenda Meeting</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Verifikasi Check-In</th>
				<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
				<th style="text-align:center; min-width: 170px;">Keputusan / Aksi</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php if(empty($tb)): ?>
			<tr>
				<td align="center" colspan="8" style="padding: 35px 20px; color:#94a3b8;">
					<i class="far fa-folder-open" style="font-size: 28px; margin-bottom: 8px; display:block;"></i>
					Belum ada data peminjaman ruangan.
				</td>
			</tr>
			<?php endif; ?>

			<?php $no = 1; foreach ($tb as $baris): ?>
			<tr>
				<td align="center" style="color:#64748b; font-weight:600;"><?php echo $no; ?></td>
				<td>
					<div style="font-weight:700; color:#0f172a;">
						<?php echo htmlspecialchars(!empty($baris['nama_peminjam']) ? $baris['nama_peminjam'] : $baris['peminjam']); ?>
					</div>
					<div style="font-size:11px; color:#64748b; margin-top:2px;">
						<span style="color:#0059fb; font-weight:600;"><?php echo $baris['id_peminjaman']; ?></span>
						<?php if(!empty($baris['departemen_peminjam'])): ?>
							&middot; Dept: <?php echo htmlspecialchars($baris['departemen_peminjam']); ?>
						<?php endif; ?>
						<?php if(!empty($baris['telepon_peminjam'])): ?>
							(<?php echo htmlspecialchars($baris['telepon_peminjam']); ?>)
						<?php endif; ?>
					</div>
				</td>
				<td>
					<span class="badge-room"><i class="fas fa-map-marker-alt" style="color:#0059fb; margin-right:4px;"></i> <?php echo $baris['ruangan_dipinjam']; ?></span>
				</td>
				<td>
					<?php if(!empty($baris['tanggal_meeting']) && !empty($baris['jam_meeting'])): ?>
						<div class="schedule-pill">
							<span class="schedule-date"><?php echo date('d M Y', strtotime($baris['tanggal_meeting'])); ?></span>
							<span class="schedule-time">Pukul <?php echo substr($baris['jam_meeting'], 0, 5); ?> WIB</span>
						</div>
					<?php else: ?>
						<span style="color:#94a3b8;">-</span>
					<?php endif; ?>
				</td>
				<td>
					<span style="font-weight:500; color:#334155;"><?php echo htmlspecialchars($baris['keterangan']); ?></span>
				</td>
				<td align="center">
					<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
						<span class="badge-status status-menunggu"><i class="far fa-clock" style="margin-right:3px;"></i> Menunggu</span>
					<?php elseif($baris['status_pinjam'] == 'Disetujui'): ?>
						<span class="badge-status status-disetujui"><i class="fas fa-check" style="margin-right:3px;"></i> Disetujui</span>
					<?php elseif($baris['status_pinjam'] == 'Selesai'): ?>
						<span class="badge-status status-selesai"><i class="fas fa-check-circle" style="margin-right:3px;"></i> Selesai</span>
					<?php else: ?>
						<span class="badge-status status-dibatalkan"><i class="fas fa-times-circle" style="margin-right:3px;"></i> Dibatalkan</span>
					<?php endif; ?>
				</td>
				<td align="center">
					<?php if($baris['status_pinjam'] == 'Disetujui'): ?>
						<?php if(!empty($baris['waktu_checkin'])): ?>
							<span class="badge" style="background:#16a34a; color:#fff; padding:6px 10px; border-radius:6px; font-size:11px; display:inline-block; font-weight:700;">
								<i class="fas fa-user-check" style="margin-right:3px;"></i> Check-In (<?php echo date('H:i', strtotime($baris['waktu_checkin'])); ?>)
							</span>
						<?php else: ?>
							<?php 
								$mStart = strtotime($baris['tanggal_meeting'] . ' ' . $baris['jam_meeting']);
								$tolerance = $mStart + 600; // 10 menit setelah jam booking
								$now = time();
								$todayDate = date('Y-m-d');
								$isToday = ($baris['tanggal_meeting'] == $todayDate);
							?>
							<?php if(!$isToday || $now < $mStart): ?>
								<span style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; padding:4px 8px; border-radius:6px; font-size:11px; display:inline-block;">
									Belum Waktunya<br>
									<small style="font-size:10px; color:#94a3b8;">(Mulai <?php echo substr($baris['jam_meeting'], 0, 5); ?>)</small>
								</span>
							<?php elseif($now > $tolerance): ?>
								<span style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5; padding:4px 8px; border-radius:6px; font-size:11px; display:inline-block; font-weight:600;">
									Lewat Batas<br>
									<small style="font-size:10px;">Auto-Cancel</small>
								</span>
							<?php else: ?>
								<a href="<?php echo base_url('dashboard/proses-checkin/' . $baris['id_peminjaman']); ?>" 
								   class="btn btn-sm btn-success" 
								   style="background:#059669; border:none; color:#fff; font-size:11px; padding:6px 14px; border-radius:6px; font-weight:bold; text-decoration:none; display:inline-block; box-shadow:0 2px 4px rgba(0,0,0,0.1);" 
								   >
									<i class="fas fa-qrcode" style="margin-right:4px;"></i> Check-In Sekarang
								</a>
								<div style="font-size:10px; color:#e11d48; margin-top:3px; font-weight:700;">
									Tersisa <?php echo max(0, ceil(($tolerance - $now) / 60)); ?> menit!
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php elseif($baris['status_pinjam'] == 'Selesai'): ?>
						<span style="color:#059669; font-size:12px; font-weight:600;"><i class="fas fa-check-circle" style="color:#059669; margin-right:3px;"></i> Ruang Selesai Digunakan</span>
					<?php elseif($baris['status_pinjam'] == 'Dibatalkan'): ?>
						<span style="color:#94a3b8; font-size:12px;">-</span>
					<?php else: ?>
						<span style="color:#94a3b8; font-size:11px;">Menunggu Persetujuan</span>
					<?php endif; ?>
				</td>
				<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
				<td align="center">
					<div class="btn-action-group">
						<!-- Tombol Khusus Admin & Resepsionis / Operator -->
						<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
							<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
								<!-- Tombol Setujui Langsung -->
								<a href="" data-toggle="modal" data-target="#setujui<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-approve">
									<i class="fas fa-check" style="margin-right:4px;"></i> Setujui
								</a>
								<!-- Tombol Tolak / Batalkan -->
								<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel">
									<i class="fas fa-times" style="margin-right:4px;"></i> Tolak
								</a>
							<?php elseif($baris['status_pinjam'] == 'Disetujui'): ?>
								<!-- Tombol Selesaikan Meeting -->
								<a href="" data-toggle="modal" data-target="#selesaikan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-complete">
									<i class="fas fa-check-double" style="margin-right:4px;"></i> Selesaikan
								</a>
								<!-- Tombol Batalkan darurat jika perlu -->
								<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel" title="Batalkan Jadwal"><i class="fas fa-ban"></i></a>
							<?php endif; ?>
						<?php endif; ?>

						<!-- Aksi Peminjam (Pengguna Biasa) -->
						<?php if($this->session->userdata('level') == 'Pengguna' && $baris['status_pinjam'] == 'Menunggu'): ?>
							<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel">
								<i class="fas fa-times" style="margin-right:4px;"></i> Batalkan
							</a>
						<?php endif; ?>

						<!-- Tombol Sunting (Hanya jika masih menunggu) -->
						<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
							<a href="" data-toggle="modal" data-target="#suntingpinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" style="color:#64748b; padding:4px 8px; border-radius:4px; border:1px solid #e2e8f0; font-size:12px; text-decoration:none;" title="Sunting">
								<i class="fas fa-pencil-alt"></i>
							</a>
						<?php endif; ?>

												<!-- Integrasi Kalender (Bila status Disetujui atau Selesai) -->
						<?php if(in_array($baris['status_pinjam'], array('Disetujui', 'Selesai'), TRUE)): ?>
							<div class="dropdown" style="display:inline-block;">
								<button class="btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown" style="background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1; font-size:11px; font-weight:700; padding:5px 8px; border-radius:6px; cursor:pointer;" title="Sinkronisasi ke Kalender Kerja">
									<i class="far fa-calendar-alt" style="margin-right:4px;"></i> Kalender <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-right" style="font-size:12px; min-width:165px; box-shadow:0 4px 15px rgba(0,0,0,0.12); border-radius:8px; border:1px solid #e2e8f0; padding:6px 0;">
									<li>
										<a href="<?php echo base_url('dashboard/kalender-google/' . $baris['id_peminjaman']); ?>" target="_blank" style="padding:7px 14px; display:flex; align-items:center; gap:8px;">
											<i class="fab fa-google" style="color:#ea4335; margin-right:6px;"></i> Google Calendar
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('dashboard/kalender-ics/' . $baris['id_peminjaman']); ?>" style="padding:7px 14px; display:flex; align-items:center; gap:8px;">
											<i class="fab fa-windows" style="color:#0078d4; margin-right:6px;"></i> Outlook / iCal (.ics)
										</a>
									</li>
								</ul>
							</div>
						<?php endif; ?>

						<!-- Tombol Hapus Database (Hanya Admin) -->
						<?php if($this->session->userdata('level') == 'Admin'): ?>
							<a href="" data-toggle="modal" data-target="#hapuspinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" style="color:#ef4444; padding:4px 8px; border-radius:4px; border:1px solid #fee2e2; font-size:12px; text-decoration:none;" title="Hapus Permanen">
								<i class="fas fa-trash-alt"></i>
							</a>
						<?php endif; ?>
					</div>
				</td>
				<?php endif; ?>
			</tr>
			<?php $no++; endforeach; ?>
		</tbody>
	</table>
</div>
<!-- Tabel Data Peminjaman Modern [Akhir] -->

<!-- Fungsi untuk Cetak ID Peminjaman Otomatis -->
<?php foreach($tb_idpinjam as $baris_id): ?>
	<?php
		$kode   = substr($baris_id['id_peminjaman'],4,5);
		$tambah = $kode + 1;
		if($tambah < 10)
		{
			$id_pinjam = "MDQ-0000".$tambah;
		}
		else
		{
			$id_pinjam = "MDQ-000".$tambah;
		}
	?>
<?php endforeach; ?>

<div id="ajukanpinjam" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Ajukan Peminjaman Ruang Meeting
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/pinjam-ruang'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $id_pinjam; ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" value="<?php echo $id_pinjam; ?>" disabled />
					</li>
					<input type="hidden" name="peminjam" value="<?php echo $this->session->userdata('namalengkap'); ?>">
					<input type="hidden" name="waktu_pengajuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" name="nama_peminjam" placeholder="Nama peminjam" maxlength="50" value="<?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-apartment"></i></div><input type="text" name="departemen_peminjam" placeholder="Departemen peminjam" maxlength="50" required />
					</li>
					<li>
						<div><i class="lnr lnr-phone-handset"></i></div><input type="tel" name="telepon_peminjam" placeholder="Nomor telepon" maxlength="20" pattern="[0-9+\-\s]{8,20}" title="Masukkan nomor telepon yang valid (8-20 digit)" required />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="nama_ruangan" required="required">
							<option value="" selected>Ruang</option>

							<?php foreach($tb_ruangan as $baris_ruangan): ?>
								<option value="<?php echo $baris_ruangan['nama_ruangan']; ?>" <?php if($selected_room == $baris_ruangan['nama_ruangan']) echo 'selected'; ?>>
									<?php echo $baris_ruangan['nama_ruangan']; ?><?php if(isset($baris_ruangan['kapasitas'])) echo ' (' . $baris_ruangan['kapasitas'] . ' orang)'; ?>
								</option>
							<?php endforeach; ?>

						</select>
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="date" name="tanggal_meeting" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $selected_date; ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-clock"></i></div><select name="jam_meeting" required>
							<option value="">Pilih jam meeting</option>
							<?php foreach($booking_slots as $booking_slot): ?>
							<option value="<?php echo $booking_slot; ?>" <?php if(in_array($booking_slot, $occupied_slots)) echo 'disabled'; ?> <?php if($selected_time == $booking_slot && !in_array($booking_slot, $occupied_slots)) echo 'selected'; ?>><?php echo $booking_slot; ?> - <?php echo date('H:i', strtotime($booking_slot) + 3600); ?><?php if(in_array($booking_slot, $occupied_slots)) echo ' (Sudah dipesan)'; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Ajukan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Pengajuan Pinjam Ruang [Akhir] -->


<!-- Modal Perbarui Status Peminjaman [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="suntingpinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Sunting Pengajuan Meeting
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/perbarui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" value="<?php echo $baris['id_peminjaman']; ?> (tidak dapat diubah)" disabled />
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" value="<?php echo $baris['keterangan']; ?>" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" name="tombol_simpan" value="Simpan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer" >
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Perbarui Status Peminjaman [Akhir] -->


<!-- Modal Hapus Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="hapuspinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Hapus Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/hapus-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<p>Apakah Anda yakin ingin menghapus peminjaman <span><?php echo $baris['id_peminjaman']; ?></span> dari sistem?</p>
					</li>
					<br />
					<li>
						<input type="submit" name="tombol_hapus" value="Hapus" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Hapus Peminjaman Ruang [Akhir] -->


<!-- Modal Penyetujuan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="setujui<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Setujui Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/setujui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_penyetujuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin menyetujui pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_setujui" value="Setujui" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Penyetujuan Peminjaman Ruang [Akhir] -->


<!-- Modal Pembatalan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="batalkan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Batalkan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/batalkan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pembatalan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin membatalkan pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_batalkan" value="Batalkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Pembatalan Peminjaman Ruang [Akhir] -->


<!-- Modal Selesaikan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="selesaikan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Selesaikan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/selesaikan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pengembalian" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin menyelesaikan pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Sedang digunakan' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_selesaikan" value="Selesaikan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Selesaikan Peminjaman Ruang [Akhir] -->


<!-- Modal Laporan Peminjaman Ruang [Awal] -->
<div id="lap-peminjaman" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Laporan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/laporan-peminjaman'); ?>
				<ul>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_awal" class="datepicker-report" placeholder="Tanggal awal" required />
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_akhir" class="datepicker-report" placeholder="Tanggal akhir" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" value="Tampilkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Laporan Peminjaman Ruang [Akhir] -->


<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker-report').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        });
		<?php if($selected_time): ?>
		$('#ajukanpinjam').modal('show');
		<?php endif; ?>
    });
</script>






