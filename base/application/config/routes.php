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

// CSRF
$route['auth/get/csrf_hash']                          = 'auth/get_csrf_hash';

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

/* Ads */
$route['redirect/ad/id/(:num)']                  = 'frontend/ads/redirect/$1';
$route['update/impression/ad/id/(:num)']         = 'frontend/ads/update_impression/$1';

/* Search */
$route['search'] = 'frontend/search';

/* Theme */
$route['theme/change'] = 'frontend/pages/change_theme';



/**********************************************  My Skearch Routes  ***************************************************/

/* Authentication */
$route['signup']                                    = 'my_skearch/auth/signup';
$route['myskearch/auth/login']                      = 'my_skearch/auth/login';
$route['myskearch/auth/logout']                     = 'my_skearch/auth/logout';
$route['myskearch/auth/signup']                     = 'my_skearch/auth/signup';
$route['myskearch/auth/activate/id/(:num)/code/(:any)']                  = 'my_skearch/auth/activate/$1/$2';
$route['myskearch/auth/activate/action/delegate/id/(:num)/code/(:any)']  = 'my_skearch/auth/set_password_activate/$1/$2';
$route['myskearch/auth/search/brand/(:any)']        = 'my_skearch/auth/brand_search/$1';
$route['myskearch/auth/change_password']            = 'my_skearch/auth/change_password';
$route['myskearch/auth/forgot_password']            = 'my_skearch/auth/forgot_password';
$route['myskearch/auth/captcha/generate']           = 'my_skearch/auth/generate_captcha';
$route['myskearch/auth/reset_password/(:any)']      = 'my_skearch/auth/reset_password/$1';
$route['myskearch/auth/change_email']               = 'my_skearch/auth/change_email';
$route['myskearch/auth/payment']                    = 'my_skearch/auth/payment';
$route['myskearch/auth/payment/transaction/done']   = 'my_skearch/auth/payment/1';

/* Dashboard */
$route['myskearch']                             = 'my_skearch/dashboard';
$route['myskearch/dashboard']                   = 'my_skearch/dashboard';
$route['myskearch/dashboard/history/clear']     = 'my_skearch/dashboard/delete_history';
$route['myskearch/dashboard/settings/update']   = 'my_skearch/dashboard/update_settings';

/* Digital assets */
$route['myskearch/digital_assets']              = 'my_skearch/digital_assets';
$route['myskearch/participate/giveaway/(:num)'] = 'my_skearch/digital_assets/participate_in_giveaway/$1';


/* Private social */
$route['myskearch/private_social']                      = 'my_skearch/private_social';
$route['myskearch/private_social/get/chats']            = 'my_skearch/private_social/chats';
$route['myskearch/private_social/get/conversation']     = 'my_skearch/private_social/conversation';
$route['myskearch/private_social/get/notifications']    = 'my_skearch/private_social/notifications';
$route['myskearch/private_social/get/requests']         = 'my_skearch/private_social/requests';
$route['myskearch/private_social/message']              = 'my_skearch/private_social/message';
$route['myskearch/private_social/ping']                 = 'my_skearch/private_social/ping';
$route['myskearch/private_social/request']              = 'my_skearch/private_social/request';
$route['myskearch/private_social/search']               = 'my_skearch/private_social/users';


/* 
    Brand 
*/

// Ads
$route['myskearch/brand']                  = 'my_skearch/brand/ads/index';
$route['myskearch/brand/ads']              = 'my_skearch/brand/ads';
$route['myskearch/brand/ads/action/get']   = 'my_skearch/brand/ads/get';

// Brandlinks
$route['myskearch/brand/brandlinks']                    = 'my_skearch/brand/brandlinks';
$route['myskearch/brand/brandlinks/add']                  = 'my_skearch/brand/brandlinks/create';
$route['myskearch/brand/brandlinks/delete/id/(:num)']     = 'my_skearch/brand/brandlinks/delete/$1';
$route['myskearch/brand/brandlinks/get']                = 'my_skearch/brand/brandlinks/get';
$route['myskearch/brand/brandlinks/toggle/id/(:num)']     = 'my_skearch/brand/brandlinks/toggle/$1';
$route['myskearch/brand/brandlinks/get/id/(:num)']         = 'my_skearch/brand/brandlinks/get_by_id/$1';
$route['myskearch/brand/brandlinks/update/id/(:num)']      = 'my_skearch/brand/brandlinks/update/$1';

