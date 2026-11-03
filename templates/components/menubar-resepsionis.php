<!-- Menubar Resepsionis / Operator -->
<ul>
	<li <?php if($hal == "Beranda") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard'); ?>">Beranda</a>
	</li>
	<li <?php if($hal == "Ketersediaan Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>">Ketersediaan Ruangan</a>
	</li>
	<li <?php if($hal == "Data Peminjaman" OR $hal == "Laporan Peminjaman") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>">Data Peminjaman
			<span id="badge-notif-pengajuan" class="badge badge-pill badge-secondary notif-pengajuan-badge" style="display:none;"></span>
		</a>
	</li>
	<li <?php if($hal == "Riwayat Akses Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/akses-ruangan'); ?>">Riwayat Akses Ruang Meeting</a>
	</li>
</ul>