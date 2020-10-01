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
        $this->load->model('admin_panel/email/Log_model', 'Logs');

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
                    // log email
                    $this->Log_model->create(array(
                        'type' => 'Invitation',
                        'user_id' => 0
                    ));
                    $this->session->set_flashdata('email_sent_success', 'The Email has been sent.');
                } else {
                    $this->session->set_flashdata('email_sent_failed', 'Unable to send email.');
                }
                $this->email->clear();
                redirect('admin/email/invite');
            }
        }
    }

    /**
     * Clear all email logs

     * @return void
     */
    public function logs_clear()
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $clear = $this->Logs->delete();

            if ($clear) {
                $this->session->set_flashdata('clear_success', 1);
            } else {
                $this->session->set_flashdata('clear_success', 0);
            }

            redirect('admin/email/logs');
        }
    }

    /**
     * View email logs sent by Skearch
     * @param boolean $get If true get json data
     * @return void
     */
    public function logs($get = false)
    {
        if (!$this->ion_auth_acl->has_permission('email_logs') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            if ($get) {
                $logs = $this->Logs->get();
                $total_logs = sizeof($logs);

                $result = array(
                    'iTotalRecords' => $total_logs,
                    'iTotalDisplayRecords' => $total_logs,
                    'sEcho' => 0,
                    'sColumns' => "",
                    'aaData' => $logs,
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            } else {
                $data['title'] = ucwords("Email Logs");
                $this->load->view('admin_panel/pages/email/logs', $data);
            }
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
            $this->form_validation->set_rules('content', 'Body', 'required|min_length[5]|max_length[1000]');

            if ($this->form_validation->run() == FALSE) {

                $data['email_custom'] = $email_custom;
                $data['title'] = ucwords("Email Members");

                $this->load->view('admin_panel/pages/email/message', $data);
            } else {

                $subject = $this->input->post('subject');
                $content = $this->input->post('content');

                $this->email->from('no-reply@skearch.com', 'Skearch');

                if ($email_custom) {
                    $recipent = $this->input->post('email');
                    $this->email->to($recipent);
                } else {
                    $emails = $this->Users->get_members_email();
                    foreach ($emails as $email) {
                        $recipents[] = $email->email;
                    }
                    $recipents = implode(', ', $recipents);

                    $this->email->to('no-reply@skearch.com');
                    $this->email->bcc($recipents);
                }
                $this->email->subject($subject);
                $this->email->message($content);

                if ($this->email->send()) {
                    // log email
                    $this->Log_model->create(array(
                        'type' => 'All Members',
                        'user_id' => 0
                    ));

                    $this->session->set_flashdata('email_sent_success', 'The Email has been sent.');
                } else {
                    $this->session->set_flashdata('email_sent_failed', 'Unable to send email.');
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
                    $this->session->set_flashdata('template_update_success', 'Template saved.');
                    redirect("admin/email/templates/$type");
                } else {
                    $this->session->set_flashdata('template_update_fail', 'Unable to save template.');
                    redirect("admin/email/templates/$type");
                }
            }
        }
    }
}
