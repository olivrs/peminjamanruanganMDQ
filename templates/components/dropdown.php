<!-- Area Pengguna / Akses Petugas (Superadmin & Resepsionis) -->
<?php if ($this->session->userdata('status-masuk') == 'masuk' && in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
<div>
	<a class="dropdown-info" id="dropdown-info" data-toggle="dropdown" style="cursor:pointer;">
		<i class="fas fa-user-shield" style="color:#0059fb; margin-right:5px;"></i>
		<?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?>
		<small style="color:#0059fb; font-weight:700;">(<?php echo $this->session->userdata('level') == 'Admin' ? 'Superadmin' : 'Resepsionis'; ?>)</small>
		<span class="lnr lnr-chevron-down"></span>
	</a>
	
	<div class="dropdown-menu info-content" aria-labelledby="dropdown-info">
		<a class="" href="<?php echo base_url('dashboard/panduan'); ?>">
			<span class="lnr lnr-book"></span>&nbsp;&nbsp;Buku Panduan
		</a>
		<a class="" href="<?php echo base_url('dashboard/logout'); ?>">
			<span class="lnr lnr-power-switch"></span>&nbsp;&nbsp;Keluar
		</a>
	</div>
</div>
<?php else: ?>
<div style="display:flex; align-items:center; gap:8px;">
	<a href="<?php echo base_url('dashboard/panduan'); ?>" class="dropdown-info" style="text-decoration:none;" title="Buku Panduan Penggunaan">
		<i class="fas fa-book-open" style="color:#0059fb;"></i> <span>Panduan</span>
	</a>
	<a href="<?php echo base_url('login'); ?>" class="dropdown-info" style="background:#0059fb; color:#ffffff; border-color:#0059fb; text-decoration:none;" title="Login">
		<i class="fas fa-user-lock"></i> <span>Login</span>
	</a>
</div>
<?php endif; ?>
