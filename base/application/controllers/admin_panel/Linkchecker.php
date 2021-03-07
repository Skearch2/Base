<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/admin_panel/Linkchecker.php
 *
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Linkchecker extends MY_Controller
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

		$this->load->model('admin_panel/Linkcheck_model_admin', 'linkcheck_model');
	}

	/**
	 * Get all bad URLs in JSON
	 *
	 * @return void
	 */
	public function get()
	{
		if ($this->ion_auth_acl->has_permission('linkchecker') or $this->ion_auth->is_admin()) {
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
	}

	/**
	 * Show a page list of all links in the link checker
	 *
	 * @return void
	 */
	public function index()
	{
		if (!$this->ion_auth_acl->has_permission('linkchecker') && !$this->ion_auth->is_admin()) {
			// set page title
			$data['title'] = ucwords('access denied');
			$this->load->view('admin_panel/errors/error_403', $data);
		} else {
			// Load page content
			$data['title'] = ucfirst("Link Checker");
			$this->load->view('admin_panel/pages/linkchecker', $data);
		}
	}

	/**
	 * Remove link check
	 *
	 * @param int $id ID of the link
	 * @return void
	 */
	public function remove($id)
	{
		if (!$this->ion_auth_acl->has_permission('linkchecker') && !$this->ion_auth->is_admin()) {
			echo json_encode(-1);
		} else {
			$action = $this->linkcheck_model->remove($id);

			if ($action) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Run a link checker and check all the links status
	 *
	 * @return void
	 */
	public function update_urls_status()
	{
		if (!$this->ion_auth_acl->has_permission('linkchecker') && !$this->ion_auth->is_admin()) {
			echo json_encode(-1);
		} else {

			$php_execution_limit = ini_get('max_execution_time');

			// set php execution limit for this process
			set_time_limit(60);

			$links = $this->linkcheck_model->get_urls();

			// curl multi handle
			$mh = curl_multi_init();

			// array of curl handles
			$multi_curl = array();

			foreach ($links as $link) {
				$multi_curl[$link->id] = curl_init();
				curl_setopt($multi_curl[$link->id], CURLOPT_URL, $link->www);
				curl_setopt($multi_curl[$link->id], CURLOPT_HEADER, 0);
				curl_setopt($multi_curl[$link->id], CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($multi_curl[$link->id], CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
				curl_setopt($multi_curl[$link->id], CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($multi_curl[$link->id], CURLOPT_TIMEOUT, ini_get('max_execution_time'));
				curl_setopt($multi_curl[$link->id], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				curl_multi_add_handle($mh, $multi_curl[$link->id]);
			}

			// execute curl multi
			$active = null;
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);

			while ($active && $mrc == CURLM_OK) {
				if (curl_multi_select($mh) == -1) {
					usleep(1);
				}

				do {
					$mrc = curl_multi_exec($mh, $active);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}

			// restore php execution limit
			set_time_limit($php_execution_limit);

			if ($mrc != CURLM_OK) {
				echo 0;
			} else {
				// update url status and remove handles
				foreach ($multi_curl as $id => $ch) {
					$this->linkcheck_model->update_http_status($id, curl_getinfo($ch, CURLINFO_HTTP_CODE));
					curl_multi_remove_handle($mh, $ch);
				}
				echo 1;
			}

			// curl multi handle close
			curl_multi_close($mh);
		}
	}
}
