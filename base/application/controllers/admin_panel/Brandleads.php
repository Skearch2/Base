<?php

/**
 * File: ~/application/controller/admin/Users.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/Brandleads.php
 *
 * A controller for brandleads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Brandleads extends MY_Controller
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

        $this->load->model('admin_panel/Brandleads_model_admin', 'Brandleads');
    }

    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brandleads_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            if (!file_exists(APPPATH . '/views/admin_panel/pages/brands/brandleads.php')) {
                show_404();
            }

            $data['title'] = ucfirst("Brand Leads");

            // Load page content
            $this->load->view('admin_panel/pages/brands/brandleads', $data);
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
            $brandleads = $this->Brandleads->get();
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
            $delete = $this->Brandleads->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
}
