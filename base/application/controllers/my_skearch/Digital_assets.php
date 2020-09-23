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
	}

	/**
	 * View page for digital assets
	 *
	 * @return void
	 */
	public function index()
	{
		$data['section'] = 'digital assets';
		$data['page'] = 'digital assets';
		$data['title'] = ucwords("my skearch | digital assets");

		// Load page content
		$this->load->view('my_skearch/pages/digital_assets/default', $data);
	}
}
