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

		$this->load->model('Fields_History_model', 'Fields_History');
		$this->load->model('my_skearch/User_model', 'User');
	}

	/**
	 * Update user customized settings
	 *
	 * @return void
	 */
	public function update_settings()
	{
		$search_engine = $this->input->get('search_engine');

		$update = $this->User->update_settings($this->user_id, $search_engine, NULL);

		if ($update) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	public function index()
	{
		// user settings
		$user_settings = $this->User->get_settings($this->user_id);
		$data['search_engine'] = $user_settings->search_engine;

		//fields history
		$fields_history = $this->Fields_History->get($this->user_id);
		if ($fields_history) {
			foreach ($fields_history as $field) {
				$field->timestamp = $this->_time_elapsed($field->timestamp);
			}
		}
		$data['fields_history'] = $fields_history;

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
	public function delete_history()
	{
		$delete = $this->Fields_History->delete($this->user_id);

		if ($delete) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	/**
	 * Returns elasped time upto 24 hours
	 *
	 * @param timestamp $time
	 * @return void
	 */
	function _time_elapsed($time = false)
	{
		$interval =  date_create($time)->diff(date_create('now'));
		return ($interval->days > 0 ? "--" : ($interval->h < 1 && $interval->i < 1 ? "Just now" : ($interval->h >= 1 ? $interval->h . 'h ago ' : $interval->i . 'm ago')));
	}
}
