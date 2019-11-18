<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Configuration for Skearch2
|--------------------------------------------------------------------------
|
|   FLM - 17-AUG-18
|   After some back and forth between setting these up as constants
|   or as part of a custom config file, decided to use config file.
|   The main advantage this gives us is being able to setup an admin page
|   for modification of these values.
 */

/*
|--------------------------------------------------------------------------
| Site Defined URLs
|--------------------------------------------------------------------------
|
|   landing_page - Default page ("target") for empty URL
 */
$config['landing_page'] = 'default';

/* Maintenance mode */
$config['maintenance'] = false;

/* Skearch Application Title */
$config['skearch_title'] = "";
