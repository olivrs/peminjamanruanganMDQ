<!-- Menubar Admin -->
<ul>
	<li <?php if($hal == "Beranda") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard'); ?>"><!-- <span class="lnr lnr-home"></span> -->Beranda</a>
	</li>
	<li <?php if($hal == "Kelola Akun Pengguna") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/akun-pengguna'); ?>"><!-- <span class="lnr lnr-user"></span> -->Akun Pengguna</a>
	</li>
	<li <?php if($hal == "Kelola Data Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-ruangan'); ?>"><!-- <span class="lnr lnr-database"></span> -->Data Ruang Meeting</a>
	</li>
	</li>
	<li <?php if($hal == "Ketersediaan Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>">Ketersediaan Ruangan</a>
	</li>
	<li <?php if($hal == "Data Peminjaman" OR $hal == "Laporan Peminjaman") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>"><!-- <span class="lnr lnr-layers"></span> -->Data Peminjaman
			<span id="pending-request-badge" class="badge badge-pill badge-secondary" <?php if(empty($jumlah_menunggu)) echo 'style="display:none"'; ?>><?php echo isset($jumlah_menunggu) ? $jumlah_menunggu : 0; ?></span>
		</a>
	</li>
	<li <?php if($hal == "Riwayat Akses Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/akses-ruangan'); ?>"><!-- <span class="lnr lnr-history"></span> -->Riwayat Akses Ruang Meeting</a>
	</li>
</ul>
<script>
(function () {
	var badge = document.getElementById('pending-request-badge');
	if (!badge) return;
	window.setInterval(function () {
		fetch('<?php echo base_url('dashboard/notifikasi-pengajuan'); ?>', {credentials: 'same-origin'})
			.then(function (response) { return response.json(); })
			.then(function (data) {
				badge.textContent = data.jumlah;
				badge.style.display = data.jumlah > 0 ? '' : 'none';
			});
	}, 30000);
})();
</script>