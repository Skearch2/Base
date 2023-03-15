<?php

/**
 * File: ~/application/controller/admin_panel/Email.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Allows moderators to send emails to members and invite people.
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */
class Email extends MY_Controller
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

        $this->load->model('admin_panel/users/User_model', 'Users');
        $this->load->model('admin_panel/email/Log_model', 'Email_Logs');
        $this->load->model('admin_panel/email/Invite_log_model');
        $this->load->model('admin_panel/email/Marketing_emails_model');

        $this->email->initialize($this->config->item('email_config', 'ion_auth'));
    }

    /**
     * Validate emails in a string
     *
     * @param string $sString
     * @return boolean
     */
    function email_check($sString)
    {
        $sEmailAddresses = preg_split("/; |;/", $sString);
        foreach ($sEmailAddresses as $sEmailAddress) {
            $bValid = filter_var($sEmailAddress, FILTER_VALIDATE_EMAIL);
        }

        if (!$bValid) {
            $this->form_validation->set_message('email_check', 'One or more email addresses are incorrect.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Get all emails sent to the user
     * @param int $user_id User ID
     *
     * @return void
     */
    public function get_logs($user_id)
    {
        if ($this->ion_auth_acl->has_permission('emails_logs') or $this->ion_auth->is_admin()) {
            $emails = $this->Email_Logs->get($user_id);
            $total_emails = count($emails);
            $result = array(
                'iTotalRecords' => $total_emails,
                'iTotalDisplayRecords' => $total_emails,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $emails,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get all invite emails
     *
     * @return void
     */
    public function get_invite_logs()
    {
        if ($this->ion_auth_acl->has_permission('emails_logs') or $this->ion_auth->is_admin()) {
            $emails = $this->Invite_log_model->get();
            $total_emails = count($emails);
            $result = array(
                'iTotalRecords' => $total_emails,
                'iTotalDisplayRecords' => $total_emails,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $emails,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }


    /**
     * Send invitation to email recipents
     *
     * @return void
     */
    public function invite()
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('recipents[]', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('content', 'Body', 'required|min_length[5]|max_length[1000]');

            if ($this->form_validation->run() === FALSE) {

                $data['title'] = ucwords("Email Invite");
                $this->load->view('admin_panel/pages/email/invite', $data);
            } else {
                $recipents = implode(', ', $this->input->post('recipents'));
                $subject = $this->input->post('subject');
                $content = $this->input->post('content');

                $this->email->from('no-reply@skearch.com', 'Skearch');
                $this->email->to('no-reply@skearch.com');
                $this->email->bcc($recipents);
                $this->email->subject($subject);
                $this->email->message($content);

                if ($this->email->send()) {
                    $email_data = array();

                    $emails = explode(', ', $recipents);
                    foreach ($emails as $i => $email) {
                        $email_data[$i] = array(
                            'email' => $email,
                            'subject' => $subject,
                            'body' => $content,
                            'attachment' => NULL,
                            'timestamp' => date("Y-m-d H:i:s")
                        );
                    }

                    $this->Invite_log_model->create($email_data);

                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
                $this->email->clear();
                redirect('admin/email/invite');
            }
        }
    }

    /**
     * Clear email logs of the user
     * @param boolean $user_id User ID
     * 
     * @return void
     */
    public function clear_logs($user_id)
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $clear = $this->Email_Logs->delete($user_id);

            if ($clear) {
                $this->session->set_flashdata('clear_success', 1);
            } else {
                $this->session->set_flashdata('clear_success', 0);
            }

            redirect("admin/email/logs/get/user/id/$user_id");
        }
    }

    /**
     * View email logs page
     * @param boolean $user_id User ID
     * 
     * @return void
     */
    public function logs($user_id)
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['user_id'] = $user_id;

            $data['title'] = ucwords("Email Logs");
            $this->load->view('admin_panel/pages/email/logs', $data);
        }
    }

    /**
     * View invite email logs page
     * @return void
     */
    public function invite_logs()
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("Email Invite Logs");
            $this->load->view('admin_panel/pages/email/invite_logs', $data);
        }
    }

    /**
     * Send email message to Skearch members
     *
     * @return void
     */
    public function message()
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            // check if custom email
            $email_custom = (null !== $this->input->post("email-custom")) ? $this->input->post("email-custom") : false;

            if ($email_custom) {
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            }
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('content', 'Body', 'required|min_length[5]');

            if ($this->form_validation->run() == FALSE) {

                $data['email_custom'] = $email_custom;
                $data['title'] = ucwords("Email Members");

                $this->load->view('admin_panel/pages/email/message', $data);
            } else {

                $subject = $this->input->post('subject');
                $content = $this->input->post('content');

                $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));

                if ($email_custom) {
                    $recipent = $this->input->post('email');
                    $recipent_id = $this->input->post('user_id');
                    $this->email->to($recipent);
                } else {
                    $users = $this->Users->get_active_users();
                    foreach ($users as $user) {
                        $recipents[] = $user->email;
                    }
                    $recipents = implode(', ', $recipents);

                    $this->email->to($this->config->item('default_email', 'ion_auth'));
                    $this->email->bcc($recipents);
                }
                $this->email->subject($subject);
                $this->email->message($content);

                if ($this->email->send()) {
                    // log email
                    if (!isset($users)) {
                        log_email($recipent_id, "Custom Message", $subject, $content);
                    } else {
                        foreach ($users as $user) {
                            log_email($user->id, "Custom Message", $subject, $content);
                        }
                    }
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
                $this->email->clear();
                redirect('admin/email/message');
            }
        }
    }

    /**
     * View or edit email templates
     *
     * @param String $type Name of the template
     * @return void
     */
    public function templates($type)
    {
        if (!$this->ion_auth_acl->has_permission('email_templates') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('body', 'Body', 'required|min_length[5]');

            if ($this->form_validation->run() === FALSE) {
                $query = $this->Template_model->get_template($type);

                if ($query) {

                    $data = array(
                        'subject' => $query->subject,
                        'body'    => $query->body
                    );

                    $data['title'] = ucwords("Email Template - " . ucwords(str_replace('_', ' ', $type)));

                    $this->load->view('admin_panel/pages/email/templates', $data);
                } else {
                    show_error("Database Error", 500);
                }
            } else {
                if ($this->Template_model->update_template($type)) {
                    $this->session->set_flashdata('success', 1);
                    redirect("admin/email/templates/$type");
                } else {
                    $this->session->set_flashdata('success', 0);
                    redirect("admin/email/templates/$type");
                }
            }
        }
    }

    /**
     * View email snapshot that was sent
     * @param boolean $id Email ID
     * 
     * @return void
     */
    public function view($id)
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['email'] = $this->Email_Logs->get_email($id);

            $data['title'] = ucwords("Email Snapshot");
            $this->load->view('admin_panel/pages/email/view', $data);
        }
    }

    /**
     * View email snapshot that was sent
     * @param boolean $id Email ID
     * 
     * @return void
     */
    public function view_invite($id)
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['email'] = $this->Invite_log_model->get_email($id);

            $data['title'] = ucwords("Email Snapshot");
            $this->load->view('admin_panel/pages/email/view', $data);
        }
    }

    /**
     * View list of emails for marketing
     * 
     * @return void
     */
    public function get_marketing_emails($page = false)
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            // view page
            if ($page ==  true) {
                $data['title'] = ucwords("master email list");
                $this->load->view('admin_panel/pages/email/view_marketing_emails', $data);
            } else {
                // data for view page
                $emails = $this->Marketing_emails_model->get();
                $total_emails = count($emails);
                $result = array(
                    'iTotalRecords' => $total_emails,
                    'iTotalDisplayRecords' => $total_emails,
                    'sEcho' => 0,
                    'sColumns' => "",
                    'aaData' => $emails,
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
        }
    }

    /**
     * Add marketing emails to master email list
     * 
     * @return void
     */
    public function add_marketing_emails()
    {
        if ($this->ion_auth_acl->has_permission('email') || $this->ion_auth->is_admin()) {
            if (empty($this->input->get('emails'))) {
                echo json_encode(0);
                return;
            }

            $email_array = preg_split("/\r\n|\n|\r/", $this->input->get('emails'));

            $is_valid = true;

            $emails = [];

            // check each email is valid and prepare for batch array
            foreach ($email_array as $k => $v) {
                $is_valid = filter_var($v, FILTER_VALIDATE_EMAIL);
                $emails[$k] = array('email' => $v);
            }

            if ($is_valid && $this->Marketing_emails_model->add($emails)) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        } else {
            echo json_encode(-1);
        }
    }

    /**
     * Updates email
     * 
     * @return void
     */
    public function update_marketing_email()
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $id = $this->input->get('id');
            $data['email'] = $this->input->get('email');

            $update = $this->Marketing_emails_model->update($id, $data);

            if ($update) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Deletes email
     *
     * @param int $id Email id
     * @return void
     */
    public function delete_marketing_email($id)
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Marketing_emails_model->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Toggle email subscription
     *
     * @param int $id email id
     * @return void
     */
    public function toggle_marketing_email_subscription($id)
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $is_subscribed = $this->Marketing_emails_model->get($id)->is_subscribed;

            if ($is_subscribed == 0) {
                $is_subscribed = 1;
            } else {
                $is_subscribed = 0;
            }

            $data = array(
                'is_subscribed' => $is_subscribed,
            );

            $this->Marketing_emails_model->update($id, $data);

            echo json_encode($is_subscribed);
        }
    }

    /**
     * Send email to all emails in the master email list
     *
     * @return void
     */
    public function send_mass_email()
    {
        if (!$this->ion_auth_acl->has_permission('email') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            if ($this->input->post('email-subject') == null || $this->input->post('email-content') == null) {
                http_response_code(400);
                exit;
            }
            $subject = $this->input->post('email-subject');
            $content = $this->input->post('email-content');

            $unsubscribe_url = site_url('myskearch/auth/unsubscribe/email');

            $footer = "<p align='center'><i>To unsubscribe marketing emails from Skearch.com, click <a href='{$unsubscribe_url}' target='_blank'>here</a>.</i><br></p>";
            $message = $content . "<br>" . $footer;

            $emails = $this->Marketing_emails_model->get($id = null, $is_subscribed = 1);
            foreach ($emails as $email) {
                $recipents[] = $email->email;
            }
            $recipents = implode(', ', $recipents);

            $this->email->clear();
            $this->email->from($this->config->item('default_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($this->config->item('default_email', 'ion_auth'));
            $this->email->bcc($recipents);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                // TODO: log email
                // foreach ($users as $user) {
                //     log_email($user->id, "Custom Message", $subject, $content);
                // }
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
}
