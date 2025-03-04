<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Settings.php
 *
 * Controller to change Skearch settings
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2023
 * @version		2.0
 */
class Settings extends MY_Controller
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

		$this->load->model('admin_panel/Settings_model', 'Settings_model');
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function index()
	{
		if (!$this->ion_auth_acl->has_permission('site_settings') && !$this->ion_auth->is_admin()) {
			// set page title
			$data['title'] = ucwords('access denied');
			$this->load->view('admin_panel/errors/error_403', $data);
		} else {
			$this->form_validation->set_rules('site_version', 'Version', 'trim|required');
			$this->form_validation->set_rules('admin_email', 'Admin Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('brandlinks_status', 'BrandLinks', 'trim|required|numeric');
			$this->form_validation->set_rules('userlinks', 'UserLinks', 'trim|required|numeric');

			if ($this->form_validation->run() == false) {
				// Page data
				$data['settings'] = $this->Settings_model->get();

				// Load page content
				$data['title'] = ucwords("settings");
				$this->load->view('admin_panel/pages/settings', $data);
			} else {
				$data = [
					'site_version' => $this->input->post('site_version'),
					'admin_email' => $this->input->post('admin_email'),
					'brandlinks_status' => $this->input->post('brandlinks_status'),
					'userlinks' => $this->input->post('userlinks')
				];

				$update = $this->Settings_model->update($data);

				if ($update) {
					$this->session->set_flashdata('update_success', 1);
				} else {
					$this->session->set_flashdata('update_success', 0);
				}

				redirect("admin/settings");
			}
		}
	}
}
