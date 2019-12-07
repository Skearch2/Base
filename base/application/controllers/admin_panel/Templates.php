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
class Templates extends MY_Controller
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

        $this->load->model('admin_panel/Template_model_admin', 'Template_model');
    }

    /**
     * Undocumented function
     */
    public function get($template_name)
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/email_template.php')) {
            show_404();
        }

        $this->form_validation->set_rules('subject', 'Subject', 'required|trim');

        if ($this->form_validation->run() === FALSE)
        {
            $query = $this->Template_model->get_template($template_name);

            if ($query) {

              $data = array(
                      'subject' => $query->subject,
                      'body'    => $query->body
              );

              $data['title'] = ucwords("Email Template - " . ucwords($template_name));

              $this->load->view('admin_panel/pages/email_template', $data);

            } else {
                show_error("Database Error", 500);
            }
        }
        else
        {
            if($this->Template_model->update_template($template_name)) {
                  $this->session->set_flashdata('template_update_success', 'Template saved.');
                  redirect("admin/email/templates/$template_name");
            } else {
                  $this->session->set_flashdata('template_update_fail', 'Unable to save template.');
                  redirect("admin/email/templates/$template_name");
            }
        }
    }
}
