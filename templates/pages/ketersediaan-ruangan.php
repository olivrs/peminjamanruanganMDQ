<form method="get" action="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="availability-filter">
	<label for="availability-date">Tanggal meeting</label>
	<input id="availability-date" type="date" name="tanggal" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $tanggal; ?>" required>
	<label for="availability-room">Ruang meeting</label>
	<select id="availability-room" name="ruangan" required>
		<?php foreach ($tb as $baris): ?>
		<option value="<?php echo $baris['nama_ruangan']; ?>" <?php if($nama_ruangan == $baris['nama_ruangan']) echo 'selected'; ?>><?php echo $baris['nama_ruangan']; ?><?php if(isset($baris['kapasitas'])) echo ' - ' . $baris['kapasitas'] . ' orang'; ?></option>
		<?php endforeach; ?>
	</select>
	<button type="submit">Lihat Slot</button>
</form>

<?php if(empty($tb)): ?>
	<p>Belum ada ruang meeting terdaftar.</p>
<?php else: ?>
	<div class="availability-heading">
		<strong><?php echo $nama_ruangan; ?></strong>
		<span><?php echo date('d/m/Y', strtotime($tanggal)); ?></span>
	</div>
	<div class="availability-legend">
		<span><i class="availability-dot available"></i>Tersedia, klik untuk mengajukan</span>
		<span><i class="availability-dot booked"></i>Sudah dipesan</span>
	</div>
	<div class="availability-slots">
		<?php foreach ($slots as $slot): ?>
			<?php $is_booked = in_array($slot, $booked_slots); $is_elapsed = in_array($slot, $elapsed_slots); ?>
			<?php if($is_booked || $is_elapsed): ?>
				<button class="availability-slot unavailable" type="button" disabled>
					<strong><?php echo $slot; ?></strong>
					<span><?php echo date('H:i', strtotime($slot) + 3600); ?></span>
					<small><?php echo $is_booked ? 'Sudah dipesan' : 'Waktu lewat'; ?></small>
				</button>
			<?php else: ?>
				<a class="availability-slot available" href="<?php echo base_url('dashboard/data-peminjaman?nama_ruangan=' . rawurlencode($nama_ruangan) . '&tanggal_meeting=' . $tanggal . '&jam_meeting=' . rawurlencode($slot)); ?>">
					<strong><?php echo $slot; ?></strong>
					<span><?php echo date('H:i', strtotime($slot) + 3600); ?></span>
					<small>Pilih slot</small>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
