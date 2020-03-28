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

        if (!$this->ion_auth->logged_in()) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/users/User_model', 'User');
        $this->load->model('admin_panel/users/Group_model', 'Group');
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Create user
     *
     * @param int $group ID of the group
     * @return void
     */
    public function create($group)
    {
        if (!$this->ion_auth_acl->has_permission('users_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[skearch_users.username]|alpha_numeric|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[skearch_users.email]|trim');
            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
            }
            // only show to regular and premium user groups
            else if (in_array($group, array(4, 5))) {
                $this->form_validation->set_rules('name', 'Name', 'required|alpha|trim');
            }
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $this->form_validation->set_rules('organization', 'Organization', 'trim');
                // only show to brand member group
                if (in_array($group, array(3))) {
                    $this->form_validation->set_rules('brand', 'Brand', 'trim');
                }
                if (strlen($this->input->post('phone'))) {
                    $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
                }
                $this->form_validation->set_rules('address1', 'Address 1', 'trim');
                $this->form_validation->set_rules('address2', 'Address 2', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                if (strlen($this->input->post('zipcode'))) {
                    $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
                }
            }
            $this->form_validation->set_rules('group', 'Group', 'required');


            if ($this->form_validation->run() == false) {

                $data['group'] = $group;

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                // set page title
                $data['title'] = ucwords('create user');

                $this->load->view('admin_panel/pages/users/create', $data);
            } else {

                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $additional_data['firstname'] = $this->input->post('firstname');
                    $additional_data['lastname'] = $this->input->post('lastname');
                }
                // only show to regular and premium user groups
                elseif (in_array($group, array(4, 5))) {
                    $additional_data['firstname'] = $this->input->post('name');
                }
                $additional_data['gender'] = $this->input->post('gender');
                $additional_data['age_group'] = $this->input->post('age_group');
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(3))) {
                    $additional_data['organization'] = $this->input->post('organization');
                    // only show to brand member group
                    if (in_array($group, array(3))) {
                        $additional_data['brand'] = $this->input->post('brand');
                    }
                    $additional_data['phone'] = $this->input->post('phone');
                    $additional_data['address1'] = $this->input->post('address1');
                    $additional_data['address2'] = $this->input->post('address2');
                    $additional_data['city'] = $this->input->post('city');
                    $additional_data['state'] = $this->input->post('state');
                    $additional_data['country'] = $this->input->post('country');
                    $additional_data['zipcode'] = $this->input->post('zipcode');
                }
                $additional_data['active'] = $this->input->post('active');

                $create = $this->User->create($username, $password, $email, $additional_data, $group);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect('admin/users/group/id/5');
            }
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
        if (!$this->ion_auth_acl->has_permission('users_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->User->delete($id);

            return $delete;
        }
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
        if ($this->ion_auth_acl->has_permission('users_get') or $this->ion_auth->is_admin()) {
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
    }

    /**
     * Get users by last name
     *
     * @param String $lastname Last nae of the user
     * @return object
     */
    public function get_by_lastname($lastname)
    {
        if ($this->ion_auth_acl->has_permission('users_get')) {
            $result = $this->User->get_by_lastname($lastname);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Show user list based on group
     *
     * @param int $group ID of the user group
     * @return void
     */
    public function index($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

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
            if (in_array($id, array(1, 2, 3))) {
                $this->load->view('admin_panel/pages/users/view_123', $data);
            } elseif (in_array($id, array(4, 5))) {
                $this->load->view('admin_panel/pages/users/view_45', $data);
            }
        }
    }

    /**
     * Change user permissions
     *
     * @param int $id ID of the user
     * @return void
     */
    public function permissions($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_toggle') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $group = $this->ion_auth->get_users_groups($id)->row()->id;

            $update = TRUE;

            if ($this->input->post()) {
                foreach ($this->input->post() as $k => $v) {
                    if (substr($k, 0, 5) == 'perm_') {
                        $permission_id  =   str_replace("perm_", "", $k);

                        if ($v == "X") {
                            if ($this->ion_auth_acl->remove_permission_from_user($id, $permission_id) === FALSE) {
                                $update = FALSE;
                            }
                        } else {
                            if ($this->ion_auth_acl->add_permission_to_user($id, $permission_id, $v) === FALSE) {
                                $update = FALSE;
                            }
                        }
                    }
                }

                if ($update) {
                    $this->session->set_flashdata('permission_success', 1);
                } else {
                    $this->session->set_flashdata('permission_success', 0);
                }

                redirect("admin/users/group/id/{$group}");
            } else {

                $user_groups    =   $this->ion_auth_acl->get_user_groups($id);

                $data['user_id']                =   $id;
                $data['group']                  =   $group;
                $data['permissions']            =   $this->ion_auth_acl->permissions('full', 'perm_key');
                $data['group_permissions']      =   $this->ion_auth_acl->get_group_permissions($user_groups);
                $data['users_permissions']      =   $this->ion_auth_acl->build_acl($id);

                // set page title
                $data['title'] = ucwords('User Permissions');

                $this->load->view('admin_panel/pages/users/permissions', $data);
            }
        }
    }

    /**
     * Reset user password
     *
     * @param int $id ID of the user
     * @return void
     */
    public function reset($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_reset') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            if (!$this->ion_auth_acl->has_permission('users_reset_password')) {
                // set page title
                $data['title'] = ucwords('access denied');
                $this->load->view('admin_panel/errors/error_403', $data);
            } else {

                $user = $this->ion_auth->where('id', $id)->users()->row();

                // run the forgotten password method to email an activation code to the user
                $forgotten = $this->ion_auth->forgotten_password($user->username);

                if ($forgotten) {
                    return true;
                } else {
                    return false;
                }
            }
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
        if (!$this->ion_auth_acl->has_permission('users_toggle') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
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
                echo json_encode(-2);
            }
        }
    }

    /**
     * Update user data
     *
     * @param int $id ID of the user
     * @return void
     */
    public function update($id)
    {

        if (!$this->ion_auth_acl->has_permission('users_edit') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            // get user group
            $group = $this->ion_auth->get_users_groups($id)->row()->id;

            $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check|alpha_numeric|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check|trim');
            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|trim');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|trim');
            }
            // only show to regular and premium user groups
            else if (in_array($group, array(4, 5))) {
                $this->form_validation->set_rules('name', 'Name', 'required|alpha|trim');
            }
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $this->form_validation->set_rules('organization', 'Organization', 'trim');
                // only show to brand member group
                if (in_array($group, array(3))) {
                    $this->form_validation->set_rules('brand', 'Brand', 'trim');
                }
                if (strlen($this->input->post('phone'))) {
                    $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
                }
                $this->form_validation->set_rules('address1', 'Address 1', 'trim');
                $this->form_validation->set_rules('address2', 'Address 2', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                if (strlen($this->input->post('zipcode'))) {
                    $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
                }
            }
            $this->form_validation->set_rules('group', 'Group', 'required');

            if ($this->form_validation->run() == false) {

                $user = $this->User->get($id);

                $data['id'] = $user->id;
                $data['username'] = $user->username;
                $data['email'] = $user->email;
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $data['firstname'] = $user->firstname;
                    $data['lastname'] = $user->lastname;
                }
                // only show to regular and premium user groups
                else if (in_array($group, array(4, 5))) {
                    $data['name'] = $user->firstname;
                }
                $data['gender'] = $user->gender;
                $data['age_group'] = $user->age_group;
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $data['organization'] = $user->organization;
                    // only show to brand member group
                    if (in_array($group, array(3))) {
                        $data['brand'] = $user->brand;
                    }
                    $data['phone'] = $user->phone;
                    $data['address1'] = $user->address1;
                    $data['address2'] = $user->address2;
                    $data['city'] = $user->city;
                    $data['state'] = $user->state;
                    $data['country'] = $user->country;
                    $data['zipcode'] = $user->zipcode;
                }
                $data['active'] = $user->active;
                $data['group'] = $this->ion_auth->get_users_groups($id)->row();

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();
                $data['groups'] = $this->Group->get();

                $data['title'] = ucwords('edit user');

                $this->load->view('admin_panel/pages/users/edit', $data);
            } else {
                $user_data['username'] = $this->input->post('username');
                $user_data['email'] = $this->input->post('email');
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $user_data['firstname'] = $this->input->post('firstname');
                    $user_data['lastname'] = $this->input->post('lastname');
                }
                // only show to regular and premium user groups
                elseif (in_array($group, array(4, 5))) {
                    $user_data['firstname'] = $this->input->post('name');
                }
                $user_data['gender'] = $this->input->post('gender');
                $user_data['age_group'] = $this->input->post('age_group');
                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $user_data['organization'] = $this->input->post('organization');
                    // only show to brand member group
                    if (in_array($group, array(3))) {
                        $user_data['brand'] = $this->input->post('brand');
                    }
                    $user_data['phone'] = $this->input->post('phone');
                    $user_data['address1'] = $this->input->post('address1');
                    $user_data['address2'] = $this->input->post('address2');
                    $user_data['city'] = $this->input->post('city');
                    $user_data['state'] = $this->input->post('state');
                    $user_data['country'] = $this->input->post('country');
                    $user_data['zipcode'] = $this->input->post('zipcode');
                }
                $user_data['group'] = $this->input->post('group');
                $user_data['active'] = $this->input->post('active');

                $update = $this->User->update($id, $user_data);
                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/users/group/id/{$group}");
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
        $id =  $this->input->post('id');

        if ($this->ion_auth->username_check($username)) {
            if ($this->User->get($id)->username !== $username) {
                $this->form_validation->set_message('username_check', 'The username already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }
}
