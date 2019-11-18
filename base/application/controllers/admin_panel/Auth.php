<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/admin_panel/auth.php
 *
 * This is an authentication ontroller for admin panel.
 * @package		Skearch
 * @author		Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Auth extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function login() {

		if (!file_exists(APPPATH.'/views/admin_panel/pages/login.php')) {
			show_404();
		}

    if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
      redirect('admin/dashboard', 'refresh');
    }

		$this->form_validation->set_rules('login_id', 'Skearch ID', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() === FALSE) {

			$data['title'] = ucwords("admin panel | login");

			$this->load->view('admin_panel/pages/login', $data);

		} else {

			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('login_id'), $this->input->post('password'), $remember)) {
				redirect('admin/dashboard', 'refresh');

			} else {

				$data['title'] = ucwords("admin panel | login");

				$this->load->view('admin_panel/pages/login', $data);
			}

		}
	}

	public function logout() {
		$this->ion_auth->logout();
		$this->session->set_flashdata('logout', 'You have successfully logged out.');
		redirect('admin/auth/login');
	}

	public function redirect($url) {
		print_r($this->session->userdata());
	}


}
