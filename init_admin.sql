USE `db_pinjamkelas`;

INSERT INTO `tb_user` (`username`, `fullname`, `password`, `level`)
VALUES 
('admin', 'Administrator', '$2y$10$jtmpCMJNdepL9kKGz4pZAO3x45IcMC4zdYPtLXTIWCkOe9VWb0Fzi', 'Admin')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `level` = VALUES(`level`);
