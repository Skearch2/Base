<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Option.php
 *
 * Controller to change Skearch version
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 202-
 * @version		2.0
 */
class Option extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			// redirect to the admin login page
			redirect('admin/auth/login');
		}

		if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
			// redirect to the admin login page
			redirect('admin/auth/login');
		}

		$this->load->model('admin_panel/Option_model_admin', 'Option_model');
	}

	public function index()
	{

		$data['title'] = ucfirst("option");
		$data['version'] = $this->Option_model->get_skearch_ver();
		$data['adlink_status'] = $this->Option_model->get_brandlinks_status();

		// Load page content
		$this->load->view('admin_panel/pages/option', $data);
	}

	public function update_option()
	{
		$this->Option_model->update_skearch_ver($this->input->post('version'));
		redirect('admin/option');
	}

	public function brandlinks_status_all()
	{
		$data = $this->input->post(NULL, TRUE);
		$this->Option_model->brandlinks_status_all($data['enable_status']);
		redirect('admin/option');
	}

	public function get_status_info()
	{
		echo $this->session->userdata('remainingUrls');
	}
}
