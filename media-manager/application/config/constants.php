<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Mike's Defined Constants
|--------------------------------------------------------------------------
|
| Constants to make fixed paths into relative paths
|
*/

define( 'IS_BASEPATH', 'https://media.skearch.com' );
define( 'LINE_BREAK', "\r\n" );
define( 'TAB', "\t" );
define( '_IS_MANAGER_API_KEY_', '374986acc824c8621fa528d04740f308' );

define( '_IS_TEST_APIKEY', 'a13846b61ebf4c123936942fbd995fd5' );
define( '_IS_TEST_SECRET', '73509e2f8981fd1247f400de53c60b0f8053fbb5' );
define( '_IS_TEST_APPID',  '104' );
define( '_IS_TEST_USERID',  '2' );


/* End of file constants.php */
/* Location: ./application/config/constants.php */
