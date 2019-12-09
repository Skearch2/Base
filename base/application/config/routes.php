<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */

// Reserved
$route['default_controller'] = 'pages/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/*
Skearch static pages Routes
 */
$route['brands'] = 'pages/static/brands';


/*
Skearch Categories Routes
 */
$route['browse'] = 'pages/browse_all';
$route['browse/desc'] = 'pages/browse_all/desc';
$route['browse/get_data/umbrella'] = 'pages/get_data/umbrella';
$route['browse/get_data/field'] = 'pages/get_data/field';
$route['browse/(:any)'] = 'pages/browse_umbrella/$1';
$route['browse/(:any)/(:any)'] = 'pages/browse_field/$1/$2';
$route['browse/get_field_results/(:any)/(:any)'] = 'pages/get_field_results/$1/$2';



/*
Search Routes
 */
$route['search'] = 'search';

/*
My Skearch Routes
 */

/* Authentication Routes */
$route['myskearch/auth/login'] = 'my_skearch/auth/login';
$route['myskearch/auth/logout'] = 'my_skearch/auth/logout';
$route['myskearch/auth/signup'] = 'my_skearch/auth/signup';
$route['myskearch/auth/activate/(:num)/(:any)'] = 'my_skearch/auth/activate/$1/$2';
$route['myskearch/auth/change_password'] = 'my_skearch/auth/change_password';
$route['myskearch/auth/forgot_password'] = 'my_skearch/auth/forgot_password';
$route['myskearch/auth/reset_password/(:any)'] = 'my_skearch/auth/reset_password/$1';
$route['myskearch/auth/change_email'] = 'my_skearch/auth/change_email';

/* User panel Routes */
$route['myskearch'] = 'my_skearch/dashboard';
$route['myskearch/dashboard'] = 'my_skearch/dashboard';
$route['myskearch/profile'] = 'my_skearch/profile';
$route['myskearch/profile/(:num)'] = 'my_skearch/profile/index/$1';

/* Digital assets Routes */
$route['myskearch/digital_assets'] = 'my_skearch/digital_assets';

/* Private social Routes */
$route['myskearch/private_social'] = 'my_skearch/private_social';

/* Brand direct Routes */
$route['myskearch/brand_direct'] = 'my_skearch/brand_direct';

/*
Admin Panel Routes
 */

/* Authentication Routes */
$route['admin'] = 'admin_panel/dashboard';
$route['admin/dashboard'] = 'admin_panel/dashboard';
$route['admin/auth/login'] = 'admin_panel/auth/login';
$route['admin/auth/logout'] = 'admin_panel/auth/logout';
$route['admin/auth/redirect/(:any)'] = 'admin_panel/auth/redirect/$1';
$route['admin/auth/submit'] = 'admin_panel/auth/submit';

/* Link Checker route */
$route['admin/linkchecker'] = 'admin_panel/linkchecker';
$route['admin/linkchecker/update_urls_status'] = 'admin_panel/linkchecker/update_urls_status';
$route['admin/linkchecker/get_bad_urls'] = 'admin_panel/linkchecker/get_bad_urls';

/* User list Routes */
$route['admin/users/user_list'] = 'admin_panel/users/user_list';
$route['admin/users/get_user_list'] = 'admin_panel/users/get_user_list';
$route['admin/users/get_users_by_lastname/(:any)'] = 'admin_panel/users/get_users_by_lastname/$1';
$route['admin/users/create_user'] = 'admin_panel/users/create_user';
$route['admin/users/edit_user/(:num)'] = 'admin_panel/users/edit_user/$1';
$route['admin/users/delete_user/(:num)'] = 'admin_panel/users/delete_user/$1';
$route['admin/users/reset_user_password/(:num)'] = 'admin_panel/users/reset_user_password/$1';
$route['admin/users/toggle_user_activation/(:num)'] = 'admin_panel/users/toggle_user_activation/$1';

/* User groups Routes */
$route['admin/users/create_user_group'] = 'admin_panel/users/create_user_group';
$route['admin/users/delete_user_group/(:num)'] = 'admin_panel/users/delete_user_group/$1';
$route['admin/users/edit_user_group/(:num)'] = 'admin_panel/users/edit_user_group/$1';
$route['admin/users/get_user_groups'] = 'admin_panel/users/get_user_groups';
$route['admin/users/user_groups'] = 'admin_panel/users/user_groups';

