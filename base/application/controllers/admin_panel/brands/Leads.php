<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/brands/Leads.php
 *
 * A controller for brandleads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Leads extends MY_Controller
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

        $this->load->model('admin_panel/brands/leads_model', 'Leads');
    }

    /**
     * Delete a brandlead
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('brandleads_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Leads->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get all brandleads
     *
     * @return object
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('brandleads_get') or $this->ion_auth->is_admin()) {
            $brandleads = $this->Leads->get();
            $total_brands = sizeof($brandleads);
            $result = array(
                'iTotalRecords' => $total_brands,
                'iTotalDisplayRecords' => $total_brands,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $brandleads,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brandleads_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("Leads");

            // Load page content
            $this->load->view('admin_panel/pages/brands/leads', $data);
        }
    }
}
