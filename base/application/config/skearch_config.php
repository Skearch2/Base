<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| CONFIGURATION FOR SKEARCH BASE
|--------------------------------------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will try guess the protocol, domain
| and path to your installation. However, you should always configure this
| explicitly and never rely on auto-guessing, especially in production
| environments.
|
*/
define('BASE_URL', 'https://dev.skearch.com/media-manager/');


/*
|--------------------------------------------------------------------------
| Database Connectivity Settings
|--------------------------------------------------------------------------
|
| This section will contain the settings needed to access the database.
| WITH a trailing slash:
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['DB_HOST'] The hostname of your database server.
|	['DB_USERNAME'] The username used to connect to the database
|	['DB_PASS'] The password used to connect to the database
|	['DB_NAME'] The name of the database you want to connect to
|
*/

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'skearch_dba');
define('DB_PASS', get_cfg_var('SKEARCH_DBA_PASS'));
define('DB_NAME', 'skearch_dev');
