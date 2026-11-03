<!-- Menubar Pengguna -->
<ul>
	<li <?php if($hal == "Beranda") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard'); ?>"><!-- <span class="lnr lnr-home"></span> -->Beranda</a>
	</li>
	</li>
	<li <?php if($hal == "Ketersediaan Ruangan") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>">Ketersediaan Ruangan</a>
	</li>
	<li <?php if($hal == "Data Peminjaman" OR $hal == "Laporan Peminjaman") echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>"><!-- <span class="lnr lnr-layers"></span> -->Data Peminjaman
		</a>
	</li>
</ul>