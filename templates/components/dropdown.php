<!-- Area Pengguna / Akses Petugas (Superadmin & Resepsionis) -->
<?php if ($this->session->userdata('status-masuk') == 'masuk' && in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
<?php 
	$nama = $this->session->userdata('namalengkap');
	// Hapus duplikasi kurung role jika namalengkap di database sudah mengandung (Superadmin)/(Admin)/(Resepsionis)
	$nama = trim(preg_replace('/\s*\((?:Superadmin|Admin|Resepsionis)\)\s*/i', '', $nama));
	$role = $this->session->userdata('level') == 'Admin' ? 'Superadmin' : 'Resepsionis';
?>
<div class="dropdown">
	<a class="dropdown-info" id="dropdown-info" data-toggle="dropdown" style="cursor:pointer;" title="<?php echo htmlspecialchars($nama) . ' (' . $role . ')'; ?>">
		<i class="fas fa-user-shield" style="color:#0059fb; margin-right:5px;"></i>
		<span><?php echo htmlspecialchars($nama); ?></span>
		<small style="color:#0059fb; font-weight:700; margin-left:4px;">(<?php echo $role; ?>)</small>
		<span class="lnr lnr-chevron-down" style="margin-left:4px;"></span>
	</a>
	
	<div class="dropdown-menu info-content dropdown-menu-right" aria-labelledby="dropdown-info">
		<a class="dropdown-item" href="<?php echo base_url('dashboard/panduan'); ?>">
			<span class="lnr lnr-book"></span>&nbsp;&nbsp;Buku Panduan
		</a>
		<a class="dropdown-item" href="<?php echo base_url('dashboard/logout'); ?>">
			<span class="lnr lnr-power-switch"></span>&nbsp;&nbsp;Keluar
		</a>
	</div>
</div>
<?php else: ?>
<div style="display:flex; align-items:center; gap:8px;">
	<a href="<?php echo base_url('dashboard/panduan'); ?>" class="dropdown-info" style="text-decoration:none;" title="Buku Panduan Penggunaan">
		<i class="fas fa-book-open" style="color:#0059fb;"></i> <span>Panduan</span>
	</a>
	<a href="<?php echo base_url('login'); ?>" class="dropdown-info" style="background:#0059fb; color:#ffffff !important; border-color:#0059fb; text-decoration:none;" title="Login">
		<i class="fas fa-user-lock" style="color:#ffffff;"></i> <span style="color:#ffffff;">Login</span>
	</a>
</div>
<?php endif; ?>
