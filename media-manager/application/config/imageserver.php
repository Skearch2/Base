<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * -----------------------------------------------------------------------------
 *   File System
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the file system of the ImageServer make up this section.
 *  This section should be populated with the base path, the api folder, and where
 *  the wanted folders are located.
 *
 */
$config['imageserver_basepath']         = 'https://media.skearch.com/';
$config['imageserver_apifolder']        = 'api';
$config['imageserver_frontend_manager'] = 'manager';
$config['imageserver_frontend_access']  = 'yum';
$config['imageserver_frontend_mobile']  = 'npm';
$config['imageserver_frontend_admin']   = 'admin';

/**
 * -----------------------------------------------------------------------------
 *   Headers
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the header to pass to the ImageServer make up this section.
 *  This section should be populated with the names to be used as the headers for
 *  userid, secret string, and apikey.
 *
 */
$config['imageserver_header_apikey']     = 'X-API-KEY';
$config['imageserver_header_secret']     = 'X-SHHH-ITS-A-SECRET';
$config['imageserver_header_userid']     = 'X-I-USER';
$config['imageserver_header_appid']      = 'X-IDENTIFIER-KEY';

/**
 * -----------------------------------------------------------------------------
 *   Header Values
 * -----------------------------------------------------------------------------
 *
 * Values to pass via the header to the ImageServer make up this section. This
 * section should be populated with the values to be used as the headers for
 *  appid, secret string, and apikey.
 *
 */

$config['imageserver_admin_appid']      = '100';
$config['imageserver_admin_apikey']     = 'e4f4de1a932a048e0b8c52fbf56f8bd1';
$config['imageserver_admin_secret']     = '338c8c62f429de37e06ff8fb330271011c5000cb';

$config['imageserver_public_appid']     = '101';
$config['imageserver_public_apikey']    = 'b5d4af3cfb232c01311b183d42d05648';
$config['imageserver_public_secret']    = '8fdb8e9e1876dbdf1a6bce4840c3465ab7c2d1dd';

$config['imageserver_appid']            = '103';
$config['imageserver_apikey']           = '374986acc824c8621fa528d04740f308';
$config['imageserver_secret']           = '4ee05d706331ba7f624283e887673a7e3b52a855';


/**
 * -----------------------------------------------------------------------------
 *   HTTP Data Value Names
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the HTTP data to pass to the ImageServer make up this section.
 *  This section should be populated with the names to be used as the data identifiers
 *  for all data passed via HTTP.
 *
 */

// Data to send
$config['imageserver_data_albums']      = 'albumid';
$config['imageserver_data_albumtype']   = 'albumtype';
$config['imageserver_data_albumtypeid'] = 'albumtypeid';
$config['imageserver_data_albummediabox']   = 'albummediabox';
$config['imageserver_data_images']      = 'imageid';
$config['imageserver_data_users']       = 'userid';
$config['imageserver_data_apps']        = 'appid';

$config['imageserver_data_mediapriorities'] = 'mediapriorities';

$config['imageserver_data_title']       = 'title';
$config['imageserver_data_description'] = 'description';
$config['imageserver_data_url']         = 'url';
$config['imageserver_data_duration']    = 'duration';

$config['imageserver_data_filename']    = 'filename';
$config['imageserver_data_userfile']    = 'file';
$config['imageserver_data_mediaurl']    = 'mediaurl';

$config['imageserver_data_appname']     = 'appname';
$config['imageserver_data_level']       = 'level';
$config['imageserver_data_limit']       = 'limit';

/**
 * -----------------------------------------------------------------------------
 *   HTTP Data Image Accepted Types
 * -----------------------------------------------------------------------------
 *
 * The type of images that can be passed to the imageserver, given as a string where
 *  each type is separated by a bar (|).
 *
 */
$config['imageserver_acceptedtypes']    = '*';
$config['imageserver_maxsize']          = '*';


/**
 * -----------------------------------------------------------------------------
 *   HTTP Data Field Names
 * -----------------------------------------------------------------------------
 *
 * Variable dependent on the HTTP data passed from the ImageServer make up this section.
 *  This section should be populated with the names that will be used as the data
 *  identifiers for all data passed via HTTP.
 *
 */
// Data return
$config['imageserver_field_album_id']           = 'albumid';
$config['imageserver_field_album_title']        = 'albumtitle';
$config['imageserver_field_album_description']  = 'albumdescription';
$config['imageserver_field_album_type']         = 'albumtype';
$config['imageserver_field_album_type_id']      = 'albumtypeid';
$config['imageserver_field_album_mediabox']     = 'albummediabox';
$config['imageserver_field_album_images']       = 'images';

$config['imageserver_field_image_id']           = 'imageid';
$config['imageserver_field_image_title']        = 'imagetitle';
$config['imageserver_field_image_description']  = 'imagedescription';
$config['imageserver_field_image_filename']     = 'imagefilename';
$config['imageserver_field_image_mediaurl']     = 'mediaurl';
$config['imageserver_field_image_url']          = 'imageurl';
$config['imageserver_field_image_duration']     = 'imageduration';
$config['imageserver_field_image_clicks']       = 'imageclicks';
$config['imageserver_field_image_impressions']  = 'imageimpressions';
$config['imageserver_field_image_priority']     = 'imagepriority';
$config['imageserver_field_image_status']       = 'imagestatus';

$config['imageserver_field_app_id']             = 'appid';
$config['imageserver_field_app_name']           = 'appname';
$config['imageserver_field_app_secret']         = 'secret';

$config['imageserver_response_code']    = 'code';
$config['imageserver_response_message'] = 'message';
$config['imageserver_response_error']   = 'error';

?>