// Media Vault
$route['myskearch/brand/vault']                          = 'my_skearch/brand/media_vault';
$route['myskearch/brand/vault/get']                      = 'my_skearch/brand/media_vault/get';
$route['myskearch/brand/vault/add/media']                = 'my_skearch/brand/media_vault/create';
$route['myskearch/brand/vault/edit/media/id/(:num)']     = 'my_skearch/brand/media_vault/update/$1';
$route['myskearch/brand/vault/delete/media/id/(:num)']   = 'my_skearch/brand/media_vault/delete/$1';

/* Profile */
$route['myskearch/profile']             = 'my_skearch/profile';
$route['myskearch/profile/(:num)']      = 'my_skearch/profile/index/$1';



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
    Staff Messaging 
*/
$route['admin/messaging/get/staff']            = 'admin_panel/staff_messaging/staff';
$route['admin/messaging/get/conversation']     = 'admin_panel/staff_messaging/conversation';
$route['admin/messaging/get/notifications']    = 'admin_panel/staff_messaging/notifications';
$route['admin/messaging/message']              = 'admin_panel/staff_messaging/message';
$route['admin/messaging/ping']                 = 'admin_panel/staff_messaging/ping';

/* 
    USERS 
*/

// Users
$route['admin/user/activate/id/(:num)']             = 'admin_panel/users/users/activate/$1';
$route['admin/user/create/group/id/(:num)']         = 'admin_panel/users/users/create/$1';
$route['admin/user/delete/id/(:num)']               = 'admin_panel/users/users/delete/$1';
$route['admin/user/reset/id/(:num)']                = 'admin_panel/users/users/reset/$1';
$route['admin/user/toggle/id/(:num)']               = 'admin_panel/users/users/toggle/$1';
$route['admin/user/toggle/payment/user/id/(:num)']  = 'admin_panel/users/users/toggle_payment/$1';
$route['admin/user/update/id/(:num)']               = 'admin_panel/users/users/update/$1';
$route['admin/user/upgrade/id/(:num)']              = 'admin_panel/users/users/upgrade/$1';
$route['admin/user/get/id/(:num)']                  = 'admin_panel/users/users/get/$1';
$route['admin/user/get/permissions/id/(:num)']      = 'admin_panel/users/users/permissions/$1';
$route['admin/users/get/group/id/(:num)']           = 'admin_panel/users/users/get/$1/1';
$route['admin/users/get/lastname/(:any)']           = 'admin_panel/users/users/get_by_lastname/$1';
$route['admin/users/group/id/(:num)']               = 'admin_panel/users/users/index/$1';

// Groups
// $route['admin/users/group/create']             = 'admin_panel/users/groups/create';
// $route['admin/users/group/delete/id/(:num)']   = 'admin_panel/users/groups/delete/$1';
$route['admin/users/group/update/id/(:num)']   = 'admin_panel/users/groups/update/$1';
$route['admin/users/groups']                   = 'admin_panel/users/groups';
$route['admin/users/groups/get']               = 'admin_panel/users/groups/get';

// Permissions
$route['admin/permission/create']           = 'admin_panel/permissions/create';
$route['admin/permission/delete/id/(:num)'] = 'admin_panel/permissions/delete/$1';
$route['admin/permission/update/id/(:num)'] = 'admin_panel/permissions/update/$1';
$route['admin/permissions']                 = 'admin_panel/permissions';
$route['admin/permissions/get']             = 'admin_panel/permissions/get';

