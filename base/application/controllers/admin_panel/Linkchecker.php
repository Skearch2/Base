<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/admin_panel/Linkchecker.php
 *
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
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
	 * Run link checker and update all links' status
	 *
	 * @return void
	 */
	public function run()
	{
		if (!$this->ion_auth_acl->has_permission('linkchecker') && !$this->ion_auth->is_admin()) {
			echo json_encode(-1);
		} else {

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
				// curl_setopt($multi_curl[$link->id], CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($multi_curl[$link->id], CURLOPT_TIMEOUT, ini_get('max_execution_time'));
				curl_setopt($multi_curl[$link->id], CURLOPT_NOPROGRESS, FALSE);
				curl_setopt($multi_curl[$link->id], CURLOPT_PROGRESSFUNCTION, array($this, 'curl_progress_callback'));
				// curl_setopt($multi_curl[$link->id], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				curl_multi_add_handle($mh, $multi_curl[$link->id]);
			}

			// $total_number_of_curl_execution = count($multi_curl);
			// $number_of_curl_executed = 0;

			// stop session writing to prevent session locking while curl execution
			session_write_close();

			$this->linkcheck_model->progress(1, 0);

			// execute curl multi
			$active = null;
			do {
				$mrc = curl_multi_exec($mh, $active);
				// $linkchecker_progress = round(($number_of_curl_executed++ / $total_number_of_curl_execution) * 100);
				// $this->linkcheck_model->progress($is_linkchecker_running = true, $linkchecker_progress);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);

			while ($active && $mrc == CURLM_OK) {
				if (curl_multi_select($mh) == -1) {
					usleep(1);
				}

				do {
					$mrc = curl_multi_exec($mh, $active);
					// $linkchecker_progress = round(($number_of_curl_executed++ / $total_number_of_curl_execution) * 100);
					// $this->linkcheck_model->progress($is_linkchecker_running = true, $linkchecker_progress);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}

			// resume session writing
			session_start();

			if ($mrc != CURLM_OK) {
				echo 0;
			} else {
				$data = array();

				// generate cumilative data to be batch updated
				foreach ($multi_curl as $id => $ch) {
					$data[] = array(
						'id' => $id,
						'http_status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
					);
					curl_multi_remove_handle($mh, $ch);
				}

				// batch update
				$this->linkcheck_model->update($data);

				echo 1;
			}

			// curl multi handle close
			curl_multi_close($mh);

			// echo $number_of_curl_executed;
			// echo " - ";
			// echo $total_number_of_curl_execution;
		}
	}

	/**
	 * Get Linkchecker execution and progress information
	 *
	 * @return void
	 */
	public function get_curl_progress()
	{
		if (!$this->ion_auth_acl->has_permission('linkchecker') && !$this->ion_auth->is_admin()) {
			echo json_encode(-1);
		} else {

			$progress = $this->linkcheck_model->progress();

			$data = array(
				'is_linkchecker_running' => $progress->is_linkchecker_running,
				'linkchecker_progress' 	 => $progress->linkchecker_progress
			);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($data));
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $download_size
	 * @param [type] $downloaded
	 * @param [type] $upload_size
	 * @param [type] $uploaded
	 * @return void
	 */
	public function curl_progress_callback($ch, $download_size, $downloaded, $upload_size, $uploaded)
	{
		if ($download_size > 0) {
			$progress = round($downloaded / $download_size) * 100;
			if ($progress == 100)
				$this->linkcheck_model->progress(1, $progress);
		}
	}
}
