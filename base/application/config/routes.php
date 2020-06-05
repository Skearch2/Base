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
| class or method naoption to TRUE, it will replace ALL dashes in the
| controller and mme character, so it requires translation.
| When you set this ethod URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */

// Reserved
$route['default_controller'] = 'landing/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**********************************************  Skearch Frontend Routes  **********************************************/

/* Pages */
$route['home']                                   = 'frontend/pages';
$route['browse']                                 = 'frontend/pages/browse_all';
$route['browse/desc']                            = 'frontend/pages/browse_all/desc';
$route['browse/get_data/umbrella']               = 'frontend/pages/get_data/umbrella';
$route['browse/get_data/field']                  = 'frontend/pages/get_data/field';
$route['browse/(:any)']                          = 'frontend/pages/browse_umbrella/$1';
$route['browse/(:any)/(:any)']                   = 'frontend/pages/browse_field/$1/$2';
$route['browse/get_field_results/(:any)/(:any)'] = 'frontend/pages/get_field_results/$1/$2';

/* Search */
$route['search'] = 'frontend/search';

/* Theme */
$route['theme/change'] = 'frontend/pages/change_theme';


/**********************************************  My Skearch Routes  ***************************************************/

/* Authentication */
$route['myskearch/auth/login'] = 'my_skearch/auth/login';
$route['myskearch/auth/logout'] = 'my_skearch/auth/logout';
$route['myskearch/auth/signup'] = 'my_skearch/auth/signup';
$route['myskearch/auth/activate/(:num)/(:any)'] = 'my_skearch/auth/activate/$1/$2';
$route['myskearch/auth/change_password'] = 'my_skearch/auth/change_password';
$route['myskearch/auth/forgot_password'] = 'my_skearch/auth/forgot_password';
$route['myskearch/auth/reset_password/(:any)'] = 'my_skearch/auth/reset_password/$1';
$route['myskearch/auth/change_email'] = 'my_skearch/auth/change_email';

/* Dashboard */
$route['myskearch'] = 'my_skearch/dashboard';
$route['myskearch/dashboard'] = 'my_skearch/dashboard';
$route['myskearch/dashboard/history/clear'] = 'my_skearch/dashboard/delete_history';
$route['myskearch/dashboard/settings/update'] = 'my_skearch/dashboard/update_settings';

/* Digital assets */
$route['myskearch/digital_assets'] = 'my_skearch/digital_assets';

/* Private social */
$route['myskearch/private_social'] = 'my_skearch/private_social';

/* 
    Brand 
*/

// Ads
$route['myskearch/brand/ads'] = 'my_skearch/brand/ads';
$route['myskearch/brand'] = 'my_skearch/brand/ads/index';

// Keywords
$route['myskearch/brand/keywords'] = 'my_skearch/brand/keywords';
$route['myskearch/brand/keywords/add'] = 'my_skearch/brand/keywords/create';
$route['myskearch/brand/keywords/delete/id/(:num)'] = 'my_skearch/brand/keywords/delete/$1';
$route['myskearch/brand/keywords/get'] = 'my_skearch/brand/keywords/get';
$route['myskearch/brand/keywords/toggle/id/(:num)'] = 'my_skearch/brand/keywords/toggle/$1';

/* Profile */
$route['myskearch/profile'] = 'my_skearch/profile';
$route['myskearch/profile/(:num)'] = 'my_skearch/profile/index/$1';



/**********************************************  Admin Panel Routes  *************************************************/

/* 
    Authentication 
*/
$route['admin']                      = 'admin_panel/dashboard';
$route['admin/dashboard']            = 'admin_panel/dashboard';
$route['admin/auth/login']           = 'admin_panel/auth/login';
$route['admin/auth/logout']          = 'admin_panel/auth/logout';
$route['admin/auth/redirect/(:any)'] = 'admin_panel/auth/redirect/$1';
$route['admin/auth/submit']          = 'admin_panel/auth/submit';

/* 
    USERS 
*/

