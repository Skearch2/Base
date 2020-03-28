<?php

/**
 * File: ~/application/controller/admin/results/Umbrellas.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for umbrellas
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Umbrellas extends MY_Controller
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
            $this->session->set_flashdata('no_access', 1);
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/results/umbrella_model', 'umbrellas');
        $this->load->model('admin_panel/results/field_model', 'fields');
    }

    /**
     * Create an umbrella
     *
     * @return void
     */
    public function create()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
        $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required|trim');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');


        if ($this->form_validation->run() === true) {

            $umbrella_data = array(
                'title'             => $this->input->post('title'),
                'description'       => $this->input->post('description'),
                'description_short' => $this->input->post('description_short'),
                'umbrella_name'     => $this->input->post('umbrella_name'),
                'home_display'      => $this->input->post('home_display'),
                'keywords'          => $this->input->post('keywords'),
                'featured'          => $this->input->post('featured'),
                'enabled'           => $this->input->post('enabled')
            );

            $create = $this->umbrellas->create($umbrella_data);

            if ($create) {
                $this->session->set_flashdata('create_success', 1);
                redirect('/admin/results/umbrella/create');
            } else {
                $this->session->set_flashdata('create_success', 0);
            }
        }

        $data['title'] = ucfirst("add umbrella");
        $this->load->view('admin_panel/pages/results/umbrella/create', $data);
    }

    /**
     * Deletes an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function delete($id)
    {
        $this->umbrellas->delete($id);
    }

    /**
     * Gets umbrellas by status
     *
     * @param String $status Status of the umbrella
     * @return void
     */
    public function get_by_status($status = NULL)
    {

        $umbrellas = $this->umbrellas->get_by_status($status);
        $total_umbrellas = sizeof($umbrellas);
        $result = array(
            'iTotalRecords' => $total_umbrellas,
            'iTotalDisplayRecords' => $total_umbrellas,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $umbrellas
        );
        for ($i = 0; $i < sizeof($result['aaData']); $i++) {
            $fields = $this->fields->get_by_umbrella($result['aaData'][$i]->id);
            $result['aaData'][$i]->totalFields = sizeof($fields);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Gets an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function get($id)
    {
        $umbrella = $this->umbrellas->get($id);

        return $umbrella;
    }

    /**
     * Show umbrellas page
     *
     * @param String $status Status of umbrellas
     * @return void
     */
    public function index($status = NULL)
    {

        $data['title'] = ucfirst("Umbrella");
        $data['status'] = $status;

        // Load page content
        $this->load->view('admin_panel/pages/results/umbrella/view', $data);
    }

    /**
     * Toggle active status of an umbrella
     *
     * @param int $id ID of the umbrella
     * @return void
     */
    public function toggle($id)
    {
        $status = $this->umbrellas->get($id)->enabled;

        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        $umbrella_data = array(
            'enabled' => $status,
        );

        $this->umbrellas->update($id, $umbrella_data);

        echo json_encode($status);
    }

    /**
     * Update an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
        $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces|trim');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required|trim');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');


        if ($this->form_validation->run() === false) {

            $data['umbrella'] = $this->umbrellas->get($id);

            $data['title'] = ucfirst("edit umbrella");
            $this->load->view('admin_panel/pages/results/umbrella/edit', $data);
        } else {
            $umbrella_data = array(
                'title'             => $this->input->post('title'),
                'description'       => $this->input->post('description'),
                'description_short' => $this->input->post('description_short'),
                'umbrella_name'     => $this->input->post('umbrella_name'),
                'home_display'      => $this->input->post('home_display'),
                'keywords'          => $this->input->post('keywords'),
                'featured'          => $this->input->post('featured'),
                'enabled'           => $this->input->post('enabled')
            );

            $create = $this->umbrellas->update($id, $umbrella_data);

            if ($create) {
                $this->session->set_flashdata('update_success', 1);
                redirect('/admin/results/umbrellas/status/all');
            } else {
                $this->session->set_flashdata('update_success', 0);
            }
        }
    }
}
