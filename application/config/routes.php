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
$route['default_controller'] = 'Admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['get_data/(:any)'] = 'Admin/get_data/$1';
$route['calc_lead_time'] = 'Admin/calc_lead_time';
$route['leadtime'] = 'Admin/leadtime';
$route['simpan_leadtime'] = 'Admin/simpan_leadtime';
$route['set_wh'] = 'Admin/set_wh';
$route['simpan_set_wh'] = 'Admin/simpan_set_wh';
$route['clear_ot'] = 'Admin/clear_ot';
$route['summary_otd'] = 'Admin/summary_otd';
$route['graph_andon'] = 'Admin/graph_andon';
$route['set_adjust_otd'] = 'Admin/set_adjust_otd';
$route['auto_sync'] = 'Admin/auto_sync';
$route['list_unit/(:any)/(:any)'] = 'Admin/list_unit/$1/$2';
$route['live_andon'] = 'Admin/live_andon';
$route['getDataAndon'] = 'Admin/getDataAndon';
$route['printDataAndon'] = 'Admin/printDataAndon';
$route['print_otd'] = 'Admin/print_otd';
$route['re_calculate'] = 'Admin/re_calculate';
$route['tracking_time'] = 'Admin/tracking_time';
$route['summary_otd_excel'] = 'Admin/summary_otd_excel';
$route['tracking_unit'] = 'Admin/tracking_unit';

$route['updateOTFromTracking'] = 'GetAndon/updateOTFromTracking';
$route['auto_sync_ot'] = 'GetAndon/auto_sync_ot';