<?php

/**
 * File: ~/application/controller/admin/results/Fields.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for fields
 *
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Fields extends MY_Controller
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
        $this->load->model('admin_panel/results/link_model', 'links');
    }

    /**
     * Creates a field
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('fields_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
            $this->form_validation->set_rules('parent_id', 'Umbrella', 'required');
            $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('keywords', 'Keywords', 'required|trim');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === true) {

                $field_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'parent_id' => $this->input->post('parent_id'),
                    'home_display' => $this->input->post('home_display'),
                    'keywords' => $this->input->post('keywords'),
                    'featured' => $this->input->post('featured'),
                    'enabled' => $this->input->post('enabled'),
                );

                $create = $this->fields->create($field_data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                    redirect('/admin/results/field/create');
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
            }

            $data['umbrellas'] = $this->umbrellas->get_by_status();

            $data['title'] = ucfirst("add field");
            $this->load->view('admin_panel/pages/results/field/create', $data);
        }
    }

    /**
     * Deletes a field
     *
     * @param int $id ID of the field
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('fields_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete =  $this->links->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Gets a field
     *
     * @param int $id ID of the field
     * @return void
     */
    public function get($id)
    {
        if ($this->ion_auth_acl->has_permission('fields_get') or $this->ion_auth->is_admin()) {
            $field = $this->fields->get($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($field));
        }
    }

    /**
     * Get fields by status
     *
     * @param active|inactive $status Status for the fields
     * @return void
     */
    public function get_by_status($status = null)
    {
        if ($this->ion_auth_acl->has_permission('fields_get') or $this->ion_auth->is_admin()) {

            $fields = $this->fields->get_by_status($status);
            $total_fields = sizeof($fields);

            $result = array(
                'iTotalRecords' => $total_fields,
                'iTotalDisplayRecords' => $total_fields,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $fields,
            );

            for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                $links = $this->links->get_by_field($result['aaData'][$i]->id);
                $result['aaData'][$i]->totalResults = sizeof($links);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get fields by umbrella
     *
     * @param int $umbrella_id ID of umbrella
     * @param string $status Status for the fields
     * @return void
     */
    public function get_by_umbrella($umbrella_id, $status = null)
    {
        if ($this->ion_auth_acl->has_permission('fields_get') or $this->ion_auth->is_admin()) {
            $fields = $this->fields->get_by_umbrella($umbrella_id, $status);
            $total_fields = sizeof($fields);

            $result = array(
                'iTotalRecords' => $total_fields,
                'iTotalDisplayRecords' => $total_fields,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $fields,
            );

            for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                $links = $this->links->get_by_field($result['aaData'][$i]->id);
                $result['aaData'][$i]->totalResults = sizeof($links);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Show fields page
     *
     * @param int|all|active|inative $value ID of the field or status of the fields
     * @param string $status Status of the fields
     * @return void
     */
    public function index($value = null)
    {
        if (!$this->ion_auth_acl->has_permission('fields_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            if ($value != null && is_numeric($value)) {
                $umbrella_id = $value;
                $umbrella_title = $this->umbrellas->get($umbrella_id)->title;
                $data['heading'] = ucwords("umbrella: " . $umbrella_title);
                $data['umbrella_id'] = $umbrella_id;
            } else {
                $status = $value;
                $data['heading'] = ucwords("status: " . $status);
                $data['status'] = $status;
            }

            $data['title'] = ucfirst("Fields");
            $this->load->view('admin_panel/pages/results/field/view', $data);
        }
    }

    /**
     * Toggle active status of a field
     *
     * @param int $id ID of the field
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('fields_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $status = $this->fields->get($id)->enabled;

            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $field_data = array(
                'enabled' => $status,
            );

            $toggle = $this->fields->update($id, $field_data);

            echo json_encode($status);
        }
    }

    /**
     * Updates a field
     *
     * @param int $id ID of the field
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('fields_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
            $this->form_validation->set_rules('parent_id', 'Umbrella', 'required');
            $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('keywords', 'Keywords', 'required|trim');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {

                $data['field'] = $this->fields->get($id);
                // get all umbrellas
                $data['umbrellas'] = $this->umbrellas->get_by_status();

                $data['title'] = ucfirst("edit field");
                $this->load->view('admin_panel/pages/results/field/edit', $data);
            } else {
                $field_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'parent_id' => $this->input->post('parent_id'),
                    'home_display' => $this->input->post('home_display'),
                    'keywords' => $this->input->post('keywords'),
                    'featured' => $this->input->post('featured'),
                    'enabled' => $this->input->post('enabled'),
                );

                $create = $this->fields->update($id, $field_data);

                if ($create) {
                    $this->session->set_flashdata('update_success', 1);
                    redirect('/admin/results/fields/status/all');
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
            }
        }
    }
}
