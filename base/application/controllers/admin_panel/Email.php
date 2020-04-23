<?php

/**
 * File: ~/application/controller/admin/Email.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Allows moderators to send emails to individial, users and groups
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

        $this->email->initialize($this->config->item('email_config', 'ion_auth'));
    }

    /**
     * Send email to Skearch members
     *
     * @return void
     */
    public function members()
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

                $this->load->view('admin_panel/pages/email_members', $data);
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
                    $this->session->set_flashdata('email_sent_success', 'The Email has been sent.');
                } else {
                    $this->session->set_flashdata('email_sent_failed', 'Unable to send email.');
                }
                $this->email->clear();
                redirect('admin/email/members');
            }
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
                $this->load->view('admin_panel/pages/email_invite', $data);
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
     * Undocumented function
     *
     * @param [type] $sString
     * @return void
     */
    public function email_check($sString)
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
}
