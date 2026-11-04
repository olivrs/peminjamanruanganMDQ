<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'dashboard';
$route['login'] = 'login';
$route['login/proses'] = 'login/proses';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Rute Verifikasi Check-In Ruangan & QR Code
$route['dashboard/checkin-ruangan'] = 'dashboard/checkin_ruangan';
$route['dashboard/scan-qr/(:any)']  = 'dashboard/scan_qr/$1';
$route['dashboard/qr-ruangan/(:any)'] = 'dashboard/qr_ruangan/$1';
$route['dashboard/proses-checkin/(:any)'] = 'dashboard/proses_checkin/$1';

// Rute Integrasi Kalender & Ekspor Laporan
$route['dashboard/kalender-google/(:any)'] = 'dashboard/kalender_google/$1';
$route['dashboard/kalender-ics/(:any)']    = 'dashboard/kalender_ics/$1';
$route['dashboard/ekspor-excel']          = 'dashboard/ekspor_excel';
$route['dashboard/cetak-laporan']         = 'dashboard/cetak_laporan';
$route['dashboard/panduan'] = 'dashboard/panduan';
$route['dashboard/status-ruangan-realtime'] = 'dashboard/status_ruangan_realtime';
