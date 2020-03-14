<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/users/Users.php
 * 
 * Controller for users
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Users extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/users/User_model', 'User');
        $this->load->model('admin_panel/users/Group_model', 'Group');
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Create user
     *
     * @return void
     */
    public function create()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[skearch_users.username]|alpha_numeric|min_length[5]|max_length[12]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[15]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[skearch_users.email]|trim');
        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('age_group', 'Age group', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'trim');
        $this->form_validation->set_rules('brand', 'Brand', 'trim');
        if (strlen($this->input->post('phone'))) {
            $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
        }
        $this->form_validation->set_rules('address1', 'Address 1', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        if (strlen($this->input->post('zipcode'))) {
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
        }
        $this->form_validation->set_rules('group', 'Group', 'required');


        if ($this->form_validation->run() == false) {

            $data['states'] = $this->Util_model->get_state_list();
            $data['countries'] = $this->Util_model->get_country_list();
            $data['users_groups'] = $this->ion_auth->groups()->result();

            // set page title
            $data['title'] = ucwords('create user');

            $this->load->view('admin_panel/pages/users/create', $data);
        } else {

            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $additional_data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'gender' => $this->input->post('gender'),
                'age_group' => $this->input->post('age_group'),
                'organization' => $this->input->post('organization'),
                'brand' => $this->input->post('brand'),
                'phone' => $this->input->post('phone'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'zipcode' => $this->input->post('zipcode'),
                'active' => $this->input->post('active'),
            );
            $group = array($this->input->post('group'));

            $create = $this->User->create($username, $password, $email, $additional_data, $group);

            if ($create) {
                $this->session->set_flashdata('success', 1);
            } else {
                $this->session->set_flashdata('success', 0);
            }
            redirect('admin/users/group/id/5');
        }
    }

    /**
     * Delete user
     *
     * @param int $id ID of the user
     * @return void
     */
    public function delete($id)
    {
        $delete = $this->User->delete($id);

        return $delete;
    }

    /**
     * Callback for email validation
     *
     * @param String $email Email of the user
     * @return void
     */
    public function email_check($email)
    {
        $id =  $this->input->post('id');

        if ($this->ion_auth->email_check($email)) {
            if ($this->User->get($id)->email !== $email) {
                $this->form_validation->set_message('email_check', 'The email already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Get users by group
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function get($id, $is_group = FALSE)
    {
        if ($is_group) {
            $total_users = $this->db->count_all_results('skearch_users');
            $users = $this->User->get($id, TRUE);
            $result = array(
                'iTotalRecords' => $total_users,
                'iTotalDisplayRecords' => $total_users,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $users,
            );
        } else {
            $result = $this->User->get($id);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Show user list based on group
     *
     * @param int $group ID of the user group
     * @return void
     */
    public function index($id)
    {
        if ($id == 1 || $id == 2) {
            $group = "Staff";
        } elseif ($id == 3) {
            $group = "Brand Users";
        } elseif ($id == 4) {
            $group = "Premium Users";
        } else {
            $group = "Registered Users";
        }

        $data['group'] = $id;

        $data['title'] = $group;
        $this->load->view('admin_panel/pages/users/view', $data);
    }

    /**
     * Update user data
     *
     * @param int $id ID of the user
     * @return void
     */
    public function update($id)
    {

        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check|alpha_numeric|min_length[5]|max_length[12]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check|trim');
        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('age_group', 'Age group', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'trim');
        $this->form_validation->set_rules('brand', 'Brand', 'trim');
        if (strlen($this->input->post('phone'))) {
            $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
        }
        $this->form_validation->set_rules('address1', 'Address 1', 'trim');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        if (strlen($this->input->post('zipcode'))) {
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
        }
        $this->form_validation->set_rules('group', 'Group', 'required');

        if ($this->form_validation->run() == false) {

            $user = $this->User->get($id);

            $data = array(
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'gender' => $user->gender,
                'age_group' => $user->age_group,
                'organization' => $user->organization,
                'brand' => $user->brand,
                'phone' => $user->phone,
                'address1' => $user->address1,
                'address2' => $user->address2,
                'city' => $user->city,
                'state' => $user->state,
                'country' => $user->country,
                'zipcode' => $user->zipcode,
                'active' => $user->active,
                'group' => $this->Group->get($id)
            );

            $data['states'] = $this->Util_model->get_state_list();
            $data['countries'] = $this->Util_model->get_country_list();
            $data['users_groups'] = $this->Group->get();

            $data['title'] = ucwords('edit user');

            $this->load->view('admin_panel/pages/users/edit', $data);
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'gender' => $this->input->post('gender'),
                'age_group' => $this->input->post('age_group'),
                'organization' => $this->input->post('organization'),
                'brand' => $this->input->post('brand'),
                'phone' => $this->input->post('phone'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'zipcode' => $this->input->post('zipcode'),
                'active' => $this->input->post('active'),
            );

            $update = $this->User->update($id, $user_data);
            if ($update) {
                $this->session->set_flashdata('success', 1);
            } else {
                $this->session->set_flashdata('success', 0);
            }
            redirect('admin/users/group/id/5');
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
        $id =  $this->input->post('id');

        if ($this->ion_auth->username_check($username)) {
            if ($this->User->get($id)->username !== $username) {
                $this->form_validation->set_message('username_check', 'The username already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }

    // public function get_users_by_lastname($last_name)
    // {

    //     $result = $this->User->get_users_by_lastname($last_name);
    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($result));
    // }

    /**
     * Reset user password
     *
     * @param int $id ID of the user
     * @return void
     */
    public function reset($id)
    {
        $user = $this->ion_auth->where('id', $id)->users()->row();

        // run the forgotten password method to email an activation code to the user
        $forgotten = $this->ion_auth->forgotten_password($user->username);

        if ($forgotten) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Toggle user active status
     *
     * @param int $id ID of the user
     * @return void
     */
    public function toggle($id)
    {
        if ($this->ion_auth->is_admin($id) == NULL || $this->ion_auth->is_admin($id) == 0) {
            $status = $this->User->get($id)->active;

            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $user_data = array(
                'active' => $status,
            );

            $this->User->update($id, $user_data);

            echo json_encode($status);
        } else {
            echo json_encode(-1);
        }
    }
}
