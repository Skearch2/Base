<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Auth.php
 *
 * This is an authentication controller.
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 * @version		2.0
 */
class Auth extends MY_Controller
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get CSRF token and hash
	 *
	 * @return void
	 */
	public function get_csrf_hash()
	{
		$data['csrf_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}