// Users
$route['admin/user/create/group/id/(:num)']         = 'admin_panel/users/users/create/$1';
$route['admin/user/delete/id/(:num)']               = 'admin_panel/users/users/delete/$1';
$route['admin/user/reset/id/(:num)']                = 'admin_panel/users/users/reset/$1';
$route['admin/user/toggle/id/(:num)']               = 'admin_panel/users/users/toggle/$1';
$route['admin/user/toggle/payment/user/id/(:num)']  = 'admin_panel/users/users/toggle_payment/$1';
$route['admin/user/update/id/(:num)']               = 'admin_panel/users/users/update/$1';
$route['admin/user/get/id/(:num)']                  = 'admin_panel/users/users/get/$1';
$route['admin/user/get/permissions/id/(:num)']      = 'admin_panel/users/users/permissions/$1';
$route['admin/users/get/group/id/(:num)']           = 'admin_panel/users/users/get/$1/1';
$route['admin/users/get/lastname/(:any)']           = 'admin_panel/users/users/get_by_lastname/$1';
$route['admin/users/group/id/(:num)']               = 'admin_panel/users/users/index/$1';

// Groups
$route['admin/users/group/create']             = 'admin_panel/users/groups/create';
$route['admin/users/group/delete/id/(:num)']   = 'admin_panel/users/groups/delete/$1';
$route['admin/users/group/update/id/(:num)']   = 'admin_panel/users/groups/update/$1';
$route['admin/users/groups']                   = 'admin_panel/users/groups';
$route['admin/users/groups/get']               = 'admin_panel/users/groups/get';

// Permissions
$route['admin/users/permission/create']           = 'admin_panel/users/permissions/create';
$route['admin/users/permission/delete/id/(:num)'] = 'admin_panel/users/permissions/delete/$1';
$route['admin/users/permission/update/id/(:num)'] = 'admin_panel/users/permissions/update/$1';
$route['admin/users/permissions']                 = 'admin_panel/users/permissions';
$route['admin/users/permissions/get']             = 'admin_panel/users/permissions/get';


/* 
    RESULTS
*/

// $route['admin/categories/category_list/(:any)'] = 'admin_panel/categories/category_list/$1';
// $route['admin/categories/get_category_list/(:any)'] = 'admin_panel/categories/get_category_list/$1';
// $route['admin/categories/subcategory_list'] = 'admin_panel/categories/subcategory_list';
// $route['admin/categories/subcategory_list/(:any)'] = 'admin_panel/categories/subcategory_list/$1';
// $route['admin/categories/subcategory_list/(:any)/(:any)'] = 'admin_panel/categories/subcategory_list/$1/$2';
// $route['admin/categories/get_subcategory_list'] = 'admin_panel/categories/get_subcategory_list';
// $route['admin/categories/get_subcategory_list/(:any)'] = 'admin_panel/categories/get_subcategory_list/$1';
// $route['admin/categories/get_subcategory_list/(:any)/(:any)'] = 'admin_panel/categories/get_subcategory_list/$1/$2';
// $route['admin/categories/result_list'] = 'admin_panel/categories/result_list';
// $route['admin/categories/result_list/(:any)'] = 'admin_panel/categories/result_list/$1';
// $route['admin/categories/result_list/(:any)/(:any)'] = 'admin_panel/categories/result_list/$1/$2';
// $route['admin/categories/get_result_list'] = 'admin_panel/categories/get_result_list';
// $route['admin/categories/get_result_list/(:any)'] = 'admin_panel/categories/get_result_list/$1';
// $route['admin/categories/get_result_list/(:any)/(:any)'] = 'admin_panel/categories/get_result_list/$1/$2';
// $route['admin/categories/delete_category/(:any)'] = 'admin_panel/categories/delete_category/$1';
// $route['admin/categories/delete_subcategory/(:any)'] = 'admin_panel/categories/delete_subcategory/$1';
// $route['admin/categories/delete_result_listing/(:any)'] = 'admin_panel/categories/delete_result_listing/$1';
// $route['admin/categories/create_category'] = 'admin_panel/categories/create_category';
// $route['admin/categories/create_subcategory'] = 'admin_panel/categories/create_subcategory';
// $route['admin/categories/create_result'] = 'admin_panel/categories/create_result';
// $route['admin/categories/update_category/(:any)'] = 'admin_panel/categories/update_category/$1';
// $route['admin/categories/update_subcategory/(:any)'] = 'admin_panel/categories/update_subcategory/$1';
// $route['admin/categories/update_result/(:any)'] = 'admin_panel/categories/update_result/$1';
// $route['admin/categories/toggle_category/(:any)'] = 'admin_panel/categories/toggle_category/$1';
// $route['admin/categories/toggle_subcategory/(:any)'] = 'admin_panel/categories/toggle_subcategory/$1';
// $route['admin/categories/toggle_result/(:any)'] = 'admin_panel/categories/toggle_result/$1';
// $route['admin/categories/toggle_redirect/(:any)'] = 'admin_panel/categories/toggle_redirect/$1';
// $route['admin/categories/change_priority/(:any)/(:any)'] = 'admin_panel/categories/change_priority/$1/$2';
// $route['admin/categories/get_links_priority/(:any)'] = 'admin_panel/categories/get_links_priority/$1';
// $route['admin/categories/search_adlink/(:any)'] = 'admin_panel/categories/search_adlink/$1';

