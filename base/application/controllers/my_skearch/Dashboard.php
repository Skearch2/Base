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

		$this->user_id = $this->session->userdata('user_id');

		// defines section in myskearch
		$this->section = 'dashboard';

		$this->load->model('my_skearch/brand/Deals_model', 'Deals');
		$this->load->model('admin_panel/Giveaway_model', 'Giveaways');
		$this->load->model('Fields_History_model', 'Fields_History');
		$this->load->model('my_skearch/User_model', 'User');

		// update status on deals based on start/end date
		$this->Deals->update_status();

		// update status on giveaways based on start/end date
		$this->Giveaways->update_status();
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
	 * View page for My Skearch dashboard
	 *
	 * @return void
	 */
	public function index()
	{
		// default search engine
		$data['search_engine'] = $this->session->userdata('settings')->search_engine;

		// brand deals
		$brand_deals = $this->Deals->get($status = 'running');

		if (!empty($brand_deals)) {
			$deals_opted_in_by_user = $this->Deals->get_brands_deals_opted_in_by_user($this->session->userdata('user_id'));
			$deals_opted_in_by_user = array_column($deals_opted_in_by_user, 'id');

			foreach ($brand_deals as $deal) {
				if (in_array($deal->id, $deals_opted_in_by_user)) {
					$deal->is_user_opted_in = 1;
				} else {
					$deal->is_user_opted_in = 0;
				}
			}
		}

		$data['brand_deals_feed'] = $brand_deals;

		// fields history
		$fields_history = $this->Fields_History->get($this->user_id);
		if ($fields_history) {
			foreach ($fields_history as $field) {
				$field->time_elapsed = $this->_time_elapsed($field->timestamp);
			}
		}
		$data['fields_history'] = $fields_history;

		$data['section'] = "dashboard";
		$data['title'] = ucwords("my skearch | dashboard");

		// Load page content
		$this->load->view('my_skearch/pages/dashboard', $data);
	}

	/**
	 * Enlist user in the deal
	 *
	 * @param int $brand_deal_id Brand deal id
	 * @return void
	 */
	public function enlist_user_in_brand_deal($brand_deal_id)
	{
		$has_enlisted = $this->Deals->insert_participant($brand_deal_id, $this->session->userdata('user_id'));

		if ($has_enlisted) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	/**
	 * Update user customized settings
	 *
	 * @return void
	 */
	public function update_settings()
	{
		$search_engine = $this->input->get('search_engine');
		$update = $this->User->update_settings($this->user_id, array('search_engine' => $search_engine));

		if ($update) {
			// update settings in user session
			$settings = $this->session->userdata('settings');
			$settings->search_engine = $search_engine;
			$this->session->set_userdata('settings', $settings);
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

		if ($interval->y >= 1) {
			return ($interval->y == 1) ? "$interval->y year ago" : "$interval->y years ago";
		} else if ($interval->m >= 1) {
			return ($interval->m == 1) ? "$interval->m month ago" : "$interval->m months ago";
		} else if ($interval->d >= 1) {
			return ($interval->d == 1) ? "$interval->d day ago" : "$interval->d days ago";
		} else if ($interval->h >= 1) {
			return ($interval->h == 1) ? "$interval->h hour ago" : "$interval->h hours ago";
		} else if ($interval->i > 1) {
			return "$interval->i mins ago";
		} else {
			return "Just now";
		}
	}
}
