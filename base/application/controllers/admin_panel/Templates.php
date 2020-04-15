<?php

/**
 * File: ~/application/controller/admin_panel/Email.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Change email templates sent from Skearch
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */
class Templates extends MY_Controller
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

        $this->load->model('admin_panel/Template_model_admin', 'Template_model');
    }

    /**
     * Get email templates
     *
     * @param String $template_name Name of the template
     * @return void
     */
    public function get($template_name)
    {
        if (!$this->ion_auth_acl->has_permission('templates') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');

            if ($this->form_validation->run() === FALSE) {
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
            } else {
                if ($this->Template_model->update_template($template_name)) {
                    $this->session->set_flashdata('template_update_success', 'Template saved.');
                    redirect("admin/email/templates/$template_name");
                } else {
                    $this->session->set_flashdata('template_update_fail', 'Unable to save template.');
                    redirect("admin/email/templates/$template_name");
                }
            }
        }
    }
}
