<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/helpers/error.php
 *
 * Helper file to deliver http error pages
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */

/**
 * show 403 error page
 * 
 * @param string $theme admin, myskearch
 * @return void
 */

function error_403($theme = '')
{
    $CI = &get_instance();

    $data['title'] = ucwords('access denied');

    if ($theme == 'admin') {
        $CI->load->view('admin_panel/errors/error_403', $data);
    } else if ($theme == 'myskearch') {
        $CI->load->view('admin_panel/errors/error_403', $data);
    }
}

/**
 * show 404 error page
 * 
 * @param string $theme admin, myskearch
 * @return void
 */
function error_404($theme = '')
{
    $CI = &get_instance();

    $data['title'] = ucwords('page not found');

    if ($theme == 'admin') {
        $CI->load->view('admin_panel/errors/error_404', $data);
    } else if ($theme == 'myskearch') {
        $CI->load->view('admin_panel/errors/error_404', $data);
    }
}
