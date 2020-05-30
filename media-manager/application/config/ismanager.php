<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * -----------------------------------------------------------------------------
 *   File System
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the file system of the ImageServer make up this section.
 *  This section should be populated with the name of the classes and models used.
 *
 */
$config['welcome_class']    = 'welcome';
$config['admin_class']      = 'admin';
$config['main_class']       = 'main';
$config['view_class']       = 'view';

$config['curl_model']       = 'curler';
$config['admin_model']      = 'adminator';

$config['tmp_dir']          = 'tmp';
$config['tmp_permissions']  = 0755;

/**
 * -----------------------------------------------------------------------------
 *   Admin Id
 * -----------------------------------------------------------------------------
 *
 * The unique identifier for the admin account.  Default 1
 *
 */
$config['admin_id']         = '1';
$config['admin_group_id']   = '1';

$config['user_query']       = 'SELECT `id` AS userid, `username` AS username FROM `skearch_users` WHERE `id` > 1'; // Where 1 is the admin_id - i.e. do not display
$config['userinfo_query']   = 'SELECT `id` AS userid, `username` AS username, `first_name` AS firstname, `last_name` AS lastname, `phone` AS telephone, `email` AS email FROM `skearch_users` WHERE `id` > 1'; // Where 1 is the admin_id - i.e. do not display
$config['usercount_query']  = 'SELECT COUNT(*) AS usercount FROM `skearch_users` WHERE `id` > 1';

$config['field_userid']     = 'userid';
$config['field_username']   = 'username';
$config['field_firstname']  = 'firstname';
$config['field_lastname']   = 'lastname';
$config['field_telephone']  = 'telephone';
$config['field_email']      = 'email';
$config['field_usercount']  = 'usercount';

/**
 * -----------------------------------------------------------------------------
 *   Form Data
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the form data passed via the Is-Manager make up this section.
 *  This section should be populated with the name of each field used in a view.
 *
 */
// These are for names of form data
$config['data_albumid']     = 'albumid';
$config['data_albumtype']   = 'albumtype';
$config['data_albumtypeid'] = 'albumtypeid';
$config['data_albummediabox'] = 'albummediabox';
$config['data_imageid']     = 'imageid';
$config['data_userid']      = 'userid';

$config['data_email']       = 'email';
$config['data_password']    = 'password';
$config['data_rememberme']  = 'rememberme';

$config['data_appname']     = 'appname';
$config['data_firstname']   = 'firstname';
$config['data_lastname']    = 'lastname';
$config['data_telephone']   = 'telephone';
$config['data_confirm']     = 'confirmpassword';

$config['data_brandid']     = 'brandid';
$config['data_title']       = 'title';
$config['data_description'] = 'description';
$config['data_mediaurl']    = 'mediaurl';
$config['data_url']         = 'url';
$config['data_duration']    = 'duration';

$config['data_userfile']    = 'file';
$config['data_filename']    = 'filename';
$config['data_filetypes']   = 'filetype';
$config['data_link']        = 'hyperlink';

$config['data_mediapriorities'] = 'mediapriorities';

/**
 * -----------------------------------------------------------------------------
 *   View Config
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the view pieces of the IS-Manager make up this section.
 *  This section should be populated with the name of icons, themes and custom
 *  classes wanted.
 *
 */

$config['album_default']    = 'default';
$config['album_global']     = 'global';
$config['album_umbrella']   = 'umbrella';
$config['album_field']      = 'field';

$config['mediaboxu']        = 'U';

$config['frontend_view']    = 'template';

$config['bootstrap_theme']  = 'bootstrap-theme.css';

$config['css_thumbnail_class']    = 'thumbnail_img';
$config['css_img_class']    = 'constrained_img';
$config['css_original_img_class']    = 'original_img';

$config['server_icon']      = '16_server.png';
$config['edit_icon']        = 'pencil-2x.png';
$config['delete_icon']      = 'delete-2x.png';
$config['image_icon']       = 'image-2x.png';

/**
 * -----------------------------------------------------------------------------
 *   Url Config
 * -----------------------------------------------------------------------------
 *
 */

$config['base_domain'] = BASE_DOMAIN;
$config['api_get_data'] = 'https://dev.skearch.com/browse/get_data/';
