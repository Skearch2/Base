<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is the My Skearch controller.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
      redirect('myskearch/auth/login', 'refresh');
    }

	 }

	public function index() {


	  if ( ! file_exists(APPPATH.'/views/my_skearch/pages/dashboard.php')) {
		/*
		 * If a predefined page file of the name in the parameter
		 * does not exist in the /view/pages/ad2 directory
		 * display a 404.
		 */
	 	  show_404();
  	}

		/*
		 * 	Set Page Data:
		 *		Relative URL for building canonical URL in page header
		 * 		Page title (Capitalize first letter)
		 * 		Admin page flag (Boolean: True)
		 */

		$data['title'] = ucwords("my skearch | dashboard");
		$data['page'] = 'dashboard';

		// Load page content
		$this->load->view('my_skearch/pages/dashboard', $data);
	}


}
