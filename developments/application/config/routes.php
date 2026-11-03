<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
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

