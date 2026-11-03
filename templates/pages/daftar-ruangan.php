<table>
	<tr>
		<th>No.</th>
		<th>Ruang Meeting</th>
		<th>Kapasitas</th>
	</tr>

	<?php if(empty($tb)): ?>
	<tr>
		<td align="center" colspan="3">Belum ada ruang meeting terdaftar.</td>
	</tr>
	<?php endif; ?>

	<?php $no = 1; foreach ($tb as $baris): ?>
	<tr>
		<td align="center"><?php echo $no; ?></td>
		<td><?php echo $baris['nama_ruangan']; ?></td>
		<td align="center"><?php echo isset($baris['kapasitas']) ? $baris['kapasitas'] . ' orang' : 'Belum diatur'; ?></td>
	</tr>
	<?php $no++; endforeach; ?>
</table>
