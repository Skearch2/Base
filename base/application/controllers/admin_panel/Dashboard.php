<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/admin_panel/Dashboard.php
 *
 * This is an admin panel controller.
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			// redirect to the admin login page
			redirect('admin/auth/login');
		}

		if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
			$this->session->set_flashdata('no_access', 1);
			// redirect to the admin login page
			redirect('admin/auth/login');
		}

		$this->load->model('admin_panel/Dashboard_model', 'Dashboard');
	}

	/**
	 * Show admin dashboard with featured widgets
	 *
	 * @return void
	 */
	public function index()
	{

		$data['brand_stats'] = $this->Dashboard->get_brands_stats();
		$data['stats'] = $this->Dashboard->get_results_stats();
		$data['research_stats'] = $this->Dashboard->get_research_stats();

		$data['title'] = ucfirst("dashboard");
		$this->load->view('admin_panel/pages/dashboard', $data);
	}
}
