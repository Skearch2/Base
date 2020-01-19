<?php

/**
 * File: ~/application/controller/admin/Users.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Brandleads_model_admin.php
 *
 * A controller for brandleads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Brandleads extends MY_Controller
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

        $this->load->model('admin_panel/Brandleads_model_admin', 'Brandleads');
    }

    public function index()
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/brands/brandleads.php')) {
            show_404();
        }

        $data['title'] = ucfirst("Brand Leads");

        // Load page content
        $this->load->view('admin_panel/pages/brands/brandleads', $data);
    }

    /**
     * Get all brandleads
     *
     * @return object
     */
    public function get()
    {
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

    /**
     * Delete a brandlead
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $this->Brandleads->delete($id);
    }
}
