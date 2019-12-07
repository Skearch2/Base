<?php
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Globals {
		

		
		/* Maintenance mode */
		var $maintenance = TRUE;

		/* Skearch Application Title */
		var $skearch_title = "";


/*
 * 	Variables flushed to the right are only here for development
 *  purposes -- they're leftovers from PMD and will be going away.
 */ 


		

/*******************************************************************
* URL Path - NO TRAILING SLASH
* This is the full URL web path to the script
* Example: http://www.domain.com
*******************************************************************/
//	var $BASE_URL = 'http://localhost/Skearch/application';
var $BASE_URL = 'https://www.skearch2.com/application';

/*******************************************************************
* SSL URL Path - NO TRAILING SLASH
* This is the full URL web path to the script for use with a SSL certificate.
* Example: https://www.domain.com (Notice: https://)
*******************************************************************/
var $BASE_URL_SSL = '';

/*******************************************************************
* Encryption/Security Key
********************************************************************/
var $SECURITY_KEY = '43e15b88fabbfd446461e0f6320988042f4ba4f342be679066b71c37d20de985';

/*******************************************************************
* Root Path (absolute path to script) - NO TRAILING SLASH
* This is the full server path to the script install directory.
* Example: /home/username/public_html/directory
* NOTE: This path is usually automatically set by the script.
*******************************************************************/
var $PMDROOT = '';
//$PMDROOT = !empty($PMDROOT) ? $PMDROOT : dirname(str_replace('\\','/',__FILE__));


/******************************************************************
* Files Path (absolute path) and URL
* This is used to store static files in an alternate location
*******************************************************************/
var $FILES_PATH = NULL;
var $FILES_URL = NULL;

/******************************************************************
* Session and Cookie Settings
*******************************************************************/
var $COOKIE_PATH = NULL;
var $COOKIE_DOMAIN = NULL;

	

	}
?>