/* Categories Routes */
$route['admin/categories/category_list/(:any)'] = 'admin_panel/categories/category_list/$1';
$route['admin/categories/get_category_list/(:any)'] = 'admin_panel/categories/get_category_list/$1';
$route['admin/categories/subcategory_list'] = 'admin_panel/categories/subcategory_list';
$route['admin/categories/subcategory_list/(:any)'] = 'admin_panel/categories/subcategory_list/$1';
$route['admin/categories/subcategory_list/(:any)/(:any)'] = 'admin_panel/categories/subcategory_list/$1/$2';
$route['admin/categories/get_subcategory_list'] = 'admin_panel/categories/get_subcategory_list';
$route['admin/categories/get_subcategory_list/(:any)'] = 'admin_panel/categories/get_subcategory_list/$1';
$route['admin/categories/get_subcategory_list/(:any)/(:any)'] = 'admin_panel/categories/get_subcategory_list/$1/$2';
$route['admin/categories/result_list'] = 'admin_panel/categories/result_list';
$route['admin/categories/result_list/(:any)'] = 'admin_panel/categories/result_list/$1';
$route['admin/categories/result_list/(:any)/(:any)'] = 'admin_panel/categories/result_list/$1/$2';
$route['admin/categories/get_result_list'] = 'admin_panel/categories/get_result_list';
$route['admin/categories/get_result_list/(:any)'] = 'admin_panel/categories/get_result_list/$1';
$route['admin/categories/get_result_list/(:any)/(:any)'] = 'admin_panel/categories/get_result_list/$1/$2';
$route['admin/categories/delete_category/(:any)'] = 'admin_panel/categories/delete_category/$1';
$route['admin/categories/delete_subcategory/(:any)'] = 'admin_panel/categories/delete_subcategory/$1';
$route['admin/categories/delete_result_listing/(:any)'] = 'admin_panel/categories/delete_result_listing/$1';
$route['admin/categories/create_category'] = 'admin_panel/categories/create_category';
$route['admin/categories/create_subcategory'] = 'admin_panel/categories/create_subcategory';
$route['admin/categories/create_result'] = 'admin_panel/categories/create_result';
$route['admin/categories/update_category/(:any)'] = 'admin_panel/categories/update_category/$1';
$route['admin/categories/update_subcategory/(:any)'] = 'admin_panel/categories/update_subcategory/$1';
$route['admin/categories/update_result/(:any)'] = 'admin_panel/categories/update_result/$1';
$route['admin/categories/toggle_category/(:any)'] = 'admin_panel/categories/toggle_category/$1';
$route['admin/categories/toggle_subcategory/(:any)'] = 'admin_panel/categories/toggle_subcategory/$1';
$route['admin/categories/toggle_result/(:any)'] = 'admin_panel/categories/toggle_result/$1';
$route['admin/categories/toggle_redirect/(:any)'] = 'admin_panel/categories/toggle_redirect/$1';
$route['admin/categories/change_priority/(:any)/(:any)'] = 'admin_panel/categories/change_priority/$1/$2';
$route['admin/categories/get_links_priority/(:any)'] = 'admin_panel/categories/get_links_priority/$1';
$route['admin/categories/search_adlink/(:any)'] = 'admin_panel/categories/search_adlink/$1';

/* Homepage Routes */
$route['admin/frontend/homepage'] = 'admin_panel/frontend/homepage';
$route['admin/frontend/field_suggestions'] = 'admin_panel/frontend/field_suggestions';
$route['admin/frontend/umbrella_suggestions'] = 'admin_panel/frontend/umbrella_suggestions';

// Api Link
$route['admin/frontend/get_field_suggestions/(:any)'] = 'admin_panel/frontend/get_field_suggestions/$1';
$route['admin/frontend/get_umbrella_suggestions/(:any)'] = 'admin_panel/frontend/get_umbrella_suggestions/$1';


/* Email Routes */
$route['admin/email/members'] = 'admin_panel/email/members';
$route['admin/email/invite'] = 'admin_panel/email/invite';
$route['admin/email/send_email'] = 'admin_panel/email/send_email';

/* Email Templates Routes */
$route['admin/email/templates/(:any)'] = 'admin_panel/templates/get/$1';

/* Option Routes */
$route['admin/option'] = 'admin_panel/option';
$route['admin/option/update_option'] = 'admin_panel/option/update_option';
$route['admin/option/brandlinks_status_all'] = 'admin_panel/option/brandlinks_status_all';

/*
CSS Routes
 */
$route['setchange'] = 'setchange';

// test datatables
$route['datatable/show'] = 'datatable_test/show';
$route['datatable/get'] = 'datatable_test/get';

/*
Media Engine Api
 */
$route['redirect/link/id/(:num)'] = 'media/media_redirect/$1';
$route['impression/image/id/(:num)'] = 'media/update_image_impression/$1';