/* 
    RESULTS
*/

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
$route['admin/results/links/get/branddirect/status/(active|inactive)']         = 'admin_panel/results/links/get_by_branddirect_status/$1';
$route['admin/results/links/get/field/id/(:num)']                              = 'admin_panel/results/links/get_by_field/$1';
$route['admin/results/links/get/keywords/(:any)']                              = 'admin_panel/results/links/get_by_keywords/$1';
$route['admin/results/links/get/status/(all|active|inactive)']                 = 'admin_panel/results/links/get_by_status/$1';
$route['admin/results/links/field/id/(:num)']                                  = 'admin_panel/results/links/index/$1';
$route['admin/results/links/priorities/field/id/(:num)']                       = 'admin_panel/results/links/priorities/$1';
$route['admin/results/links/search']                                           = 'admin_panel/results/links/index/search';
$route['admin/results/links/status/(all|active|inactive)']                     = 'admin_panel/results/links/index/$1';
$route['admin/results/links/branddirect/status/(active|inactive)']             = 'admin_panel/results/links/brandlinks/$1';

// Frontend
$route['admin/results/suggestions/homepage']                = 'admin_panel/results/suggestions/homepage';
$route['admin/results/suggestions/fields']                  = 'admin_panel/results/suggestions/field_suggestions';
$route['admin/results/suggestions/umbrellas']               = 'admin_panel/results/suggestions/umbrella_suggestions';
$route['admin/results/suggestions/fields/get/id/(:num)']    = 'admin_panel/results/suggestions/get_field_suggestions/$1';
$route['admin/results/suggestions/umbrellas/get/id/(:num)'] = 'admin_panel/results/suggestions/get_umbrella_suggestions/$1';


// Search Keywords
$route['admin/results/keyword/add']                 = 'admin_panel/results/keywords/create';
$route['admin/results/keyword/delete/id/(:num)']    = 'admin_panel/results/keywords/delete/$1';
$route['admin/results/keyword/toggle/id/(:num)']    = 'admin_panel/results/keywords/toggle/$1';
$route['admin/results/keyword/update/id/(:num)']    = 'admin_panel/results/keywords/update/$1';
$route['admin/results/keywords/get']                = 'admin_panel/results/keywords/get';
$route['admin/results/keywords']                    = 'admin_panel/results/keywords';

// Research
$route['admin/results/research/add']              = 'admin_panel/results/research/create';
$route['admin/results/research/delete/(:num)']    = 'admin_panel/results/research/delete/$1';
$route['admin/results/research/get']              = 'admin_panel/results/research/get';
$route['admin/results/research/get/(:num)']       = 'admin_panel/results/research/get/$1';
$route['admin/results/research/list']             = 'admin_panel/results/research';
$route['admin/results/research/update/(:num)']    = 'admin_panel/results/research/update/$1';

/* 
    BRANDS 
*/

// Leads
$route['admin/brands/leads']                                = 'admin_panel/brands/leads';
$route['admin/brands/leads/id/(:num)/action/create/brand']  = 'admin_panel/brands/leads/create_brand/$1';
$route['admin/brands/leads/id/(:num)/action/create/user']   = 'admin_panel/brands/leads/create_user/$1';
$route['admin/brands/leads/get']                            = 'admin_panel/brands/leads/get';
$route['admin/brands/leads/delete/id/(:num)']                  = 'admin_panel/brands/leads/delete/$1';

// Brands
$route['admin/brand/create']                    = 'admin_panel/brands/brands/create';
$route['admin/brand/delete/id/(:num)']          = 'admin_panel/brands/brands/delete/$1';
$route['admin/brand/get/id/(:num)']             = 'admin_panel/brands/brands/get/$1';
$route['admin/brand/update/id/(:num)']          = 'admin_panel/brands/brands/update/$1';
$route['admin/brand/members/id/(:num)']         = 'admin_panel/brands/brands/members/$1';
$route['admin/brand/get/members/id/(:num)']     = 'admin_panel/brands/brands/get_members/$1';
$route['admin/brands']                          = 'admin_panel/brands/brands';
$route['admin/brands/get']                      = 'admin_panel/brands/brands/get';
$route['admin/brands/search/(:any)']            = 'admin_panel/brands/brands/search/$1';

// Ads
$route['admin/brands/ads/copy_to_vault/id/(:num)']                   = 'admin_panel/brands/ads/copy_to_media_vault/$1';
$route['admin/brands/ads/brand/id/(:num)/get/archived/(0|1)']        = 'admin_panel/brands/ads/get/$1/$2';
$route['admin/brands/ads/brand/id/(:num)/show/(library|archived)']   = 'admin_panel/brands/ads/view/$1/$2';
$route['admin/brands/ad/id/(:num)/action/create']                    = 'admin_panel/brands/ads/create/$1';
$route['admin/brands/ad/id/(:num)/action/update']                    = 'admin_panel/brands/ads/update/$1';

