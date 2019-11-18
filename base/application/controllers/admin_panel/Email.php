<?php
/**
 * File: ~/application/controller/admin/Email.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * An email controller for My Skearch
 *
 * Allows moderators to send emails to individial, users and groups
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018 Skearch LLC
 */
class Email extends MY_Controller
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
    }

    /**
     * Undocumented function
     */
    public function members()
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/email_members.php')) {
            show_404();
        }

        if ($this->form_validation->run() == FALSE)
        {

            $data['user_groups'] = $this->ion_auth->groups()->result();
            $users = $this->User_model->get_user_list();

            $data['title'] = ucwords("Email Member");

            $this->load->view('admin_panel/pages/email_members', $data);
        }
        else
        {

            $subject = $this->input->post('subject');
            $content = $this->input->post('content');

            $config['email_config'] = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://node1566.myfcloud.com',
                'smtp_user' => 'no-reply@skearch.com',
                'smtp_pass' => '4URUpw6mXe',
                'smtp_port' => '465',
                'validation' => true,
                'multipart' => "mixed",
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'crlf' => "\r\n",
            );

            $this->email->initialize($config);

            $this->email->from('no-reply@skearch.com', 'Skearch');
            $this->email->to('no-reply@skearch.com');
            $this->email->bcc($recipents);
            $this->email->subject($subject);
            $this->email->message($content);

            if($this->email->send()) {
                $this->session->set_flashdata('email_sent_success', 'The Email has been sent!');
            } else {
                $this->session->set_flashdata('email_sent_fail', 'Unable to send email!');
            }
            $this->email->clear();
            redirect('admin/email/members');
        }
    }

    /**
     * Undocumented function
     */
    public function invite()
    {

        $this->form_validation->set_rules('recipents', 'Recipents', 'required|callback_email_check');

        if ($this->form_validation->run() === FALSE)
        {

          if (!file_exists(APPPATH . '/views/admin_panel/pages/email_invite.php')) {
              show_404();
          }

            $data['title'] = ucwords("Email Invite");
            $this->load->view('admin_panel/pages/email_invite', $data);
        }
        else
        {
            $recipents = explode(";", $this->input->post('recipents'));
            $subject = $this->input->post('subject');
            $content = $this->input->post('content');

            $config['email_config'] = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://node1566.myfcloud.com',
                'smtp_user' => 'no-reply@skearch.com',
                'smtp_pass' => '4URUpw6mXe',
                'smtp_port' => '465',
                'validation' => true,
                'multipart' => "mixed",
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'crlf' => "\r\n",
            );

            $this->email->initialize($config);

            $this->email->from('no-reply@skearch.com', 'Skearch');
            $this->email->to('no-reply@skearch.com');
            $this->email->bcc($recipents);
            $this->email->subject($subject);
            $this->email->message($content);

            if($this->email->send()) {
                $this->session->set_flashdata('email_sent_success', 'The Email has been sent!');
            } else {
                $this->session->set_flashdata('email_sent_fail', 'Unable to send email!');
            }
            $this->email->clear();
            redirect('admin/email/invite');
        }
    }

    public function email_check($sString)
    {

      $sEmailAddresses = preg_split( "/; |;/", $sString);
      foreach($sEmailAddresses AS $sEmailAddress) {
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
