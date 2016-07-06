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
|	http://codeigniter.com/user_guide/general/routing.html
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

$route['default_controller'] = 'frontend_home/Home';

// hide only from View with numeric parameter
$route['view/(:num)'] = "view/index/$1";

//chuyen muc
$route['chuyen-muc/(:any)-(:num)/(:num)'] = 'frontend_home/Home/post_by_category/$2/$3';
$route['chuyen-muc/(:any)-(:num)'] = 'frontend_home/Home/post_by_category/$2';

//Do an tot nghiep
$route['do-an-tot-nghiep'] = 'frontend_home/Home/document';
$route['do-an-tot-nghiep/page/(:num)'] = 'frontend_home/Home/document/$1';
$route['do-an-tot-nghiep/(:any)-(:num)'] = 'frontend_home/Home/document_detail/$2';

//single
$route['bai-viet/(:any)-(:num)'] = 'frontend_home/Home/single/$2';

//page
$route['page/(:any)-(:num)'] = 'frontend_home/Home/page/$2';

//search
$route['search/(:num)?(:any)'] = 'frontend_home/Home/search/$2/$1';
$route['search?(:any)'] = 'frontend_home/Home/search/$1';

//user
$route['logout'] = 'backend_user/Authentication/logout';
$route['admin'] = 'backend_user/Authentication/login';

//Other
$route['lien-he'] = 'contact/Contact/sendMail';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
