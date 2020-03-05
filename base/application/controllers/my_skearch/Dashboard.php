<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is the My Skearch controller.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('myskearch/auth/login', 'refresh');
		}

		$this->user_id = $this->session->userdata('id');

		$this->load->model('my_skearch/User_model', 'User');
	}

	public function index()
	{


		if (!file_exists(APPPATH . '/views/my_skearch/pages/dashboard.php')) {
			show_404();
		}

		// user settings
		$user_settings = $this->User->get_settings($this->user_id);
		$data['search_engine'] = $user_settings->search_engine;

		$data['title'] = ucwords("my skearch | dashboard");
		$data['page'] = 'dashboard';

		// Load page content
		$this->load->view('my_skearch/pages/dashboard', $data);
	}

	/**
	 * Update user customized settings
	 *
	 * @return void
	 */
	public function update_settings()
	{
		$search_engine = $this->input->get('search_engine');

		$settings = $this->User->update_settings($this->user_id, $search_engine, NULL);

		if ($settings) {
			// $csrf_hash = $this->security->get_csrf_hash();
			// $this->output
			//     ->set_content_type('json')
			//     ->set_output(json_encode($csrf_hash));
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
