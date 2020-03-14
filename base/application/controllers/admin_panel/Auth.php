<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/admin_panel/Auth.php
 *
 * This is an authentication ontroller for admin panel.
 * @package		Skearch
 * @author		Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright	Copyright (c) 2019
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

		$this->load->model('my_skearch/User_model', 'User');
	}

	/**
	 * Allow access to admin panel
	 *
	 * @return void
	 */
	public function login()
	{
		if ($this->ion_auth->is_admin()) {
			redirect('admin/dashboard', 'refresh');
		}

		$this->form_validation->set_rules('id', 'Admin ID', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() === FALSE) {

			$data['title'] = ucwords("admin panel | login");

			$this->load->view('admin_panel/pages/login', $data);
		} else {

			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('id'), $this->input->post('password'), $remember)) {

				if (!$this->ion_auth->is_admin()) {
					redirect(base_url());
				} else {
					$user = (array) $this->ion_auth->user()->row();

					// add user group in the user information
					$user['groupid'] =  $this->ion_auth->get_users_groups($user['id'])->row()->id;
					$user['group'] =  $this->ion_auth->get_users_groups($user['id'])->row()->name;
	
					// add user set theme
					$user['theme'] = $this->User->get_settings($user['id'], 'theme')->theme;
	
					// add user data to session
					$this->session->set_userdata($user);
	
					redirect('admin/dashboard', 'refresh');
				}
			} else {

				$data['title'] = ucwords("admin panel | login");

				$this->load->view('admin_panel/pages/login', $data);
			}
		}
	}

	/**
	 * Logout from admin panel
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('logout', true);
		redirect('admin/auth/login');
	}
}
