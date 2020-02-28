<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/linkchecker.php
 *
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Linkchecker extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->is_admin()) {
			// redirect non-admin to the login page
			redirect('admin/auth/login', 'refresh');
		}
		$this->load->model('admin_panel/Linkcheck_model_admin', 'linkcheck_model');
	}

	/**
	 * Get all bad URLs in JSON
	 *
	 * @return void
	 */
	public function get()
	{
		$urls = $this->linkcheck_model->get();
		$total_urls = sizeof($urls);
		$result = array(
			'iTotalRecords' => $total_urls,
			'iTotalDisplayRecords' => $total_urls,
			'sEcho' => 0,
			'sColumns' => "",
			'aaData' => $urls
		);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	/**
	 * Show a page list of all links in the link checker
	 *
	 * @return void
	 */
	public function index()
	{
		if (!file_exists(APPPATH . '/views/admin_panel/pages/linkchecker.php')) {
			show_404();
		}

		$data['title'] = ucfirst("Link Checker");
		$data['status'] = "active"; // Show

		// Load page content
		$this->load->view('admin_panel/pages/linkchecker', $data);
	}

	/**
	 * Remove link check
	 *
	 * @param int $id ID of the link
	 * @return void
	 */
	public function remove($id)
	{
		$action = $this->linkcheck_model->remove($id);

		if ($action) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check an individual link status
	 *
	 * @param String $url URL of the link
	 * @return void
	 */
	private function run_curl_check($url)
	{
		$ch = curl_init($url);

		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER         => false,
			CURLOPT_USERAGENT	   => 'Mozilla/5.0 (compatible; phpservermon/3.2.0; +http://www.phpservermonitor.org)',
			CURLOPT_NOBODY         => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT        => 5
		);
		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);
		$httpinfo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $httpinfo;
	}

	/**
	 * Run a link checker and check all the links status
	 *
	 * @return void
	 */
	public function update_urls_status()
	{
		$urls = $this->linkcheck_model->get_urls();
		$totalUrls =  count($urls);
		foreach ($urls as $url) {
			$_SESSION["remainingUrls"] = $totalUrls--;
			$status_code = $this->run_curl_check($url->www);
			$this->linkcheck_model->update_http_status($url->id, $status_code);
			if ($totalUrls <= 4670) break;
		}
	}
}
