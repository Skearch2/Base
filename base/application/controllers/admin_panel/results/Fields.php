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
        $this->load->model('admin_panel/brands/brandlink_model', 'brandlinks');
        $this->load->model('Keywords_model', 'Keywords');
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

            $this->form_validation->set_rules('title', 'Title', 'required|trim|callback_duplicate_check');
            $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
            $this->form_validation->set_rules('parent_id', 'Umbrella', 'required');
            $this->form_validation->set_rules('home_display', 'Home Display', 'trim');
            $this->form_validation->set_rules('keywords', 'Keyword(s)', 'callback_validate_keywords');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === true) {

                $field_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'parent_id' => $this->input->post('parent_id'),
                    'home_display' => $this->input->post('home_display'),
                    'featured' => $this->input->post('featured'),
                    'enabled' => $this->input->post('enabled'),
                );

                $field_id = $this->fields->create($field_data);

                if ($field_id) {

                    if (!empty($this->input->post('keywords'))) {
                        $keywords = explode(',', $this->input->post('keywords'));
                        foreach ($keywords as $i => $keyword) {
                            $keywords_data[$i] = array(
                                'keyword' => $keyword,
                                'link_id' => $field_id,
                                'link_type' => 'field',
                                'status' => 1
                            );
                        }
                        $this->Keywords->create($keywords_data);
                    }

                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect('/admin/results/field/create');
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
            $delete =  $this->fields->delete($id);

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

            $this->form_validation->set_rules('title', 'Title', 'required|trim|callback_duplicate_check');
            $this->form_validation->set_rules('description', 'Description', 'max_length[500]|trim');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]|trim');
            $this->form_validation->set_rules('parent_id', 'Umbrella', 'required');
            $this->form_validation->set_rules('home_display', 'Home Display', 'trim');
            $this->form_validation->set_rules('keywords', 'Keyword(s)', 'trim|callback_validate_keywords[' . $id . ']');
            $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
            $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {

                $data['field'] = $this->fields->get($id);
                // get all umbrellas
                $data['umbrellas'] = $this->umbrellas->get_by_status();

                // keywords for field
                // convert keywords to single string seperated by comma
                $keywords = array_map(function ($object) {
                    return $object->keyword;
                }, $this->Keywords->get_by_link_id($id, 'field'));

                $data['keywords'] = implode(',', $keywords);

                $data['title'] = ucfirst("edit field");
                $this->load->view('admin_panel/pages/results/field/edit', $data);
            } else {
                $field_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'description_short' => $this->input->post('description_short'),
                    'parent_id' => $this->input->post('parent_id'),
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
                            'link_type' => 'field',
                            'status' => 1
                        );
                    }
                    $this->Keywords->replace($id, $keywords_data);
                }

                $update = $this->fields->update($id, $field_data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect('/admin/results/fields/status/all');
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
    { {
            if (!empty($this->input->post('field_id'))) {
                $field_id = $this->input->post('field_id');
            }

            if ($this->umbrellas->duplicate_check($string)) {
                $this->form_validation->set_message('duplicate_check', "{field} already exists in Umbrellas.");
                return false;
            } elseif ($this->fields->duplicate_check($string)) {
                if (isset($field_id)) {
                    if ($this->fields->get($field_id)->title !== $string) {
                        $this->form_validation->set_message('duplicate_check', "{field} already exists in Fields.");
                        return false;
                    }
                } else {
                    $this->form_validation->set_message('duplicate_check', "{field} already exists in Fields.");
                    return false;
                }
            } else {
                return true;
            }
        }
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
            return true;
        }

        $keywords = explode(',', $string);

        $check =  true;

        $duplicate_keywords = array();

        foreach ($keywords as $keyword) {
            if (ctype_alpha(str_replace(array("\n", "\t", ' '), '', $keyword)) === false) {
                $this->form_validation->set_message('validate_keywords', "%s can only have alphabets and spaces.");
                $check = false;
            }
            if ($this->Keywords->duplicate_check_using_link($keyword, $link_id, $link_type = 'field')) {
                array_push($duplicate_keywords, $keyword);
                $duplicate_keywords_in_string = implode(' , ', $duplicate_keywords);
                $this->form_validation->set_message('validate_keywords', "%s already exist either as BrandLink or Search keyword: <br><i>$duplicate_keywords_in_string</i>");
                $check = false;
            }
        }

        return $check;
    }
}
