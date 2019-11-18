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
class Option extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->ion_auth->is_admin())
		{
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
        }
        
        $this->load->model('admin_panel/Option_model_admin', 'Option_model');
	}

	public function index() {

		 if ( ! file_exists(APPPATH.'/views/admin_panel/pages/option.php')) {
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

		$data['title'] = ucfirst("option");
		$data['version'] = $this->Option_model->get_skearch_ver();
		$data['adlink_status'] = $this->Option_model->get_brandlinks_status();
		
		// Load page content
		$this->load->view('admin_panel/pages/option', $data);
	}

    public function update_option()
    {
        $result = $this->Option_model->update_skearch_ver($_POST['version']);   
        redirect('admin/option');
	}

	/** 
	 *  Disable or Enable all adlinks
	*/
	public function brandlinks_status_all()
    {
		$data = $this->input->post(NULL, TRUE);
		$this->Option_model->brandlinks_status_all($data['enable_status']);
        redirect('admin/option');
    }
}
