<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
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


class MY_Controller extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// // Get application title from db and set global variable
		// $query = $this->db->get_where('skearch_settings', array('varname' => 'title'));
		// $row = $query->row_array();
		// $this->globals->skearch_title = $row['value'];

    }


	// public function isAdmin() {
	// 	/*
	// 	 *  Evaluate:
	// 	 * 		is a user logged in?
	// 	 * 		are they in the admin group?
	// 	 */
  //
  //
	// 	if (($this->ion_auth->logged_in()) && ($this->ion_auth->is_admin())) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }

}
