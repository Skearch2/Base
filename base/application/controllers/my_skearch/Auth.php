<?php

/**
 * File: ~/application/controller/my_skearch/Auth.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * An authetication controller for MySkearch
 *
 * Allows users to login, register and signup to MySkearch
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 20z1 Skearch LLC
 */

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('my_skearch/User_model', 'User');
        $this->load->model('Util_model', 'Util');
        $this->load->model('admin_panel/email/Template_model', 'Email_templates');
        $this->load->model('admin_panel/Settings_model', 'Settings');
        $this->load->model('admin_panel/email/Marketing_emails_model');
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

            // add user email to email marketing list
            $this->Marketing_emails_model->add([$user->email]);

            // select welcome email based on type of account
            if ($this->ion_auth->in_group($this->config->item('regular', 'ion_auth'), $id)) {
                $data = array(
                    'username' => $user->username
                );
                $template = $this->Email_templates->get_template('welcome_regular');
            } else if ($this->ion_auth->in_group($this->config->item('premium', 'ion_auth'), $id)) {
                $data = array(
                    'username' => $user->username
                );
                $template = $this->Email_templates->get_template('welcome_premium');
            } else {
                $data = array(
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname
                );
                $template = $this->Email_templates->get_template('welcome_brand');
            }

            $message = $this->parser->parse_string($template->body, $data);

            $this->email->clear();
            $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($user->email);
            $this->email->subject($template->subject);
            $this->email->message($message);
            $this->email->send();

            // log email if sent
            if ($this->email->send()) {
                log_email($id, "Welcome", $template->subject, $message);
            }

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
     * Let user set account password to activate their account
     * 
     * (Note: The account would have already been made for the user by the staff)
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function set_password_activate($id, $code)
    {
        $user = $this->ion_auth->get_user_by_activation_code($code);

        // invalid code
        if (!$user or $id !== $user->id) {
            show_404();
            return;
        }

        // // if the user is already active redirect to login page
        // elseif ($user->active == 1) {
        //     // redirect to the login page
        //     $this->session->set_flashdata('message', $this->ion_auth->errors());
        //     redirect("myskearch/auth/login");
        //     return;
        // }

        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
        $this->form_validation->set_rules('password2', 'Confirm New Password', 'required|matches[password]');

        $user = $this->ion_auth->user($id)->row();

        if ($this->form_validation->run() === false) {

            $data['user_id'] = $user->id;

            $data['title'] = "MySkearch" + ucwords(" | set password");
            $this->load->view('auth/pages/set_password', $data);
        } else {
            $id = $user->id;
            $identity = $user->username;

            $set = $this->ion_auth->reset_password($identity, $this->input->post('password'));
            // once the account password is set
            if ($set) {
                // activate user account
                if ($this->ion_auth->activate($id, $code)) {

                    // generate default user settings
                    $this->_create_settings($id);

                    // select welcome email based on type of account
                    if ($this->ion_auth->in_group($this->config->item('regular', 'ion_auth'), $id)) {
                        $data = array(
                            'username' => $user->username
                        );
                        $template = $this->Email_templates->get_template('welcome_regular');
                    } else if ($this->ion_auth->in_group($this->config->item('premium', 'ion_auth'), $id)) {
                        $data = array(
                            'username' => $user->username
                        );
                        $template = $this->Email_templates->get_template('welcome_premium');
                    } else {
                        $data = array(
                            'firstname' => $user->firstname,
                            'lastname' => $user->lastname
                        );
                        $template = $this->Email_templates->get_template('welcome_brand');
                    }

                    $message = $this->parser->parse_string($template->body, $data);

                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($user->email);
                    $this->email->subject($template->subject);
                    $this->email->message($message);

                    // log email if sent
                    if ($this->email->send()) {
                        log_email($id, "Welcome", $template->subject, $message);
                    } else {
                        log_message('error', 'Unable to send email');
                    }

                    // redirect them to the login page
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                    redirect("myskearch/auth/login");
                } else {
                    // redirect them to the login page
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect("myskearch/auth/login");
                }
            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect("myskearch/auth/activate/action/delegate/id/$id/code/$code");
            }
        }
    }

    /**
     * Search for the brand
     *
     * @param string $brand Brand name
     * @return object
     */
    public function brand_search($brand)
    {
        $this->load->model('admin_panel/brands/brand_model', 'Brand');

        $result = $this->Brand->get_by_name($brand);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Allow member to change email
     */
    public function change_email()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login');
        }

        $this->form_validation->set_rules('new_email', 'New Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('new_email2', 'Confirm Email Address', 'trim|required|matches[new_email]');
        $this->form_validation->set_rules('current_password', 'Password', 'required');

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === false) {

            $data['skearch_id'] = $user->id;
            $data['csrf'] = $this->_get_csrf_nonce();

            $data['title'] = ucwords("MySkearch | change email address");
            $this->load->view('auth/pages/change_email', $data);
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
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|matches[new_password]');

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === false) {

            $data['skearch_id'] = $user->id;
            $data['csrf'] = $this->_get_csrf_nonce();

            $data['title'] = ucwords("MySkearch | change password");
            $this->load->view('auth/pages/change_password', $data);
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
        $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'trim|required');

        if ($this->form_validation->run() === false) {
            $data['title'] = ucwords("MySkearch | forgot password");
            $this->load->view('auth/pages/forgot_password', $data);
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
     *  Generate captcha
     */
    public function generate_captcha()
    {
        // settings for captcha
        $vals = array(
            'img_path'      => $this->config->item('captcha_img_path'),
            'img_url'       => $this->config->item('captcha_img_url'),
            'expiration'    => $this->config->item('captcha_expiration')
        );

        $cap = create_captcha($vals);

        $data = array(
            'captcha_time'  => $cap['time'],
            'ip_address'    => $this->input->ip_address(),
            'word'          => $cap['word']
        );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        $id = $this->db->insert_id();
        $query = $this->db->get_where('captcha', array('captcha_id' => $id));

        $captcha = $query->row();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($captcha->word));
    }

    /**
     * Allow user to login to MySkearch
     */
    public function login()
    {
        if ($this->ion_auth->logged_in()) {
            redirect('myskearch/dashboard', 'refresh');
        }

        $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === false) {
            // set page title
            $data['title'] = ucwords("MySkearch  | login");
            $this->load->view('auth/pages/login', $data);
        } else {
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('skearch_id'), $this->input->post('password'), $remember)) {

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
     * Allow member to logout from MySkearch
     */
    public function logout()
    {
        if ($this->ion_auth->logged_in()) {
            $this->ion_auth->logout();
            $this->ion_auth->logout();
            $this->session->set_flashdata('success', 'You have successfully logged out.');
        }

        redirect('myskearch/auth/login');
    }

    /**
     * Payment page for Brands to pay
     */
    // public function payment($approved = 0)
    // {
    //     if ($approved && $this->input->get('transaction_id')) {
    //         $this->load->model('admin_panel/brands/payments_model', 'Payments');
    //         $this->load->model('admin_panel/brands/brand_model', 'Brand');

    //         $brand = $this->input->get('brand');

    //         // transaction details
    //         $reference_id   = strtoupper(bin2hex(random_bytes(6))); // create random string of length 12
    //         $service        = $this->input->get('service');
    //         $transaction_id = $this->input->get('transaction_id');
    //         $payment_type   = $this->input->get('payment_type');
    //         $amount         = $this->input->get('amount');
    //         $payment_date   = $this->input->get('payment_date');

    //         // get the id and details of the lead member of the brand
    //         // $id = $this->Brand->get_members($this->input->get('brand_id'), 1)[0]->id;
    //         // $user = $this->ion_auth->user($id)->row();

    //         // email template
    //         $template = $this->Email_templates->get_template('brand_payment_confirmation');

    //         // data used in email body
    //         $data = array(
    //             'brand'          => $brand,
    //             'reference_id'   => $reference_id,
    //             'service'        => $service,
    //             'transaction_id' => $transaction_id,
    //             'payment_type'   => $payment_type,
    //             'amount'         => $amount,
    //             'payment_date'   => $payment_date
    //         );

    //         $message = $this->parser->parse_string($template->body, $data, TRUE);

    //         // send email regarding payment confirmation
    //         // $this->email->clear();
    //         // $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
    //         // $this->email->to($user->email);
    //         // $this->email->subject($template->subject);
    //         // $this->email->message($message);

    //         // if ($this->email->send()) {
    //         //     // log email
    //         //     $this->Log_model->create(array(
    //         //         'type' => 'Payment Confirmation',
    //         //         'user_id' => $user->id
    //         //     ));
    //         // }

    //         // create a brand by the name given during payment
    //         $brand_id = $this->Brand->create(array(
    //             'brand' => $brand
    //         ));

    //         $transaction_data = array(
    //             'id'             => $reference_id,
    //             'brand_id'       => $brand_id,
    //             'service'        => $service,
    //             'transaction_id' => $transaction_id,
    //             'payment_type'   => $payment_type,
    //             'amount'         => $amount,
    //             'payment_date'   => $payment_date
    //         );

    //         $create = $this->Payments->create($transaction_data);

    //         if ($create) {
    //             echo json_encode(1);
    //         } else {
    //             echo json_encode(0);
    //         }
    //     } else {
    //         $data['title'] = ucwords("MySkearch | make payment");
    //         $this->load->view('auth/pages/payment', $data);
    //     }
    // }

    /**
     * Set new password for MySkearch member
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = null)
    {
        if (!$code) {
            show_404();
            return;
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

                $data['title'] = ucwords("MySkearch | reset password");
                $this->load->view('auth/pages/reset_password', $data);
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
     * Allow user or brand to signup
     */
    public function signup()
    {
        if ($this->ion_auth->logged_in()) {
            redirect('myskearch/dashboard', 'refresh');
        }

        // check if it is a brand signup
        $is_brand_signup = (null !== $this->input->post("is_brand_signup")) ? $this->input->post("is_brand_signup") : 1;

        // check if the user is signing up for the premium user
        $is_premium_user_signup = (null !== $this->input->post("is_premium_user_signup")) ? $this->input->post("is_premium_user_signup") : 0;

        if (!empty($is_brand_signup) && $is_brand_signup == 1) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('brandname', 'Brand Name', 'trim|required|is_unique[skearch_brand_leads.brandname]');
            $this->form_validation->set_rules('email_b', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|callback_validate_phone');
        } else {
            $this->form_validation->set_rules('skearch_id', 'Skearch ID', 'trim|required|callback_validate_username|is_unique[skearch_users.username]|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']', array('is_unique' => 'The Skearch ID or username already exists.'));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            // $this->form_validation->set_rules('gender', 'Gender', 'required');
            // $this->form_validation->set_rules('age_group', 'Age group', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required|matches[password]');
        }
        $this->form_validation->set_rules(
            'agree',
            'Terms and Conditions',
            'required',
            array('required' => 'You must agree with the terms and conditions.')
        );
        $this->form_validation->set_rules('captcha', 'Security Verification', 'trim|required|callback_validate_captcha');

        if ($this->form_validation->run() === false) {

            $data['is_brand_signup'] = $is_brand_signup;
            $data['states'] = $this->Util->get_state_list();
            $data['countries'] = $this->Util->get_country_list();

            $data['title'] = ucwords('MySkearch  | sign up');
            $this->load->view('auth/pages/register', $data);
        } else {
            // verify captcha
            $expiration = time() - $this->config->item('captcha_expiration');
            $this->db->where('captcha_time < ', $expiration)
                ->delete('captcha');

            $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
            $binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);
            $query = $this->db->query($sql, $binds);
            $row = $query->row();

            // if captcha is valid
            if ($row->count > 0) {
                // if brand sign up
                if ($is_brand_signup) {

                    $name      = $this->input->post('name');
                    $brandname = $this->input->post('brandname');
                    $email     = $this->input->post('email_b');
                    $phone     = preg_replace("/[^0-9]/", "", $this->input->post('phone'));

                    $data = array(
                        'name'      => $name,
                        'brandname' => $brandname,
                        'email'     => $email,
                        'phone'     => $phone
                    );

                    $lead = $this->User->create_lead($data);

                    if ($lead) {

                        // Email confirnmation to the lead
                        $data = array(
                            'name' => $name
                        );
                        $template = $this->Email_templates->get_template('brand_signup_confirmation');

                        $message = $this->parser->parse_string($template->body, $data);

                        $this->email->clear();
                        $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($this->input->post('email_b'));
                        $this->email->subject($template->subject);
                        $this->email->message($message);

                        // log email if sent
                        if ($this->email->send()) {
                            // TODO: need to make a log for brand signup which does not correspond to any user id
                            //log_email(3, "Brand Signup", $template->subject, $message);
                        } else {
                            $this->email->print_debugger();
                            log_message('error', 'Unable to send email to the brand lead.');
                        }

                        // Email notification to the admin about brand lead sign up
                        $data = array(
                            'name'      => $name,
                            'brandname' => $brandname,
                            'email'     => $email,
                            'phone'     => $phone
                        );
                        $template = $this->Email_templates->get_template('brand_lead_notification');

                        $message = $this->parser->parse_string($template->body, $data);

                        $admin_email = $this->Settings->get()->admin_email;

                        $this->email->clear();
                        $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                        $this->email->to($admin_email);
                        $this->email->subject($template->subject);
                        $this->email->message($message);

                        // log email if sent
                        if ($this->email->send()) {
                            // email should be logged
                        } else {
                            $this->email->print_debugger();
                            log_message('error', 'Unable to send email to the brand lead.');
                        }

                        $this->session->set_flashdata('signup_success', true);
                        $this->session->set_flashdata('success', 'Thank You for your inquiry! Someone from Skearch will be contacting you soon.');
                        redirect('myskearch/auth/signup');
                    } else {
                        $this->session->set_flashdata('error', 'Unable to signup for the brand, please try again!');
                        redirect('myskearch/auth/signup');
                    }
                }
                // User sign up
                else {
                    // user data
                    $username = $this->input->post('skearch_id');
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
                    $additional_data = array(
                        // 'gender'    => $this->input->post('gender'),
                        // 'age_group' => $this->input->post('age_group')
                    );
                    $group = ($is_premium_user_signup) ? $this->config->item('premium', 'ion_auth') : $this->config->item('regular', 'ion_auth');

                    // create user
                    $user = $this->User->create($username, $password, $email, $additional_data, array($group));

                    if ($user) {
                        $this->session->set_flashdata('signup_success', true);
                        $this->session->set_flashdata('success', 'An email has been sent to you for your new account activation.');
                        redirect('myskearch/auth/signup');
                    } else {
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect('myskearch/auth/signup');
                    }
                }
            } else {
                $this->session->set_flashdata('error', "Unable to complete security validation. Please try again!");
                redirect('myskearch/auth/signup');
            }
        }
    }

    /**
     * Unsubscribe email from marketing list
     */
    public function unsubscribe_email()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() === false) {
            $data['title'] = ucwords("MySkearch | unsubscribe newsletter");
            $this->load->view('auth/pages/unsubscribe_email', $data);
        } else {
            $is_unsubscribed = $this->User->unsubsribe_user_email($this->input->post('email'));

            if ($is_unsubscribed) {
                $subject = "Skearch - Unsubscribe Newsletter Confirmation";
                $content = "Your email has been successfully unsubscribed from our email newslett$er.";

                $this->email->clear();
                $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($this->input->post('email'));
                $this->email->subject($subject);
                $this->email->message($content);
                $this->email->send();

                $this->session->set_flashdata('success', 'Your email has been successfully unsubscribed.');
            } else {
                $this->session->set_flashdata('error', 'Unable to unsubsribe email, some error occurred.');
            }
            redirect("myskearch/auth/unsubscribe/email");
        }
    }

    /**
     * Validates TOS/PP Acknowlegement
     *
     * @return bool
     */
    public function validate_tos_ack()
    {
        if ($this->input->post('tos_pp_accept_chk')) {
            $user_id = $this->ion_auth->user()->row()->id;
            $this->User->create_tos_ack_entry($user_id);

            redirect('myskearch');
        }
    }

    /**
     * Validates Captcha
     *
     * @return bool
     */
    public function validate_captcha($captcha)
    {
        if (null !== $captcha) {
            return true;
        } else {
            $this->form_validation->set_message('validate_captcha', 'Security verification is required.');
            return false;
        }
    }

    /**
     * Validates US phone numnber
     *
     * @return bool
     */
    public function validate_phone($phone)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);

        if (!empty($phone) && strlen($phone) != 10) {
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
