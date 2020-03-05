<?php

/**
 * File: ~/application/controller/my_skearch/Profile.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controls member's profile on My Skearch
 *
 * Shows member's profile and allow member to edit profile
 *
 * @version        2.0
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020 Skearch LLC
 */
class Profile extends MY_Controller
{
    var $user_id;

    /**
     * Checks if the user is logged in and load required models
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        $this->load->model('Util_model', 'Util');
    }

    /**
     * Shows My Skearch user profile
     *
     * @return void
     */
    public function index()
    {

        if (!file_exists(APPPATH . '/views/my_skearch/pages/profile.php')) {
            show_404();
        }

        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]|trim');

        // check if user is signed in as brand member
        $is_brandmember = $this->ion_auth->in_group(3);

        if ($is_brandmember == 1) {
            $this->form_validation->set_rules('organization', 'Organization', 'required|trim');
            $this->form_validation->set_rules('brand', 'Brand', 'required|trim');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required|trim');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|exact_length[10]');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric|exact_length[5]');
        }

        if ($this->form_validation->run() === false) {

            $data['states'] = $this->Util->get_state_list();
            $data['countries'] = $this->Util->get_country_list();
            $data['is_brandmember'] = $is_brandmember;

            $data['title'] = ucwords("my skearch | profile");

            $this->load->view('my_skearch/pages/profile', $data);
        } else {

            $data = array(
                'username' => $this->input->post('username'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname')
            );

            if ($is_brandmember) {
                $data['organization'] = $this->input->post('organization');
                $data['brand'] = $this->input->post('brand');
                $data['phone'] = $this->input->post('phone');
                $data['address1'] = $this->input->post('address1');
                $data['address2'] = $this->input->post('address2');
                $data['city'] = $this->input->post('city');
                $data['state'] = $this->input->post('state');
                $data['country'] = $this->input->post('country');
                $data['zipcode'] = $this->input->post('zipcode');
            }

            if ($this->ion_auth->update($this->user_id, $data)) {

                $user = (array) $this->ion_auth->user()->row();
                $this->session->set_userdata($user);
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect('myskearch/profile');
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('myskearch/profile');
            }
        }
    }
}
