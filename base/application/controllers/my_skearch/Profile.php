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

        $this->load->model('my_skearch/User_model', 'User');
        $this->load->model('admin_panel/brands/Brand_model', 'Brand');
        $this->load->model('Util_model', 'Util');
    }

    /**
     * Shows My Skearch user profile
     *
     * @return void
     */
    public function index()
    {
        // get current logged-in user details
        $user =  $this->ion_auth->user()->row();

        // determine current logged-in user group
        $group = $this->ion_auth->get_users_groups()->row()->id;

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_validate_username|callback_username_check|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']');
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
            if (strlen($this->input->post('phone'))) {
                $this->form_validation->set_rules('phone', 'Phone', 'trim|required|callback_validate_phone');
            }
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
            if (strlen($this->input->post('state_other'))) {
                $this->form_validation->set_rules('state_other', 'State/Province', 'trim|regex_match[/^([a-z ])+$/i]');
            }
            if (strlen($this->input->post('zipcode'))) {
                $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
            }
        }

        if ($this->form_validation->run() === false) {

            $data['user'] =  $user;

            $data['states'] = $this->Util->get_state_list();
            $data['countries'] = $this->Util->get_country_list();

            $data['group'] = $group;
            $data['is_brandmember'] = $this->ion_auth->in_group(3);

            $data['title'] = ucwords("my skearch | profile");

            $this->load->view('my_skearch/pages/profile', $data);
        } else {

            $data['username'] = $this->input->post('username');

            // for admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $data['firstname'] = $this->input->post('firstname');
                $data['lastname'] = $this->input->post('lastname');
            }
            // for regular and premium user groups
            elseif (in_array($group, array(4, 5))) {
                $data['firstname'] = $this->input->post('name');
            }

            // for admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $data['organization'] = $this->input->post('organization');
                // for brand member group
                if (in_array($group, array(3))) {
                    $data['brand'] = $this->input->post('brand');
                }
                $data['phone'] = preg_replace("/[^0-9]/", "", $this->input->post('phone'));
                $data['address1'] = $this->input->post('address1');
                $data['address2'] = $this->input->post('address2');
                $data['city'] = $this->input->post('city');
                $data['state'] = empty($this->input->post('state_us')) ? $this->input->post('state_other') : $this->input->post('state_us');
                $data['country'] = $this->input->post('country');
                $data['zipcode'] = $this->input->post('zipcode');
            }

            if ($this->User->update($user->id, $data)) {

                // updated user details
                $user = $this->ion_auth->user()->row();

                $user_session_data = [
                    'identity' => $user->username,
                    'username' => $user->username,
                    'email' => $user->email,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname
                ];

                // update user session
                $this->session->set_userdata($user_session_data);

                $this->session->set_flashdata('success', 1);
                redirect('myskearch/profile');
            } else {
                $this->session->set_flashdata('success', 0);
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
            if ($this->ion_auth->user()->row()->username !== $username) {
                $this->form_validation->set_message('username_check', 'The username already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Validates address
     *
     * @return void
     */
    // function validate_address()
    // {
    //     if ($this->input->post('country') || $this->input->post('state') || $this->input->post('city') || $this->input->post('address1')) {
    //         return TRUE;
    //     } else {
    //         $this->form_validation->set_message('validate_either', 'Please enter atleast one of City , State or Country');
    //         return FALSE;
    //     }
    // }

    /**
     * Validates US phone numnber
     *
     * @return bool
     */
    public function validate_phone()
    {
        $phone = preg_replace("/[^0-9]/", "", $this->input->post('phone'));
        if (strlen($phone) != 10) {
            $this->form_validation->set_message('validate_phone', 'The %s number entered is invalid.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validates username
     *
     * @return bool
     */
    public function validate_username($username)
    {
        $result = preg_match('/ /', $username);
        if ($result) {
            $this->form_validation->set_message('validate_username', 'The %s cannot contain any space.');
            return false;
        } else {
            return true;
        }
    }
}
