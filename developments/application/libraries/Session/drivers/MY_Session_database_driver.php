<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Driver sesi database khusus untuk deployment serverless (Vercel + TiDB Cloud).
 *
 * - Membuat tabel sesi otomatis jika belum ada, sehingga tidak perlu import manual.
 * - Menonaktifkan GET_LOCK() MySQL: setiap request di Vercel bisa berjalan di
 *   instance berbeda dan TiDB tidak selalu mendukung advisory lock, jadi lock
 *   cukup ditangani di level aplikasi (perilaku default CI_Session_driver).
 */
class MY_Session_database_driver extends CI_Session_database_driver {

	public function __construct(&$params)
	{
		parent::__construct($params);

		$table = $this->_config['save_path'];
		$this->_db->query(
			"CREATE TABLE IF NOT EXISTS `{$table}` (
				`id` varchar(128) NOT NULL,
				`ip_address` varchar(45) NOT NULL,
				`timestamp` int(10) unsigned NOT NULL DEFAULT 0,
				`data` blob NOT NULL,
				PRIMARY KEY (`id`),
				KEY `ci_sessions_timestamp` (`timestamp`)
			)"
		);
	}

	protected function _get_lock($session_id)
	{
		$this->_lock = TRUE;
		return TRUE;
	}

	protected function _release_lock()
	{
		$this->_lock = FALSE;
		return TRUE;
	}
}
