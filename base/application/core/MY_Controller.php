<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	File:
 *	Author:   Fred McDonald - fred.mcdonald@live.com
 *
 * 	Parent Controller class for all routes to pages
 *  which require authorization.
 *
 * 	Sets runtime variables from database
 * 	Controls redirect to login page if user not logged into Skearch.
 */

/**
 * File:	~/application/core/MY_Controller.php
 *
 * @package		Skearch
 * @author		Fred McDonald
 * @copyright	Copyright (c) 2016
 * @since		Version 2.0.0
 */


class MY_Controller extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
	}
}
