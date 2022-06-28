<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/brands/Deals.php
 *
 * This controller allows admins and editors edit, and view deal drops
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2022
 * @version      2.0
 */
class Deals extends MY_Controller
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

        $this->load->model('admin_panel/brands/brand_model', 'Brand');
        $this->load->model('admin_panel/brands/Dealdrop_model', 'Deals');

        // update status on deals based on start/end date
        $this->Deals->update_status();
    }

    /**
     * Create brand drop
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('brand_deals_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('link', 'Link', 'required|valid_url');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('duration', 'Duration', 'required|min_length[1]|max_length[30]');

            if ($this->form_validation->run() === false) {

                $data['brands'] = $this->Brand->get();

                // page title
                $data['title'] = ucwords('create deal drop');
                $this->load->view('admin_panel/pages/brands/deals/create', $data);
            } else {

                $duration = $this->input->post('duration');
                $end_date = date_create($this->input->post('start_date'));
                date_add($end_date, date_interval_create_from_date_string("{$duration} days"));
                $end_date = date_format($end_date, 'Y-m-d H:i');

                $data = [
                    'brand_id'     => $this->input->post('brand'),
                    'title'        => $this->input->post('title'),
                    'description'  => $this->input->post('description'),
                    'link'         => $this->input->post('link'),
                    'override_duration' => $this->input->post('override_duration'),
                    'start_date'   => $this->input->post('start_date'),
                    'end_date'     => $end_date
                ];

                $create = $this->Deals->create($data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }

                redirect("admin/brands/dealdrop");
            }
        }
    }

    /**
     * Delete deal
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('brand_deals_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Deals->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get brand deals
     *
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('brand_deals_get') or $this->ion_auth->is_admin()) {
            $brand_deals = $this->Deals->get();
            $total_brand_deals = count($brand_deals);
            $result = array(
                'iTotalRecords' => $total_brand_deals,
                'iTotalDisplayRecords' => $total_brand_deals,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $brand_deals,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for deal drop
     *
     * @return object
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brand_deals_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucwords("deal drop");

            // Load page content
            $this->load->view('admin_panel/pages/brands/deals/view', $data);
        }
    }

    /**
     * Update brand deal
     *
     * @param int $id Brand deal ID
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('brand_deals_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('link', 'Link', 'required|valid_url');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('duration', 'Duration', 'required|min_length[1]|max_length[30]');

            if ($this->form_validation->run() === false) {
                $deal = $this->Deals->get_by_id($id);

                $start_date = date_create($deal->start_date);
                $end_date = date_create($deal->end_date);
                $interval = date_diff($start_date, $end_date);

                $deal->duration = $interval->format('%a');

                // page data
                $data['deal'] = $deal;

                // page title
                $data['title'] = ucwords('edit deal drop');
                $this->load->view('admin_panel/pages/brands/deals/edit', $data);
            } else {

                $duration = $this->input->post('duration');
                $end_date = date_create($this->input->post('start_date'));
                date_add($end_date, date_interval_create_from_date_string("{$duration} days"));
                $end_date = date_format($end_date, 'Y-m-d H:i');

                $data = [
                    'brand_id'     => $this->input->post('brand'),
                    'title'        => $this->input->post('title'),
                    'description'  => $this->input->post('description'),
                    'link'         => $this->input->post('link'),
                    'override_duration' => $this->input->post('override_duration'),
                    'start_date'   => $this->input->post('start_date'),
                    'end_date'     => $end_date
                ];

                $update = $this->Deals->update($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }

                redirect("admin/brands/dealdrop");
            }
        }
    }
}
