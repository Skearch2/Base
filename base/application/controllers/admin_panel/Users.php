<?php

/**
 * File: ~/application/controller/admin/Users.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * An authetication controller for My Skearch
 *
 * Allows users to login, register and signup to My Skearch
 *
 * @version        2.0
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright    Copyright (c) 2018 Skearch LLC
 */
class Users extends MY_Controller
{

    /**
     * Undocumented function
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/User_model_admin', 'User_model');
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Undocumented function
     */
    public function get_user_list($group)
    {

        $total_users = $this->db->count_all_results('skearch_users');
        $users = $this->User_model->get_user_list($group);
        $result = array(
            'iTotalRecords' => $total_users,
            'iTotalDisplayRecords' => $total_users,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $users,
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Undocumented function
     */
    public function get_users_by_lastname($last_name)
    {

        $result = $this->User_model->get_users_by_lastname($last_name);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Undocumented function
     */
    public function user_list($group)
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/users/user_list.php')) {
            show_404();
        }

        $data['title'] = ucwords("user list");
        $data['group'] = $group;
        if ($group == 1) {
            $data['heading'] = "Admins";
        } elseif ($group == 2) {
            $data['heading'] = "Editors";
        } elseif ($group == 3) {
            $data['heading'] = "Brand Users";
        } elseif ($group == 4) {
            $data['heading'] = "Premium Users";
        } else {
            $data['heading'] = "Registered Users";
        }

        // Load page content
        $this->load->view('admin_panel/pages/users/user_list', $data);
    }

    /**
     * Undocumented function
     */
    public function create_user()
    {

        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[skearch_users.email]|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('age_group', 'Age group', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[skearch_users.username]|alpha_numeric|min_length[5]|max_length[12]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password]|trim');
        $this->form_validation->set_rules('organization', 'Organization', 'trim');
        $this->form_validation->set_rules('brand', 'Brand', 'trim');
        $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
        $this->form_validation->set_rules('address1', 'Address 1', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');


        if ($this->form_validation->run() == false) {

            $data['states'] = $this->Util_model->get_state_list();
            $data['countries'] = $this->Util_model->get_country_list();
            $data['users_groups'] = $this->ion_auth->groups()->result();

            // set page title
            $data['title'] = ucwords('create user');

            $this->load->view('admin_panel/pages/users/create_user', $data);
        } else {

            $this->User_model->create_user();
            redirect('admin/users/user_list');
        }
    }

    /**
     * Undocumented function
     */
    public function edit_user($user_id)
    {

        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]|max_length[12]|alpha_numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|alpha');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|alpha');
        $this->form_validation->set_rules('address1', 'Address 1', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('organization', 'Organization', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        if (!empty($this->input->post('zip'))) {
            $this->form_validation->set_rules('zip', 'Zipcode', 'numeric|exact_length[5]');
        }
        $this->form_validation->set_rules('phone', 'Phone Number');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('age_group', 'Age Group', 'required');

        if ($this->form_validation->run() == false) {

            $user = $this->User_model->get_user($user_id);

            $data = array(
                'username' => $user->username,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'address1' => $user->address1,
                'address2' => $user->address2,
                'organization' => $user->organization,
                'city' => $user->city,
                'state' => $user->state,
                'country' => $user->country,
                'zip' => $user->zip,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'age_group' => $user->age_group,
                'active' => $user->active,
            );

            $data['user_group'] = $this->User_model->get_user_group($user_id);

            $data['states'] = $this->Util_model->get_state_list();
            $data['countries'] = $this->Util_model->get_country_list();
            $data['users_groups'] = $this->User_model->get_user_groups();

            $data['title'] = ucwords('edit user');

            $this->load->view('admin_panel/pages/users/edit_user', $data);
        } else {

            $user = $this->User_model->update_user($user_id);
            redirect('admin/users/user_list');
        }
    }

    /**
     * Undocumented function
     */
    public function delete_user($user_id)
    {
        $this->ion_auth->delete_user($user_id);
    }

    public function toggle_user_activation($user_id)
    {

        if ($this->ion_auth->is_admin($user_id) == null || $this->ion_auth->is_admin($user_id) == 0) {

            $status = $this->User_model->get_user($user_id)->active;

            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $this->User_model->toggle_user_activation($user_id, $status);

            echo json_encode($status);
        } else {
            echo json_encode(-1);
        }
    }

    public function get_user_groups()
    {

        $total_users_groups = $this->db->count_all_results('skearch_users_groups');
        $users_groups = $this->User_model->get_user_groups();
        $result = array(
            'iTotalRecords' => $total_users_groups,
            'iTotalDisplayRecords' => $total_users_groups,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $users_groups,
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function user_groups()
    {

        $data['title'] = ucwords("user groups");

        $this->load->view('admin_panel/pages/users/user_groups', $data);
    }

    public function create_user_group()
    {

        $this->form_validation->set_rules('groupname', 'Group Name', 'required|trim|min_length[5]|is_unique[skearch_groups.name]');
        $this->form_validation->set_rules('description', 'Group Description', 'trim|min_length[8]');

        if ($this->form_validation->run() == false) {

            $data['title'] = ucwords('create group');
            $this->load->view('admin_panel/pages/users/create_user_group', $data);
        } else {

            $this->User_model->create_user_group();
            redirect('admin/users/user_groups');
        }
    }

    public function edit_user_group($group_id)
    {

        $this->form_validation->set_rules('groupname', 'Group Name', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('description', 'Group Description', 'trim');

        if ($this->form_validation->run() == false) {

            $group = $this->User_model->get_group($group_id);

            $data = array(
                'groupname' => $group->name,
                'description' => $group->description,
            );

            $data['title'] = ucwords('edit group');
            $this->load->view('admin_panel/pages/users/edit_user_group', $data);
        } else {

            $group_update = $this->User_model->update_user_group($group_id);

            if (!$group_update) {
                $view_errors = $this->ion_auth->messages();
            } else {
                redirect('admin/users/user_groups');
            }
        }
    }

    public function delete_user_group($group_id)
    {

        $group_delete = $this->User_model->delete_user_group($group_id);

        if (!$group_delete) {
            die("hahaha");

            $view_errors = $this->ion_auth->messages();
        }
    }

    public function reset_user_password($user_id)
    {

        $identity = $this->ion_auth->where('id', $user_id)->users()->row();

        // run the forgotten password method to email an activation code to the user
        $forgotten = $this->ion_auth->forgotten_password($identity->username);

        if ($forgotten) {
            // if there were no errors
            return true;
        } else {
            return false;
        }
    }
}