// Media Vault
$route['admin/brands/vault/brand/id/(:num)']                    = 'admin_panel/brands/vault/index/$1';
$route['admin/brands/vault/get/brand/id/(:num)']                = 'admin_panel/brands/vault/get/$1';
$route['admin/brands/vault/brand/id/(:num)/media/id/(:num)']    = 'admin_panel/brands/vault/create_ad/$1/$2';
$route['admin/brands/vault/update/status/media/id/(:num)']      = 'admin_panel/brands/vault/update_status/$1';

// BrandLinks
$route['admin/brands/brandlinks']                                      = 'admin_panel/brands/brandlinks';
$route['admin/brands/brandlinks/brand_id/(:num)']                      = 'admin_panel/brands/brandlinks/view_by_brand/$1';
$route['admin/brands/brandlinks/approve/id/(:num)']                    = 'admin_panel/brands/brandlinks/approve/$1';
$route['admin/brands/brandlinks/create/brand_id/(:num)']               = 'admin_panel/brands/brandlinks/create/$1';
$route['admin/brands/brandlinks/delete/id/(:num)']                     = 'admin_panel/brands/brandlinks/delete/$1';
$route['admin/brands/brandlinks/get']                                  = 'admin_panel/brands/brandlinks/get';
$route['admin/brands/brandlinks/get/brand_id/(:num)']                  = 'admin_panel/brands/brandlinks/get/$1';
$route['admin/brands/brandlinks/toggle/status/id/(:num)']              = 'admin_panel/brands/brandlinks/toggle/$1';
$route['admin/brands/brandlinks/update/id/(:num)']                     = 'admin_panel/brands/brandlinks/update/$1';


// Payments
$route['admin/brand/payments/id/(:num)']                = 'admin_panel/brands/payments/index/$1';
$route['admin/brand/payments/get/id/(:num)']            = 'admin_panel/brands/payments/get/$1';

// View as
$route['admin/viewas/brand/id/(:num)']                       = 'my_skearch/brand/ads/index/$1';
$route['admin/viewas/brand/id/(:num)/show/ads']              = 'my_skearch/brand/ads/index/$1';
$route['admin/viewas/brand/id/(:num)/show/brandlinks']       = 'my_skearch/brand/brandlinks/index/$1';
$route['admin/viewas/brand/id/(:num)/show/vault']            = 'my_skearch/brand/media_vault/index/$1';
$route['admin/viewas/brand/id/(:num)/show/ads/action/get']   = 'my_skearch/brand/ads/get/$1';
$route['admin/viewas/brand/id/(:num)/show/vault/action/get'] = 'my_skearch/brand/media_vault/get/$1';

