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
 * @author        Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018 Skearch LLC
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

        $this->load->model('Util_model', 'Util_model');

    }

    /**
     * Shows My Skearch member profile
     */
    public function index($user_id = null)
    {

        if (!file_exists(APPPATH . '/views/my_skearch/pages/profile.php')) {
            show_404();
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|alpha');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|alpha');
        $this->form_validation->set_rules('address1', 'Address 1', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('organization', 'Organization', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        if (!empty($this->input->post('zip'))) {
            $this->form_validation->set_rules('zip', 'Zipcode', 'numeric|exact_length[5]');
        }
        $this->form_validation->set_rules('phone', 'Phone Number', 'numeric');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('age_group', 'Age Group', 'required');

        if ($this->form_validation->run() === false) {

            $data['csrf'] = $this->_get_csrf_nonce();
            $data['myskearch_id'] = $this->session->userdata('id');

            $data['states'] = $this->Util_model->get_state_list();
            $data['countries'] = $this->Util_model->get_country_list();
            $data['user_group'] = $this->ion_auth->get_users_groups($this->session->userdata('id'))->row();

            $data['title'] = ucwords("my skearch | profile");

            $this->load->view('my_skearch/pages/profile', $data);

        } else {

            //do we have a valid request?
            if ($this->_valid_csrf_nonce() === false || $user_id !== $this->input->post('myskearch_id')) {
                show_error($this->lang->line('error_csrf'));
                die();
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'organization' => $this->input->post('organization'),
                'phone' => $this->input->post('phone'),
                'gender' => $this->input->post('gender'),
                'age_group' => $this->input->post('age_group'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'zip' => $this->input->post('zip'),
            );

            if ($this->ion_auth->update($this->session->userdata('id'), $data)) {

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

    /**
     * Generate a CSRF key-value pair
     *
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);
        return [$key => $value];
    }

    /**
     * Validates CSRF token
     *
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return true;
        }
        return false;
    }

}
