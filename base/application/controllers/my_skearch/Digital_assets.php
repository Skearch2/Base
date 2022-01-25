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
class Digital_Assets extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('myskearch/auth/login', 'refresh');
		}

		// prevent access to regular users
		if ($this->ion_auth->in_group($this->config->item('regular', 'ion_auth'))) {
			redirect('myskearch');
		}

		$this->load->model('my_skearch/Giveaway_model', 'Giveaway');
	}

	/**
	 * View page for digital assets
	 *
	 * @return void
	 */
	public function index()
	{
		// data
		$giveaway = $this->Giveaway->get();

		$data['giveaway'] = $giveaway;

		if ($giveaway) {
			$data['is_user_participant'] = $this->Giveaway->verify_participant($giveaway->id, $this->session->userdata('user_id'));
		}

		// page data
		$data['section'] = 'digital assets';
		$data['page'] = 'digital assets';
		$data['title'] = ucwords("my skearch | digital assets");

		// Load page content
		$this->load->view('my_skearch/pages/digital_assets/default', $data);
	}

	/**
	 * Enlist user in the giveaway
	 *
	 * @param int $id giveaway id
	 * @return void
	 */
	public function participate_in_giveaway($giveaway_id)
	{
		$has_enlisted = $this->Giveaway->insert_participant($giveaway_id, $this->session->userdata('user_id'));

		if ($has_enlisted) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}
}