// Umbrellas
$route['admin/results/umbrella/create']                                = 'admin_panel/results/umbrellas/create';
$route['admin/results/umbrella/delete/id/(:num)']                      = 'admin_panel/results/umbrellas/delete/$1';
$route['admin/results/umbrella/get/id/(:num)']                         = 'admin_panel/results/umbrellas/get/$1';
$route['admin/results/umbrella/toggle/id/(:num)']                      = 'admin_panel/results/umbrellas/toggle/$1';
$route['admin/results/umbrella/update/id/(:num)']                      = 'admin_panel/results/umbrellas/update/$1';
$route['admin/results/umbrellas/get/status/(all|active|inactive)']     = 'admin_panel/results/umbrellas/get_by_status/$1';
$route['admin/results/umbrellas/status/(all|active|inactive)']         = 'admin_panel/results/umbrellas/index/$1';

// Fields
$route['admin/results/field/create']                                = 'admin_panel/results/fields/create';
$route['admin/results/field/delete/id/(:num)']                      = 'admin_panel/results/fields/delete/$1';
$route['admin/results/field/get/id/(:num)']                         = 'admin_panel/results/fields/get/$1';
$route['admin/results/field/toggle/id/(:num)']                      = 'admin_panel/results/fields/toggle/$1';
$route['admin/results/field/update/id/(:num)']                      = 'admin_panel/results/fields/update/$1';
$route['admin/results/fields/get/status/(all|active|inactive)']     = 'admin_panel/results/fields/get_by_status/$1';
$route['admin/results/fields/get/umbrella/id/(:num)']               = 'admin_panel/results/fields/get_by_umbrella/$1';
$route['admin/results/fields/status/(all|active|inactive)']         = 'admin_panel/results/fields/index/$1';
$route['admin/results/fields/umbrella/id/(:num)']                   = 'admin_panel/results/fields/index/$1';

// Links
$route['admin/results/link/create']                                            = 'admin_panel/results/links/create';
$route['admin/results/link/delete/id/(:num)']                                  = 'admin_panel/results/links/delete/$1';
$route['admin/results/link/duplicate/id/(:num)/field/(:num)/priority/(:num)']  = 'admin_panel/results/links/duplicate/$1/$2/$3';
$route['admin/results/link/get/id/(:num)']                                     = 'admin_panel/results/links/get/$1';
$route['admin/results/link/move/id/(:num)/field/(:num)/priority/(:num)']       = 'admin_panel/results/links/move/$1/$2/$3';
$route['admin/results/link/redirect/id/(:num)']                                = 'admin_panel/results/links/redirect/$1';
$route['admin/results/link/toggle/id/(:num)']                                  = 'admin_panel/results/links/toggle/$1';
$route['admin/results/link/update/id/(:num)']                                  = 'admin_panel/results/links/update/$1';
$route['admin/results/link/update/id/(:num)/priority/(:num)']                  = 'admin_panel/results/links/update_priority/$1/$2';
$route['admin/results/links/get/field/id/(:num)']                              = 'admin_panel/results/links/get_by_field/$1';
$route['admin/results/links/get/keywords/(:any)']                              = 'admin_panel/results/links/get_by_keywords/$1';
$route['admin/results/links/get/status/(all|active|inactive)']                 = 'admin_panel/results/links/get_by_status/$1';
$route['admin/results/links/field/id/(:num)']                                  = 'admin_panel/results/links/index/$1';
$route['admin/results/links/priorities/field/id/(:num)']                       = 'admin_panel/results/links/priorities/$1';
$route['admin/results/links/search']                                           = 'admin_panel/results/links/index/search';
$route['admin/results/links/status/(all|active|inactive)']                     = 'admin_panel/results/links/index/$1';

