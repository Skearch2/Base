<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/linkchecker.php
 *
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Linkchecker extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->ion_auth->is_admin())
		{
			// redirect non-admin to the login page
			redirect('admin/auth/login', 'refresh');
		}
		$this->load->model('admin_panel/Linkcheck_model_admin', 'linkcheck_model');
	}

	public function index() {	
		if (!file_exists(APPPATH.'/views/admin_panel/pages/linkchecker.php')) {
			show_404();
		}

		$data['title'] = ucfirst("Link Checker");
		$data['status'] = "active"; // Show

		// Load page content
		$this->load->view('admin_panel/pages/linkchecker', $data);
	}

	// API to get bad URLs
	public function get_bad_urls() {
		$urls = $this->linkcheck_model->get_bad_urls();
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

	public function update_urls_status() {
		ini_set('max_execution_time', 0); // to get unlimited php script execution time

		if(empty($_SESSION['i'])){
			$_SESSION['i'] = 0;
		}

		$total = 100;
		for($i=$_SESSION['i'];$i<$total;$i++)
		{
			$_SESSION['i'] = $i;
			$percent = intval($i/$total * 100)."%";   
			
			sleep(1); // Here call your time taking function like sending bulk sms etc.

			echo '<script>
			parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
			parent.document.getElementById("progressinfo").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed.</div>";</script>';

			ob_flush(); 
			flush(); 
		}
		echo '<script>parent.document.getElementById("progressinfo").innerHTML="<div style=\"text-align:center; font-weight:bold\">Process completed</div>"</script>';


		// $urls = $this->linkcheck_model->get_urls();
		// foreach ($urls as $url) {
		// 	$status_code = $this->run_curl_check($url->www);
		// 	$this->linkcheck_model->update_http_status($url->id, $status_code);
		// }
	}
	
	public function run_curl_check($url) {
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

}