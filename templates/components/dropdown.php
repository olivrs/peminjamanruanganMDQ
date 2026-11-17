<!-- Area Pengguna / Akses Petugas (Superadmin & Resepsionis) -->
<?php if ($this->session->userdata('status-masuk') == 'masuk' && in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
<?php 
	$nama = $this->session->userdata('namalengkap');
	$nama = trim(preg_replace('/\s*\((?:Superadmin|Admin|Resepsionis)\)\s*/i', '', $nama));
	$role = $this->session->userdata('level') == 'Admin' ? 'Superadmin' : 'Resepsionis';
?>
<div class="dropdown">
	<a class="dropdown-info ws-user-pill" id="dropdown-info" data-toggle="dropdown" style="cursor:pointer;" title="<?php echo htmlspecialchars($nama) . ' (' . $role . ')'; ?>">
		<i class="fas fa-user-shield" style="color:#5eead4;"></i>
		<span><?php echo htmlspecialchars($nama); ?></span>
		<small class="ws-role-tag"><?php echo $role; ?></small>
		<span class="lnr lnr-chevron-down" style="margin-left:2px; font-size:11px;"></span>
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
<div class="ws-header-btns">
	<a href="<?php echo base_url('dashboard/panduan'); ?>" class="dropdown-info ws-btn-ghost" style="text-decoration:none;" title="Buku Panduan Penggunaan">
		<i class="fas fa-book-open"></i> <span>Panduan</span>
	</a>
	<a href="<?php echo base_url('login'); ?>" class="dropdown-info ws-btn-login" style="text-decoration:none;" title="Login Petugas">
		<i class="fas fa-sign-in-alt"></i> <span>Login</span>
	</a>
</div>
<?php endif; ?>