// Frontend
$route['admin/results/frontend/homepage']                = 'admin_panel/results/frontend/homepage';
$route['admin/results/frontend/fields']                  = 'admin_panel/results/frontend/field_suggestions';
$route['admin/results/frontend/umbrellas']               = 'admin_panel/results/frontend/umbrella_suggestions';
$route['admin/results/frontend/fields/get/id/(:num)']    = 'admin_panel/results/frontend/get_field_suggestions/$1';
$route['admin/results/frontend/umbrellas/get/id/(:num)'] = 'admin_panel/results/frontend/get_umbrella_suggestions/$1';

// Research
$route['admin/results/research/add']              = 'admin_panel/results/research/create';
$route['admin/results/research/delete/(:num)']    = 'admin_panel/results/research/delete/$1';
$route['admin/results/research/get']              = 'admin_panel/results/research/get';
$route['admin/results/research/get/(:num)']       = 'admin_panel/results/research/get/$1';
$route['admin/results/research/list']             = 'admin_panel/results/research';
$route['admin/results/research/make_link/(:num)'] = 'admin_panel/results/research/make_link/$1';

/* 
    BRANDS 
*/

// Leads
$route['admin/brands/leads']               = 'admin_panel/brands/leads';
$route['admin/brands/leads/get']           = 'admin_panel/brands/leads/get';
$route['admin/brands/leads/delete/(:num)'] = 'admin_panel/brands/leads/delete/$1';

// Brands
$route['admin/brand/create']                    = 'admin_panel/brands/brands/create';
$route['admin/brand/delete/id/(:num)']          = 'admin_panel/brands/brands/delete/$1';
$route['admin/brand/update/id/(:num)']          = 'admin_panel/brands/brands/update/$1';
$route['admin/brands']                          = 'admin_panel/brands/brands';
$route['admin/brands/get']                      = 'admin_panel/brands/brands/get';
$route['admin/brands/search/(:any)']            = 'admin_panel/brands/brands/search/$1';

// Keywords
$route['admin/brands/keywords']                         = 'admin_panel/brands/keywords';
$route['admin/brands/keywords/delete/id/(:num)']           = 'admin_panel/brands/keywords/delete/$1';
$route['admin/brands/keywords/approve/id/(:num)']       = 'admin_panel/brands/keywords/approve/$1';
$route['admin/brands/keywords/get']                     = 'admin_panel/brands/keywords/get';
$route['admin/brands/keywords/toggle/id/(:num)']        = 'admin_panel/brands/keywords/toggle/$1';



/* Link Checker */
$route['admin/linkchecker'] = 'admin_panel/linkchecker';
$route['admin/linkchecker/get'] = 'admin_panel/linkchecker/get';
$route['admin/linkchecker/get_status_info'] = 'admin_panel/option/get_status_info';
$route['admin/linkchecker/remove/id/(:num)'] = 'admin_panel/linkchecker/remove/$1';
$route['admin/linkchecker/update_urls_status'] = 'admin_panel/linkchecker/update_urls_status';

/* Email */
$route['admin/email/members'] = 'admin_panel/email/members';
$route['admin/email/invite'] = 'admin_panel/email/invite';
$route['admin/email/send_email'] = 'admin_panel/email/send_email';
$route['admin/email/templates/(:any)'] = 'admin_panel/templates/get/$1';

/* Option Routes */
$route['admin/option'] = 'admin_panel/option';
$route['admin/option/update_option'] = 'admin_panel/option/update_option';
$route['admin/option/brandlinks_status_all'] = 'admin_panel/option/brandlinks_status_all';



/**********************************************  Media Server API Routes *************************************************/
$route['media/api/stats/brand/id/(:num)']      = 'frontend/media/get_brand_ads_stats/$1';
$route['redirect/link/id/(:num)']    = 'frontend/media/media_redirect/$1';
$route['impression/image/id/(:num)'] = 'frontend/media/update_image_impression/$1';
