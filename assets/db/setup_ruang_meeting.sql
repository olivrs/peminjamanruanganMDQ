USE `db_pinjamkelas`;

ALTER TABLE `tb_user` MODIFY `password` varchar(255) NOT NULL;

SET @has_capacity = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_ruangan' AND COLUMN_NAME = 'kapasitas');
SET @capacity_sql = IF(@has_capacity = 0, 'ALTER TABLE `tb_ruangan` ADD COLUMN `kapasitas` int(10) unsigned NOT NULL DEFAULT 10', 'SELECT 1');
PREPARE capacity_statement FROM @capacity_sql;
EXECUTE capacity_statement;
DEALLOCATE PREPARE capacity_statement;

SET @has_meeting_date = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_peminjaman' AND COLUMN_NAME = 'tanggal_meeting');
SET @date_sql = IF(@has_meeting_date = 0, 'ALTER TABLE `tb_peminjaman` ADD COLUMN `tanggal_meeting` date NULL DEFAULT NULL', 'SELECT 1');
PREPARE date_statement FROM @date_sql;
EXECUTE date_statement;
DEALLOCATE PREPARE date_statement;

SET @has_meeting_time = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_peminjaman' AND COLUMN_NAME = 'jam_meeting');
SET @time_sql = IF(@has_meeting_time = 0, 'ALTER TABLE `tb_peminjaman` ADD COLUMN `jam_meeting` time NULL DEFAULT NULL', 'SELECT 1');
PREPARE time_statement FROM @time_sql;
EXECUTE time_statement;
DEALLOCATE PREPARE time_statement;

UPDATE `tb_ruangan` SET `nama_ruangan` = 'Focus Room', `kapasitas` = 8 WHERE `id_ruangan` = 'R001';
UPDATE `tb_ruangan` SET `nama_ruangan` = 'Huddle Room', `kapasitas` = 12 WHERE `id_ruangan` = 'R002';
UPDATE `tb_peminjaman` SET `ruangan_dipinjam` = 'Focus Room' WHERE `ruangan_dipinjam` = 'Kelas-01';
UPDATE `tb_peminjaman` SET `ruangan_dipinjam` = 'Huddle Room' WHERE `ruangan_dipinjam` = 'Kelas-02';
UPDATE `tb_tap` SET `nama_ruangan` = 'Focus Room' WHERE `nama_ruangan` IN ('Kelas-01', 'Ruang Kelas-01');
UPDATE `tb_tap` SET `nama_ruangan` = 'Huddle Room' WHERE `nama_ruangan` IN ('Kelas-02', 'Ruang Kelas-02');

INSERT IGNORE INTO `tb_ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas`, `status`) VALUES
('R003', 'Board Room', 20, 'Tersedia'),
('R004', 'Conference', 30, 'Tersedia'),
('R005', 'Townhall', 50, 'Tersedia');

-- Data tambahan peminjam (nama, departemen, nomor telepon)
SET @c1 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_peminjaman' AND COLUMN_NAME = 'nama_peminjam');
SET @s1 = IF(@c1 = 0, 'ALTER TABLE `tb_peminjaman` ADD COLUMN `nama_peminjam` varchar(50) NULL DEFAULT NULL', 'SELECT 1');
PREPARE st1 FROM @s1; EXECUTE st1; DEALLOCATE PREPARE st1;

SET @c2 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_peminjaman' AND COLUMN_NAME = 'departemen_peminjam');
SET @s2 = IF(@c2 = 0, 'ALTER TABLE `tb_peminjaman` ADD COLUMN `departemen_peminjam` varchar(50) NULL DEFAULT NULL', 'SELECT 1');
PREPARE st2 FROM @s2; EXECUTE st2; DEALLOCATE PREPARE st2;

SET @c3 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_peminjaman' AND COLUMN_NAME = 'telepon_peminjam');
SET @s3 = IF(@c3 = 0, 'ALTER TABLE `tb_peminjaman` ADD COLUMN `telepon_peminjam` varchar(20) NULL DEFAULT NULL', 'SELECT 1');
PREPARE st3 FROM @s3; EXECUTE st3; DEALLOCATE PREPARE st3;