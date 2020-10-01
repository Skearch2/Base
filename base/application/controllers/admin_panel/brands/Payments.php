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
class Payments extends MY_Controller
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

        $this->load->model('admin_panel/brands/payments_model', 'Payments');
    }

    /**
     * Get payment history for the brand
     * 
     * @param int $id Brand ID
     * @return object
     */
    public function get($brand_id)
    {
        if ($this->ion_auth_acl->has_permission('brand_payments') or $this->ion_auth->is_admin()) {
            $payment_history = $this->Payments->get($brand_id);
            $total_payments = sizeof($payment_history);
            $result = array(
                'iTotalRecords' => $total_payments,
                'iTotalDisplayRecords' => $total_payments,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $payment_history,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for brand payments
     *
     * @return void
     */
    public function index($brand_id)
    {
        if (!$this->ion_auth_acl->has_permission('brand_payments') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['brand_id'] = $brand_id;
            $data['title'] = ucfirst("Payment History");

            // Load page content
            $this->load->view('admin_panel/pages/brands/payments', $data);
        }
    }
}
