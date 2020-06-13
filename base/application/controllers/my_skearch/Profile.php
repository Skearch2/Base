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
    /**
     * Checks if the user is logged in and load required models
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        $this->load->model('admin_panel/users/User_model', 'User');
        $this->load->model('Util_model', 'Util');
    }

    /**
     * Shows My Skearch user profile
     *
     * @return void
     */
    public function index()
    {
        $group = $this->ion_auth->get_users_groups()->row()->id;

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check|alpha_numeric|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']');
        // only show to admin, editor, and brand member groups
        if (in_array($group, array(1, 2, 3))) {
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha');
        }
        // only show to regular and premium user groups
        else if (in_array($group, array(4, 5))) {
            $this->form_validation->set_rules('name', 'Name', 'trim|alpha');
        }
        // only show to admin, editor, and brand member groups
        if (in_array($group, array(1, 2, 3))) {
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
            $this->form_validation->set_rules('city', 'City', 'trim');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric|exact_length[5]');
        }

        if ($this->form_validation->run() === false) {

            $data['user'] =  $this->ion_auth->user()->row();

            $data['states'] = $this->Util->get_state_list();
            $data['countries'] = $this->Util->get_country_list();

            $data['group'] = $group;
            $data['is_brandmember'] = $this->ion_auth->in_group(3);

            $data['title'] = ucwords("my skearch | profile");

            $this->load->view('my_skearch/pages/profile', $data);
        } else {

            $data['username'] = $this->input->post('username');

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $data['firstname'] = $this->input->post('firstname');
                $data['lastname'] = $this->input->post('lastname');
            }
            // only show to regular and premium user groups
            elseif (in_array($group, array(4, 5))) {
                $data['firstname'] = $this->input->post('name');
            }

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $data['organization'] = $this->input->post('organization');
                // only show to brand member group
                if (in_array($group, array(3))) {
                    $data['brand'] = $this->input->post('brand');
                }
                $data['phone'] = $this->input->post('phone');
                $data['address1'] = $this->input->post('address1');
                $data['address2'] = $this->input->post('address2');
                $data['city'] = $this->input->post('city');
                $data['state'] = $this->input->post('state');
                $data['country'] = $this->input->post('country');
                $data['zipcode'] = $this->input->post('zipcode');
            }

            if ($this->ion_auth->update($this->user_id, $data)) {

                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect('myskearch/profile');
            } else {

                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('myskearch/profile');
            }
        }
    }

    /**
     * Callback for username validation
     *
     * @param String $username Username of the user
     * @return void
     */
    public function username_check($username)
    {
        $id =  $this->session->userdata('id');

        if ($this->ion_auth->username_check($username)) {
            if ($this->User->get($id)->username !== $username) {
                $this->form_validation->set_message('username_check', 'The username already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }
}
