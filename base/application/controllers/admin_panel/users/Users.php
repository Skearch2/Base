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

        $this->load->model('admin_panel/brands/Brand_model', 'Brand');
        $this->load->model('admin_panel/users/User_model', 'User');
        $this->load->model('admin_panel/users/Group_model', 'Group');
        $this->load->model('admin_panel/users/Payment_model', 'User_payment');
        $this->load->model('Util_model', 'Util_model');
        $this->load->model('admin_panel/email/Template_model', 'Template_model');
        $this->load->model('admin_panel/email/Log_model', 'Log_model');
        $this->load->model('admin_panel/email/Marketing_emails_model');
    }


    /**
     * Manually activate the user, overriding email activation
     *
     * @param int $id ID of the user
     * @return void
     */
    public function activate($id)
    {
        if (!$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $data = array(
                'activation_selector' => null,
                'activation_code' => null,
                'activation_time' => null,
                'active' => 1
            );
            $update = $this->User->update($id, $data);

            if ($update) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
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
            $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[skearch_users.username]|callback_validate_username|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']', array('is_unique' => 'The %s is already taken'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if (in_array($group, array(1, 2, 3))) {
                // only for admin, editor, and brand member groups
                $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha');
                $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha');
            }

            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                if (strlen($this->input->post('phone'))) {
                    $this->form_validation->set_rules('phone', 'Phone', 'trim|required|callback_validate_phone');
                }
                $this->form_validation->set_rules('address1', 'Address 1', 'trim');
                $this->form_validation->set_rules('address2', 'Address 2', 'trim');
                $this->form_validation->set_rules('city', 'City', 'trim');
                if (strlen($this->input->post('state_other'))) {
                    $this->form_validation->set_rules('state_other', 'State/Province', 'trim|regex_match[/^([a-z ])+$/i]');
                }
                if (strlen($this->input->post('zipcode'))) {
                    $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
                }
                // only show to brand member group
                if (in_array($group, array(3))) {
                    $this->form_validation->set_rules('brand', 'Brand', 'required');
                }
            }
            // only show to staff groups
            if (in_array($group, array(1, 2))) {
                $this->form_validation->set_rules('group', 'Group', 'required');
            }

            if ($this->form_validation->run() == false) {

                if (in_array($group, array(3))) {
                    $data['brands'] = $this->Brand->get();
                }

                $data['group'] = $group;

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                // set page title
                $group_name =  $this->Group->get($group)->name;
                $data['title'] = ucwords("create {$group_name}");

                $this->load->view('admin_panel/pages/users/create', $data);
            } else {

                $username = $this->input->post('username');
                $password = base64_encode(random_bytes(10)); // random 14 characters
                $email = $this->input->post('email');

                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    $additional_data['firstname'] = $this->input->post('firstname');
                    $additional_data['lastname'] = $this->input->post('lastname');
                }
                $additional_data['gender'] = $this->input->post('gender');
                $additional_data['age_group'] = $this->input->post('age_group');

                // only show to admin, editor, and brand member groups
                if (in_array($group, array(1, 2, 3))) {
                    // $additional_data['organization'] = $this->input->post('organization');
                    $additional_data['phone'] = preg_replace("/[^0-9]/", "", $this->input->post('phone'));
                    $additional_data['address1'] = $this->input->post('address1');
                    $additional_data['address2'] = $this->input->post('address2');
                    $additional_data['city'] = $this->input->post('city');
                    $data['state'] = empty($this->input->post('state_us')) ? $this->input->post('state_other') : $this->input->post('state_us');
                    $additional_data['country'] = $this->input->post('country');
                    $additional_data['zipcode'] = $this->input->post('zipcode');
                }
                $additional_data['active'] = $this->input->post('active');

                $group = $this->input->post('group');

                // create user
                $create = $user_id = $this->User->create($username, $password, $email, $additional_data, array($group));

                if ($create) {
                    // link user to brand
                    if ($group == 3) {
                        $brand = $this->input->post('brand');
                        $is_key_member = $this->input->post('key_member');
                        $this->Brand->link_user($user_id, $brand, $is_key_member);
                    }

                    // add user email to email marketing list
                    $this->Marketing_emails_model->add([$email]);

                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/users/group/id/{$group}");
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

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Callback for email validation
     *
     * @param string $email Email of the user
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

                // for premium users add payment status
                if ($id == 4) {
                    for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                        $payment = $this->User_payment->get($result['aaData'][$i]->id);
                        if ($payment === FALSE) {
                            $result['aaData'][$i]->is_paid = 0;
                        } else {
                            $result['aaData'][$i]->is_paid = $payment->is_paid;
                        }
                    }
                }
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
     * @param string $lastname Last nae of the user
     * @return object
     */
    public function get_by_lastname($lastname)
    {
        if ($this->ion_auth_acl->has_permission('users_get') or $this->ion_auth->is_admin()) {
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
                $group = "Regular Users";
            }

            $data['group'] = $id;

            $data['title'] = $group;

            if (in_array($id, array(1, 2))) {
                $this->load->view('admin_panel/pages/users/view_staff', $data);
            } elseif ($id == 3) {
                $this->load->view('admin_panel/pages/users/view_brand', $data);
            } elseif ($id == 4) {
                $this->load->view('admin_panel/pages/users/view_premium', $data);
            } elseif ($id == 5) {
                $this->load->view('admin_panel/pages/users/view_regular', $data);
            } else {
                show_404();
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
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
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
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $user = $this->ion_auth->where('id', $id)->users()->row();

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($user->username);

            if ($forgotten) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
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
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
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
     * Toggle payment status of a user
     *
     * @param int $id ID of the user
     * @return void
     */
    public function toggle_payment($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_payment') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $status = $this->User_payment->get($id);

            // create payment data incase not already created for the user
            if ($status === FALSE) {
                $this->User_payment->create(array(
                    'user_id' => $id,
                    'is_paid' => 1
                ));

                echo json_encode(1);
            } else {

                $payment_data = array(
                    'is_paid' => 1,
                );

                $update = $this->User_payment->update($id, $payment_data);

                if ($update) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
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
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            // get user group
            $group = $this->ion_auth->get_users_groups($id)->row()->id;

            $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_validate_username|callback_username_check|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha');
                $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha');
            }
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');

            // only show to admin, editor, and brand member groups
            if (in_array($group, array(1, 2, 3))) {
                // $this->form_validation->set_rules('organization', 'Organization', 'trim');
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
                // only show to brand member group
                if (in_array($group, array(3))) {
                    $this->form_validation->set_rules('brand', 'Brand', 'required');
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
                    // $data['organization'] = $user->organization;
                    $data['phone'] = $user->phone;
                    $data['address1'] = $user->address1;
                    $data['address2'] = $user->address2;
                    $data['city'] = $user->city;
                    $data['state'] = $user->state;
                    $data['country'] = $user->country;
                    $data['zipcode'] = $user->zipcode;
                }
                $data['activated'] = $user->activation_selector ? 0 : 1;
                $data['active'] = $user->active;
                $data['group'] = $this->ion_auth->get_users_groups($id)->row();

                if (in_array($group, array(3))) {
                    $data['brand'] = $this->Brand->get_by_user($id);
                    $data['brands'] = $this->Brand->get();
                }

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                $group_name =  $this->Group->get($group)->name;
                $data['title'] = ucwords("edit {$group_name}");

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
                    // $user_data['organization'] = $this->input->post('organization');
                    $user_data['phone'] = preg_replace("/[^0-9]/", "", $this->input->post('phone'));
                    $user_data['address1'] = $this->input->post('address1');
                    $user_data['address2'] = $this->input->post('address2');
                    $user_data['city'] = $this->input->post('city');
                    $user_data['state'] = empty($this->input->post('state_us')) ? $this->input->post('state_other') : $this->input->post('state_us');
                    $user_data['country'] = $this->input->post('country');
                    $user_data['zipcode'] = $this->input->post('zipcode');
                }
                $user_data['group'] = $this->input->post('group');
                $user_data['active'] = $this->input->post('active');

                // update user
                $update = $this->User->update($id, $user_data);

                // link user to brand
                if ($group == 3) {
                    $brand = $this->input->post('brand');
                    $is_key_member = $this->input->post('key_member');
                    $this->Brand->link_user($id, $brand, $is_key_member);
                }

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
     * Upgrade user to premium
     *
     * @param int $id ID of the user
     * @return void
     */
    public function upgrade($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_upgrade') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            // add user to premium user group
            if ($this->User->get($id)->active && $this->ion_auth->remove_from_group(NULL, $id) && $this->ion_auth->add_to_group($this->config->item('premium', 'ion_auth'), $id)) {

                $template = $this->Template_model->get_template('welcome_premium');

                $user = $this->User->get($id);

                $data = array(
                    'username' => $user->username
                );

                $message = $this->parser->parse_string($template->body, $data);

                $this->email->clear();
                $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($user->email);
                $this->email->subject($template->subject);
                $this->email->message($message);

                // log email if sent
                if ($this->email->send()) {
                    $this->Log_model->create(array(
                        'type' => 'Welcome Upgrade',
                        'user_id' => $id
                    ));
                }

                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Callback for username validation
     *
     * @param string $username Username of the user
     * @return void
     */
    public function username_check($username)
    {
        $id =  $this->input->post('id');

        if ($this->ion_auth->username_check($username)) {
            if ($this->User->get($id)->username !== $username) {
                $this->form_validation->set_message('username_check', 'The %s already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }

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
