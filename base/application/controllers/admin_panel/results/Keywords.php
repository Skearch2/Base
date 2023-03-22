<?php

/**
 * File: ~/application/controller/admin/results/Keywords.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for search keywords
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Keywords extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('admin/auth/login');
        }

        $this->load->model('Keywords_model', 'Keywords');
        $this->load->model('admin_panel/results/Field_model', 'Fields');
        $this->load->model('admin_panel/results/Umbrella_model', 'Umbrellas');
        $this->load->model('admin_panel/brands/brandlink_model', 'Brandlinks');
    }

    /**
     * Shows create page for research link and add research links on POST
     * 
     * @return void
     */
    public function create()
    {

        if (!$this->ion_auth_acl->has_permission('search_keywords_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('keywords', 'Keyword', 'trim|required|callback_validate_keyword');
            $this->form_validation->set_rules('link_type', 'Link to', 'required');
            if ($this->input->post("link_type") == 'umbrella') {
                $this->form_validation->set_rules('umbrella_id', 'Umbrella', 'required|numeric');
            } else if ($this->input->post("link_type") == 'field') {
                $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
            }

            // check if the keyword links to umbrella or field
            $link_type = (null !== $this->input->post("link_type")) ? $this->input->post("link_type") : null;

            if ($this->form_validation->run() == false) {
                $data['title'] = ucfirst("Add Keyword");
                $data['link_type'] = $link_type;
                $data['umbrellas'] = $this->Umbrellas->get_by_status('active');
                $data['fields'] = $this->Fields->get_by_status('active');

                $this->load->view('admin_panel/pages/results/keywords/create', $data);
            } else {

                // POST data
                $keywords = explode(',', strtolower($this->input->post('keywords')));
                if ($this->input->post("link_type") == 'umbrella') {
                    $link_id = $this->input->post('umbrella_id');
                } else if ($this->input->post("link_type") == 'field') {
                    $link_id = $this->input->post('field_id');
                }
                $link_type = $this->input->post('link_type');
                $status = $this->input->post('status');

                foreach ($keywords as $i => $keyword) {
                    $keywords_data[$i] = array(
                        'keyword' => $keyword,
                        'link_id' => $link_id,
                        'link_type' => $link_type,
                        'status' => $status
                    );
                }

                $create = $this->Keywords->create($keywords_data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }

                redirect('/admin/results/keyword/add');
            }
        }
    }

    /**
     * Delete keyword
     * 
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('search_keywords_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Keywords->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get keywords JSON
     * 
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('search_keywords_get') or $this->ion_auth->is_admin()) {
            $keywords = $this->Keywords->get();
            $total_records = sizeof($keywords);
            $result = array(
                'iTotalRecords' => $total_records,
                'iTotalDisplayRecords' => $total_records,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $keywords
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }
    /**
     * Show list of keywords
     * 
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('search_keywords_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucwords("keywords");

            // Load page content
            $this->load->view('admin_panel/pages/results/keywords/view', $data);
        }
    }

    /**
     * Toggle keyword status
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('search_keywords_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $status = $this->Keywords->get_by_id($id)->status;

            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $data = array(
                'status' => $status,
            );

            $this->Keywords->update($id, $data);

            echo json_encode($status);
        }
    }

    /**
     * Edit keyword information
     * 
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('search_keywords_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|callback_validate_keyword[' . $id . ']');
            $this->form_validation->set_rules('link_type', 'Link to', 'required');
            if ($this->input->post("link_type") == 'umbrella') {
                $this->form_validation->set_rules('umbrella_id', 'Umbrella', 'required|numeric');
            } else if ($this->input->post("link_type") == 'field') {
                $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
            }

            if ($this->form_validation->run() == false) {
                $data['keyword_data'] = $this->Keywords->get_by_id($id);
                $data['umbrellas'] = $this->Umbrellas->get_by_status('active');
                $data['fields'] = $this->Fields->get_by_status('active');

                $data['title'] = ucfirst("Edit Keyword");

                $this->load->view('admin_panel/pages/results/keywords/edit', $data);
            } else {

                // POST data
                $keyword = strtolower($this->input->post('keyword'));
                if ($this->input->post("link_type") == 'umbrella') {
                    $link_id = $this->input->post('umbrella_id');
                } else if ($this->input->post("link_type") == 'field') {
                    $link_id = $this->input->post('field_id');
                }
                $link_type = $this->input->post('link_type');
                $status = $this->input->post('status');

                $keyword_data = array(
                    'keyword' => $keyword,
                    'link_id' => $link_id,
                    'link_type' => $link_type,
                    'status' => $status
                );

                $update = $this->Keywords->update($id, $keyword_data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }

                redirect('/admin/results/keywords');
            }
        }
    }

    /**
     * Validate keyword
     *
     * @param string $string Keyword
     * @param string $id Keyword ID
     * @return void
     */
    public function validate_keyword($keyword, $id = null)
    {
        if (ctype_alpha(str_replace(array("\n", "\t", ' '), '', $keyword)) === false) {
            $this->form_validation->set_message('validate_keyword', "%s can only contain alphabets and spaces.");
            return false;
        }

        if ($this->Keywords->duplicate_check($keyword)) {
            if (empty($id)) {
                $this->form_validation->set_message('validate_keyword', "%s already exists.");
                return false;
            } else {
                if ($this->Keywords->get_by_id($id)->keyword !== $keyword) {
                    $this->form_validation->set_message('validate_keyword', "%s already exists.");
                    return false;
                }
            }
        }

        if ($this->Brandlinks->duplicate_check($keyword)) {
            $this->form_validation->set_message('validate_keyword', "%s already exists as a BrandLink.");
            return false;
        }

        return true;
    }

    /**
     * Validate keywords
     *
     * @param string $string Keywords seperated by comma
     * @return void
     */
    public function validate_keywords($string)
    {
        if (empty($string)) {
            $this->form_validation->set_message('validate_keywords', "The %s field is required");
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
            if ($this->Keywords->duplicate_check_using_link($keyword)) {
                array_push($duplicate_keywords, $keyword);
                $duplicate_keywords_in_string = implode(' , ', $duplicate_keywords);
                $this->form_validation->set_message('validate_keywords', "%s already exist either as BrandLink or Search keyword: <br><i>$duplicate_keywords_in_string</i>");
                $check = false;
            }
        }

        return $check;
    }
}
