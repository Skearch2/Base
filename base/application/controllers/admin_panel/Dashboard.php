<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is an admin panel controller.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2018
 * @version		2.0
 */
class Dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if (!$this->ion_auth->is_admin())
		{
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
		}

    $this->load->model('admin_panel/Category_model_admin', 'category_model_admin');
	}

	public function index() {

		//print_r($_SESSION); die();

		 if ( ! file_exists(APPPATH.'/views/admin_panel/pages/dashboard.php')) {
			show_404();
		}

    $data = array(
      'total_umbrellas'         => $this->category_model_admin->count_umbrellas(),
      'total_active_umbrellas'  => $this->category_model_admin->count_umbrellas(1),
      'total_fields'            => $this->category_model_admin->count_fields(),
      'total_active_fields'     => $this->category_model_admin->count_fields(1),
      'total_results'           => $this->category_model_admin->count_results(),
      'total_active_results'    => $this->category_model_admin->count_results(1)
    );

		$data['title'] = ucfirst("dashboard");

		$this->load->view('admin_panel/pages/dashboard', $data);
	}


}