// Ads Manager
$route['admin/ads/manager']                                                                             = 'admin_panel/ads_manager';
$route['admin/ads/manager/archive/ad/id/(:num)']                                                        = 'admin_panel/ads_manager/toggle_archive/$1';
$route['admin/ads/manager/create/(default|global)/banner/(a|b|u|va)']                                   = 'admin_panel/ads_manager/create/$1/0/$2';
$route['admin/ads/manager/create/(umbrella|field)/id/(:num)/banner/(a|b|u)']                            = 'admin_panel/ads_manager/create/$1/$2/$3';
$route['admin/ads/manager/dashboard']                                                                   = 'admin_panel/ads_manager';
$route['admin/ads/manager/delete/ad/id/(:num)']                                                         = 'admin_panel/ads_manager/delete/$1';
$route['admin/ads/manager/get/(default|global)/banner/(a|b|u|va)/archived/(0|1)']                       = 'admin_panel/ads_manager/get/$1/0/$2/$3';
$route['admin/ads/manager/get/(umbrella|field)/id/(:num)/banner/(a|b|u)/archived/(0|1)']                = 'admin_panel/ads_manager/get/$1/$2/$3/$4';
$route['admin/ads/manager/get/activity/ad/id/(:num)']                                                   = 'admin_panel/ads_manager/get_activity/$1';
$route['admin/ads/manager/restore/ad/id/(:num)']                                                        = 'admin_panel/ads_manager/toggle_archive/$1';
$route['admin/ads/manager/ad/id/(:num)/action/reset/activity']                                          = 'admin_panel/ads_manager/reset_activity/$1';
$route['admin/ads/manager/toggle/status/ad/id/(:num)']                                                  = 'admin_panel/ads_manager/toggle/$1';
$route['admin/ads/manager/update/ad/id/(:num)/(default|global)/banner/(a|b|u|va)']                      = 'admin_panel/ads_manager/update/$1/$2/0/$3';
$route['admin/ads/manager/update/ad/id/(:num)/(umbrella|field)/id/(:num)/banner/(a|b|u)']               = 'admin_panel/ads_manager/update/$1/$2/$3/$4';
$route['admin/ads/manager/update/priority/banner/id/(:num)']                                            = 'admin_panel/ads_manager/update_priority/$1';
$route['admin/ads/manager/upload/media']                                                                = 'admin_panel/ads_manager/upload_media';
$route['admin/ads/manager/view/(default|global)/banner/(a|b|u|va)/show/(library|archived)']             = 'admin_panel/ads_manager/view/$1/$2/$3';
$route['admin/ads/manager/view/(umbrella|field)/id/(:num)/banner/(a|b|u)/show/(library|archived)']      = 'admin_panel/ads_manager/view_by_page/$1/$2/$3/$4';
$route['admin/ads/manager/view/activity/ad/id/(:num)']                                                  = 'admin_panel/ads_manager/view_activity/$1';

/* Link Checker */
$route['admin/linkchecker']                         = 'admin_panel/linkchecker';
$route['admin/linkchecker/get/links']               = 'admin_panel/linkchecker/get';
$route['admin/linkchecker/remove/id/(:num)']        = 'admin_panel/linkchecker/remove/$1';
$route['admin/linkchecker/run']                     = 'admin_panel/linkchecker/run';
$route['admin/linkchecker/run/get/progress']        = 'admin_panel/linkchecker/get_curl_progress';
$route['admin/linkchecker/get_status_info']         = 'admin_panel/option/get_status_info';

/* Giveaways */
$route['admin/giveaways']                                        = 'admin_panel/giveaways';
$route['admin/giveaways/create']                                 = 'admin_panel/giveaways/create';
$route['admin/giveaways/delete/id/(:num)']                       = 'admin_panel/giveaways/delete/$1';
$route['admin/giveaways/draw/id/(:num)']                         = 'admin_panel/giveaways/draw/$1';
$route['admin/giveaways/get']                                    = 'admin_panel/giveaways/get';
$route['admin/giveaways/update/id/(:num)']                       = 'admin_panel/giveaways/update/$1';
$route['admin/giveaways/view/participants/id/(:num)']            = 'admin_panel/giveaways/view_participants/$1';
$route['admin/giveaways/view/participants/id/(:num)/get']        = 'admin_panel/giveaways/get_participants/$1';

/* Email */
$route['admin/email/invite']                        = 'admin_panel/email/invite';
$route['admin/email/logs/invite/view']              = 'admin_panel/email/invite_logs';
$route['admin/email/logs/invite/get']               = 'admin_panel/email/get_invite_logs';
$route['admin/email/logs/invite/view/id/(:num)']    = 'admin_panel/email/view_invite/$1';
$route['admin/email/logs/user/id/(:num)']           = 'admin_panel/email/logs/$1';
$route['admin/email/logs/get/user/id/(:num)']       = 'admin_panel/email/get_logs/$1';
$route['admin/email/logs/clear/user/id/(:num)']     = 'admin_panel/email/clear_logs/$1';
$route['admin/email/log/view/id/(:num)']            = 'admin_panel/email/view/$1';
$route['admin/email/message']                       = 'admin_panel/email/message';
$route['admin/email/templates/(:any)']              = 'admin_panel/email/templates/$1';

/* Settings */
$route['admin/settings']                       = 'admin_panel/settings';
$route['admin/option/update_option']         = 'admin_panel/option/update_option';
$route['admin/option/brandlinks_status_all'] = 'admin_panel/option/brandlinks_status_all';
