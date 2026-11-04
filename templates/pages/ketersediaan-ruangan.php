<?php date_default_timezone_set('Asia/Jakarta'); ?>

<form method="get" action="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="availability-filter">
	<label for="availability-date">Tanggal meeting</label>
	<input id="availability-date" type="date" name="tanggal" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $tanggal; ?>" required onchange="this.form.submit()">
	<label for="availability-room">Ruang meeting</label>
	<select id="availability-room" name="ruangan" required onchange="this.form.submit()">
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
		<strong><i class="fas fa-door-open" style="color:#0059fb; margin-right:6px;"></i> <?php echo htmlspecialchars($nama_ruangan); ?></strong>
		<span><i class="far fa-calendar-alt" style="margin-right:4px;"></i> <?php echo date('d/m/Y', strtotime($tanggal)); ?></span>
	</div>
	<div class="availability-legend">
		<span><i class="availability-dot available"></i>Tersedia — klik jam untuk langsung mengisi form booking</span>
		<span><i class="availability-dot booked"></i>Sudah dipesan / Waktu lewat</span>
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
				<a class="availability-slot available" href="javascript:void(0);" onclick="bukaFormBooking('<?php echo htmlspecialchars($slot, ENT_QUOTES); ?>')">
					<strong><?php echo $slot; ?></strong>
					<span><?php echo date('H:i', strtotime($slot) + 3600); ?></span>
					<small><i class="fas fa-edit"></i> Isi Form Booking</small>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<!-- Fungsi untuk Cetak ID Peminjaman Otomatis -->
<?php
$id_pinjam = "MDQ-00001";
if (!empty($tb_idpinjam)) {
	foreach($tb_idpinjam as $baris_id) {
		$kode   = (int) substr($baris_id['id_peminjaman'], 4, 5);
		$tambah = $kode + 1;
		$id_pinjam = "MDQ-" . str_pad((string)$tambah, 5, "0", STR_PAD_LEFT);
	}
}
?>

<!-- Modal Form Pengajuan Booking Langsung -->
<div id="ajukanpinjam" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Form Peminjaman Ruang Meeting
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/pinjam-ruang'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $id_pinjam; ?>">
					<li>
						<div><i class="lnr lnr-tag"></i></div><input type="text" value="ID Booking: <?php echo $id_pinjam; ?>" disabled />
					</li>
					<input type="hidden" name="peminjam" value="<?php echo htmlspecialchars((string)$this->session->userdata('namalengkap')); ?>">
					<input type="hidden" name="waktu_pengajuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" name="nama_peminjam" placeholder="Nama lengkap peminjam" maxlength="50" value="<?php echo htmlspecialchars((string)$this->session->userdata('namalengkap')); ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-apartment"></i></div><input type="text" name="departemen_peminjam" placeholder="Departemen / Divisi" maxlength="50" required />
					</li>
					<li>
						<div><i class="lnr lnr-phone-handset"></i></div><input type="tel" name="telepon_peminjam" placeholder="Nomor telepon / WhatsApp" maxlength="20" pattern="[0-9+\-\s]{8,20}" title="Masukkan nomor telepon yang valid (8-20 digit)" required />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="nama_ruangan" id="modal-nama-ruangan" required="required">
							<option value="">Pilih Ruang Meeting</option>
							<?php foreach($tb as $baris_ruangan): ?>
								<option value="<?php echo $baris_ruangan['nama_ruangan']; ?>" <?php if($nama_ruangan == $baris_ruangan['nama_ruangan']) echo 'selected'; ?>>
									<?php echo $baris_ruangan['nama_ruangan']; ?><?php if(isset($baris_ruangan['kapasitas'])) echo ' (' . $baris_ruangan['kapasitas'] . ' orang)'; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="date" name="tanggal_meeting" id="modal-tanggal-meeting" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $tanggal; ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-clock"></i></div><select name="jam_meeting" id="modal-jam-meeting" required>
							<option value="">Pilih jam meeting</option>
							<?php foreach($slots as $booking_slot): ?>
							<?php $slot_disabled = in_array($booking_slot, $booked_slots) || in_array($booking_slot, $elapsed_slots); ?>
							<option value="<?php echo $booking_slot; ?>" <?php if($slot_disabled) echo 'disabled'; ?>>
								<?php echo $booking_slot; ?> - <?php echo date('H:i', strtotime($booking_slot) + 3600); ?><?php if(in_array($booking_slot, $booked_slots)) echo ' (Sudah dipesan)'; elseif(in_array($booking_slot, $elapsed_slots)) echo ' (Waktu lewat)'; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda / Keperluan meeting" maxlength="100" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Ajukan Booking Ruangan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data peminjam dan jadwal meeting telah terisi dengan benar.</span>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function bukaFormBooking(jam) {
	var selectJam = document.getElementById('modal-jam-meeting');
	if (selectJam) {
		selectJam.value = jam;
	}
	$('#ajukanpinjam').modal({backdrop: 'static', keyboard: false});
	$('#ajukanpinjam').modal('show');
}
</script>
