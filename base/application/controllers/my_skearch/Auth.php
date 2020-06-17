<?php

/**
 * File: ~/application/controller/my_skearch/Auth.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * An authetication controller for My Skearch
 *
 * Allows users to login, register and signup to My Skearch
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018 Skearch LLC
 */

class Auth extends MY_Controller
{

    /**
     * Loads the User model needed for the class function
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('my_skearch/User_model', 'User');
        $this->load->model('Util_model', 'Util');
    }

    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = false)
    {
        $activation = false;
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }
        if ($activation) {

            // generate default user settings
            $this->_create_settings($id);

            // User
            $user = $this->ion_auth->user($id)->row();

            // email template
            $template = $this->Template_model->get_template('welcome');

            $data = array(
                'firstname' => $user->firstname,
                'lastname' => $user->lastname
            );

            $message = $this->parser->parse_string($template->body, $data);

            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($user->email);
            $this->email->subject($template->subject);
            $this->email->message($message);
            $this->email->send();

            // log email
            $this->Log_model->create(array(
                'type' => 'Welcome',
                'user_id' => $id
            ));

            // redirect them to the auth page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            redirect("myskearch/auth/login");
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("myskearch/auth/forgot_password");
        }
    }

    /**
     * Allow member to change email
     */
    public function change_email()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login');
        }

        $this->form_validation->set_rules('new_email', 'New Email Address', 'required|valid_email|trim');
        $this->form_validation->set_rules('new_email2', 'Confirm Email Address', 'required|trim|matches[new_email]');
        $this->form_validation->set_rules('current_password', 'Password', 'required');

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === false) {

            $data['skearch_id'] = $user->id;
            $data['csrf'] = $this->_get_csrf_nonce();

            $data['title'] = ucwords("my skearch | change email address");
            $this->load->view('my_skearch/pages/change_email', $data);
        } else {

            if ($this->_valid_csrf_nonce() === false or $user->id !== $this->input->post('skearch_id')) {
                show_error($this->lang->line('error_csrf'));
            } else {

                $email = $this->input->post('new_email');

                if (!$this->ion_auth->email_check($email)) {
                    $password = $this->input->post('current_password');

                    if ($this->ion_auth->verify_password($password, $user->password)) {

                        $data = array(
                            'email' => $email,
                        );
                        $update = $this->ion_auth->update($user->id, $data);

                        if ($update) {
                            $this->session->set_flashdata('success', 'Email change successful');
                            redirect('myskearch/profile');
                        } else {
                            $this->session->set_flashdata('error', 'Unable to change email');
                            redirect('myskearch/profile');
                        }

                        $this->session->set_flashdata('success', 'Email change successful');
                        redirect('myskearch/profile');
                    } else {
                        $this->session->set_flashdata('error', 'Invalid Password');
                        redirect('myskearch/auth/change_email');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Email already exists');
                    redirect('myskearch/auth/change_email');
                }
            }
        }
    }

    /**
     * Allow member to change password
     */
    public function change_password()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login');
        }

        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|matches[new_password]');

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === false) {

            $data['skearch_id'] = $user->id;
            $data['csrf'] = $this->_get_csrf_nonce();

            $data['title'] = ucwords("my skearch | change password");
            $this->load->view('my_skearch/pages/change_password', $data);
        } else {

            $user_id = $this->session->userdata('id');
            $identity = $this->session->userdata('username');

            if ($this->_valid_csrf_nonce() === false or $user_id !== $this->input->post('skearch_id')) {
                show_error($this->lang->line('error_csrf'));
            } else {

                $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));
                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                    redirect('myskearch/profile');
                } else {
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect('myskearch/auth/change_password');
                }
            }
        }
    }

    /**
     * Send member an email with a reset password link
     */
    public function forgot_password()
    {

        $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'required');

        if ($this->form_validation->run() === false) {
            $data['title'] = ucwords("my skearch | forgot password");
            $this->load->view('my_skearch/pages/forgot_password', $data);
        } else {
            $identity = $this->ion_auth->where('username', $this->input->post('skearch_id'))->users()->row();

            if (empty($identity)) {
                $this->session->set_flashdata('alert', "Skearch ID not found.");
                redirect("myskearch/auth/forgot_password");
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->username);

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect("myskearch/auth/login");
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect("myskearch/auth/forgot_password");
            }
        }
    }

    /**
     * Allow user to login to My Skearch
     */
    public function login()
    {

        if ($this->ion_auth->logged_in()) {
            redirect('myskearch/dashboard', 'refresh');
        }

        $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            // set page title
            $data['title'] = ucwords("my skearch  | login");
            $this->load->view('my_skearch/pages/login', $data);
        } else {
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('skearch_id'), $this->input->post('password'), $remember)) {

                // add user group in the user information
                // $user['groupid'] =  $this->ion_auth->get_users_groups($user_id)->row()->id;
                // $user['group'] =  $this->ion_auth->get_users_groups($user_id)->row()->name;

                // user personalized settings
                $user['settings'] = $this->User->get_settings($this->session->userdata('user_id'));

                // add user data to session
                $this->session->set_userdata($user);

                redirect();
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('myskearch/auth/login');
            }
        }
    }

    /**
     * Allow member to logout from My Skearch
     */
    public function logout()
    {
        if ($this->ion_auth->logged_in()) {
            $this->ion_auth->logout();
            $this->session->set_flashdata('success', 'You have successfully logged out.');
        }

        redirect('myskearch/auth/login');
    }

    /**
     * Set new password for My Skearch member
     *
     * @param string|null $code The resset code
     */
    public function reset_password($code = null)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() === false) {
                $data['skearch_id'] = $user->id;

                $data['csrf'] = $this->_get_csrf_nonce();
                $data['code'] = $code;

                $data['title'] = ucwords("my skearch | reset password");
                $this->load->view('my_skearch/pages/reset_password', $data);
            } else {
                $identity = $user->username;
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === false or $user->id !== $this->input->post('skearch_id')) {
                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);
                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('password'));
                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('success', $this->ion_auth->messages());
                        redirect("myskearch/auth/login");
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect('myskearch/auth/reset_password/' . $code);
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("myskearch/auth/forgot_password", 'refresh');
        }
    }

    /**
     * Allow user to signup to My Skearch
     */
    public function signup()
    {

        if ($this->ion_auth->logged_in()) {
            redirect('myskearch/dashboard', 'refresh');
        }

        // check if user is signing up as regular user
        $is_regular = (null !== $this->input->post("is_regular_signup")) ?  $this->input->post("is_regular_signup") : 1;

        if (!empty($is_regular) && $is_regular == 1) {
            $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'trim|required|is_unique[skearch_users.username]|alpha_numeric|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']', array('is_unique' => 'The Skearch ID or username already exists.'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[skearch_users.email]');
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules(
                'agree',
                'Terms and Conditions',
                'required',
                array('required' => 'You must agree with the terms and conditions.')
            );
        } else {
            $this->form_validation->set_rules('name_b', 'Name', 'trim|required|callback_alpha_dash_space');
            $this->form_validation->set_rules('brandname', 'Brand Name', 'trim|required|is_unique[skearch_brand_leads.brandname]');
            $this->form_validation->set_rules('email_b', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|exact_length[10]');
        }

        if ($this->form_validation->run() === false) {

            $data['is_regular'] = $is_regular;
            $data['states'] = $this->Util->get_state_list();
            $data['countries'] = $this->Util->get_country_list();

            $data['title'] = ucwords('my skearch  | sign up');
            $this->load->view('my_skearch/pages/register', $data);
        } else {
            if ($this->User->create($is_regular)) {
                if ($is_regular) {
                    $this->session->set_flashdata('success', 'An email has been sent to you for account activation.');
                } else {
                    $this->session->set_flashdata('success', 'Thank You for your inquiry! Someone from Skearch will be contacting you soon.');
                }

                redirect('myskearch/auth/login');
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('myskearch/auth/signup');
            }
        }
    }


    /**
     * Validate if the string has alpha and spaces only
     *
     * @param string $string String
     * @return void
     */
    function alpha_dash_space($string)
    {
        if (empty($string)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field is required.');
        } else if (!preg_match('/^[a-zA-Z\s]+$/', $string)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & white spaces.');
        } else {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Create user settings with default values
     *
     * @param int $id ID of the user
     * @return void
     */
    private function _create_settings($id)
    {
        $data = array(
            'user_id' => $id,
            'search_engine' => 'duckduckgo',
            'theme' => 'light'
        );
        $this->db->insert('skearch_users_settings', $data);
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
