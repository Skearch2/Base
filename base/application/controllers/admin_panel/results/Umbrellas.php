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

        $this->load->model('admin_panel/results/umbrella_model', 'Umbrella');
        $this->load->model('admin_panel/results/field_model', 'Field');
        $this->load->model('admin_panel/brands/brandlink_model', 'Brandlinks');
        $this->load->model('Keywords_model', 'Keywords');
    }

    /**
     * Create an umbrella
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'trim|required|alpha_numeric_spaces|callback_duplicate_check');
            $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
            $this->form_validation->set_rules('description_short', 'Hover Over Info', 'required|max_length[140]|trim');
            $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('home_display', 'Button Display Name', 'required|alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('keywords', 'Keyword(s)', 'callback_validate_keywords');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === true) {

                $umbrella_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'umbrella_name' => $this->input->post('umbrella_name'),
                    'home_display' => $this->input->post('home_display'),
                    'featured' => $this->input->post('featured'),
                    'enabled' => $this->input->post('enabled'),
                );

                $umbrella_id = $this->Umbrella->create($umbrella_data);

                if ($umbrella_id) {
                    if (!empty($this->input->post('keywords'))) {
                        $keywords = explode(',', $this->input->post('keywords'));
                        foreach ($keywords as $i => $keyword) {
                            $keywords_data[$i] = array(
                                'keyword' => $keyword,
                                'link_id' => $umbrella_id,
                                'link_type' => 'umbrella',
                                'status' => 1
                            );
                        }
                        $this->Keywords->create($keywords_data);
                    }
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect('/admin/results/umbrella/create');
            }

            $data['title'] = ucfirst("add umbrella");
            $this->load->view('admin_panel/pages/results/umbrella/create', $data);
        }
    }

    /**
     * Deletes an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Umbrella->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Gets umbrellas by status
     *
     * @param string $status Status for the umbrellas
     * @return void
     */
    public function get_by_status($status = null)
    {
        if ($this->ion_auth_acl->has_permission('umbrellas_get') or $this->ion_auth->is_admin()) {
            $umbrellas = $this->Umbrella->get_by_status($status);
            $total_umbrellas = sizeof($umbrellas);
            $result = array(
                'iTotalRecords' => $total_umbrellas,
                'iTotalDisplayRecords' => $total_umbrellas,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $umbrellas,
            );
            for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                $fields = $this->Field->get_by_umbrella($result['aaData'][$i]->id);
                $result['aaData'][$i]->totalFields = sizeof($fields);
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Gets an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function get($id)
    {
        if ($this->ion_auth_acl->has_permission('umbrellas_get') or $this->ion_auth->is_admin()) {
            $umbrella = $this->Umbrella->get($id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($umbrella));
        }
    }

    /**
     * Show umbrellas page
     *
     * @param string $status Status of umbrellas
     * @return void
     */
    public function index($status = null)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['status'] = $status;
            $data['heading'] = ucfirst($status);

            $data['title'] = ucfirst("Umbrellas");

            // Load page content
            $this->load->view('admin_panel/pages/results/umbrella/view', $data);
        }
    }

    /**
     * Toggle active status of an umbrella
     *
     * @param int $id ID of the umbrella
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $status = $this->Umbrella->get($id)->enabled;

            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $umbrella_data = array(
                'enabled' => $status,
            );

            $this->Umbrella->update($id, $umbrella_data);

            echo json_encode($status);
        }
    }

    /**
     * Update an umbrella
     *
     * @param int $id ID of an umbrella
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|alpha_numeric_spaces|callback_duplicate_check');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');
            $this->form_validation->set_rules('description_short', 'Hover Over Info', 'trim|required|max_length[140]');
            $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('home_display', 'Button Display Name', 'required|alpha_numeric_spaces|trim');
            $this->form_validation->set_rules('keywords', 'Keyword(s)', 'trim|callback_validate_keywords[' . $id . ']');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {

                // umbrella data
                $data['umbrella'] = $this->Umbrella->get($id);

                // keywords for umbrella
                // convert keywords to single string seperated by comma
                $keywords = array_map(function ($object) {
                    return $object->keyword;
                }, $this->Keywords->get_by_link_id($id, 'umbrella'));

                $data['keywords'] = implode(',', $keywords);

                $data['title'] = ucfirst("edit umbrella");
                $this->load->view('admin_panel/pages/results/umbrella/edit', $data);
            } else {
                $umbrella_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'umbrella_name' => $this->input->post('umbrella_name'),
                    'home_display' => $this->input->post('home_display'),
                    'featured' => $this->input->post('featured'),
                    'enabled' => $this->input->post('enabled'),
                );

                if (empty($this->input->post('keywords'))) {
                    $this->Keywords->replace($id, null);
                } else {
                    $keywords = explode(',', $this->input->post('keywords'));
                    foreach ($keywords as $i => $keyword) {
                        $keywords_data[$i] = array(
                            'keyword' => $keyword,
                            'link_id' => $id,
                            'link_type' => 'umbrella',
                            'status' => 1
                        );
                    }
                    $this->Keywords->replace($id, $keywords_data);
                }

                $update = $this->Umbrella->update($id, $umbrella_data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect('admin/results/umbrellas/status/all');
            }
        }
    }

    /**
     * Check for duplicate umbrella or field title 
     *
     * @param string $string String
     * @return void
     */
    public function duplicate_check($string)
    {
        if (!empty($this->input->post('umbrella_id'))) {
            $umbrella_id = $this->input->post('umbrella_id');
        }

        if ($this->Umbrella->duplicate_check($string)) {
            if (isset($umbrella_id)) {
                if (strcasecmp($this->Umbrella->get($umbrella_id)->title, $string) != 0) {
                    $this->form_validation->set_message('duplicate_check', "{field} already exists in Umbrellas.");
                    return false;
                }
            } else {
                $this->form_validation->set_message('duplicate_check', "{field} already exists in Umbrellas.");
                return false;
            }
        }

        if ($this->Field->duplicate_check($string)) {
            $this->form_validation->set_message('duplicate_check', "{field} already exists in Fields.");
            return false;
        }

        return true;
    }

    /**
     * Validate keywords and check for duplicates
     *
     * @param string $string Keywords seperated by comma
     * @param int $link_id Link ID
     * @return void
     */
    public function validate_keywords($string, $link_id = null)
    {
        if (empty($string)) {
            $this->form_validation->set_message('validate_keywords', "%s require atleast one keyword.");
            return false;
        }

        $keywords = explode(',', $string);

        $check =  true;

        $duplicate_keywords = array();

        foreach ($keywords as $keyword) {
            if (ctype_alpha(str_replace(array("\n", "\t", ' '), '', $keyword)) === false) {
                $this->form_validation->set_message('validate_keywords', "%s can only have alphabets and spaces.");
                $check = false;
            }
            if ($this->Keywords->duplicate_check_using_link($keyword, $link_id, $link_type = 'umbrella')) {
                array_push($duplicate_keywords, $keyword);
                $duplicate_keywords_in_string = implode(' , ', $duplicate_keywords);
                $this->form_validation->set_message('validate_keywords', "%s already exist either as BrandLink or Search keyword: <br><i>$duplicate_keywords_in_string</i>");
                $check = false;
            }
        }

        return $check;
    }
}
