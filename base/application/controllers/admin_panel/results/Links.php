<?php

/**
 * File: ~/application/controller/admin/results/Links.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for links
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Links extends MY_Controller
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

        $this->load->model('admin_panel/results/field_model', 'fields');
        $this->load->model('admin_panel/results/link_model', 'links');
        $this->load->model('admin_panel/category_model_admin', 'linkss');
    }

    /**
     * Creates a link
     *
     * @return void
     */
    public function create()
    {

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('sub_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display');
        $this->form_validation->set_rules('www', 'WWW', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

        if ($this->form_validation->run() == true) {
            $data = $this->input->post(NULL, TRUE);
            $this->categoryModel->create_result_listing($data['title'], $data['enabled'], $data['description_short'], $data['display_url'], $data['www'], $data['sub_id'], $data['priority'], $data['redirect']);

            // Clear all the input field
            $this->form_validation->clear_field_data();

            // Display success flash message
            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            AdLink has been successfully added to the database.
                    </div>
                </div>
            ', 1);
        }

        $data['title'] = ucfirst("Add New Result");
        $data['subcategory_list'] = $this->categoryModel->get_subcategories();

        $prioritiesObject = $this->categoryModel->get_links_priority($data['subcategory_list'][0]->id);
        $priorities = array();
        foreach ($prioritiesObject as $item) {
            array_push($priorities, $item->priority);
        }

        $data['priorities'] = $priorities;

        $this->load->view('admin_panel/pages/results/link/create', $data);
    }

    /**
     * Deletes a link
     *
     * @param int $id ID of a link
     * @return void
     */
    public function delete($id)
    {
        $this->categoryModel->delete_result_listing($id);
    }

    /**
     * Duplicate a link to selected field
     * 
     * @param int $id ID of a link to duplicate
     * @param int $field_id ID of a field to duplicate link to
     * @param int $priority Priority of the duplicated link
     * @return void
     */
    public function duplicate($id, $field_id, $priority)
    {
        $link = $this->links->get($id);

        $title              = $link->title;
        $description_short  = $link->description_short;
        $display_url        = $link->display_url;
        $www                = $link->www;
        $redirect           = $link->redirect;
        $enabled            = $link->enabled;

        $this->links->create($priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled);
    }

    public function get($id = NULL)
    {
        $link = $this->links->get($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($link));
    }

    /**
     * Get a field or all fields
     *
     * @param int $umbrella_id ID of umbrella
     * @param String $status Status of the fields
     * @return void
     */
    public function get_by_field($field_id, $status = NULL)
    {

        $links = $this->links->get_by_field($field_id, $status);
        $total_links = sizeof($links);

        $result = array(
            'iTotalRecords' => $total_links,
            'iTotalDisplayRecords' => $total_links,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $links
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Get links based on keywords
     *
     * @param string $keywords Keywords for the title of the link
     * @return void
     */
    public function get_by_keywords($keywords = NULL)
    {

        $links = $this->links->get_by_keywords($keywords);
        $total_links = sizeof($links);

        $result = array(
            'iTotalRecords' => $total_links,
            'iTotalDisplayRecords' => $total_links,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $links
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


    /**
     * Get a field or all fields
     *
     * @param int $umbrella_id ID of umbrella
     * @param String $status Status of the fields
     * @return void
     */
    public function get_by_status($status = NULL)
    {

        $links = $this->links->get_by_status($status);
        $total_links = sizeof($links);

        $result = array(
            'iTotalRecords' => $total_links,
            'iTotalDisplayRecords' => $total_links,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $links
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function index($value = NULL)
    {
        //$data['fields'] = $this->fields->get_by_status();
        $field_id = $value;
        $data['field_id'] = $field_id;

        $prioritiesObject = $this->linkss->get_links_priority($value);
        $priorities = array();
        foreach ($prioritiesObject as $item) {
            array_push($priorities, $item->priority);
        }

        $data['priorities'] = $priorities;

        $data['title'] = ucfirst("Ad Links List");

        if ($value != NULL && is_numeric($value)) {
            $field_title = $this->fields->get($field_id)->title;
            $data['sub_title'] = ucfirst("Links under \"" . $field_title . "\"");
            $this->load->view('admin_panel/pages/results/link/view_by_field', $data);
        } else if ($value != NULL && strcmp($value, "search") === 0) {
            $status = $value;
            $data['status'] = $status;
            $data['sub_title'] = ucfirst($status);
            $this->load->view('admin_panel/pages/results/link/search', $data);
        } else {
            $status = $value;
            $data['status'] = $status;
            $data['sub_title'] = ucfirst($status);
            $this->load->view('admin_panel/pages/results/link/view', $data);
        }


        // if ($field != "all") {
        //     $field_title = $this->categoryModel->get_single_subcategory($field)[0]->title;
        //     $data['subTitle'] = ucfirst("Ad Links under \"" . $field_title . "\"");
        //     $this->load->view('admin_panel/pages/results/link/result_list_sub', $data);
        // } elseif ($field == "all" && ($status == 'active' || $status == 'inactive')) {
        //     $this->load->view('admin_panel/pages/results/link/result_list', $data);
        // } else {
        //     $data['subTitle'] = ucfirst("Ad Links List");
        //     $this->load->view('admin_panel/pages/results/link/search_ad_links', $data);
        // }
    }

    /**
     * Move a link to a selected field
     * 
     * @param int $id ID of a link to move
     * @param int $field_id ID of a field to move link to
     * @param int $priority Priority of the moved link
     * @return void
     */
    public function move($id, $field_id, $priority)
    {
        $title              = NULL;
        $description_short  = NULL;
        $display_url        = NULL;
        $www                = NULL;
        $redirect           = NULL;
        $enabled            = NULL;

        $this->links->update($id, $priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled);
    }


    /**
     * Get link priorities
     *
     * @param int $id ID of the field
     * @return void
     */
    public function priorities($id)
    {
        $prioritiesObj = $this->categoryModel->get_links_priority($id);
        // $priorities = array();
        // 	foreach ($prioritiesObj as $item) {
        // 		array_push($priorities, $item->priority);
        // 	}

        echo json_encode($prioritiesObj);
    }

    public function toggle($id)
    {

        $status = $this->categoryModel->get_single_result($id)[0]->enabled;

        if ($status == 0) $status = 1;
        else $status = 0;
        $this->categoryModel->toggle_result($id, $status);

        echo json_encode($status);
    }

    public function redirect($id)
    {

        $status = $this->categoryModel->get_single_result($id)[0]->redirect;

        if ($status == 0) $status = 1;
        else $status = 0;
        $this->categoryModel->toggle_redirect($id, $status);

        echo json_encode($status);
    }

    public function change_priority($id, $priority)
    {
        $status = $this->categoryModel->change_priority($id, $priority);
    }

    /**
     * Updates a link
     *
     * @param int $id ID of a link
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('sub_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('www', 'WWW', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post(NULL, TRUE);

            $this->categoryModel->update_result_listing($id, $data['title'], $data['enabled'], $data['description_short'], $data['display_url'], $data['www'], $data['sub_id'], $data['priority'], $data['redirect']);

            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            AdLink has been successfully added to the database.
                    </div>
                </div>
            ', 1);
        }

        $data['title'] = ucfirst("Edit Result");
        $data['result'] = $this->categoryModel->get_single_result($id);
        $data['subcategory_list'] = $this->categoryModel->get_subcategories();

        $prioritiesObject = $this->categoryModel->get_links_priority($this->categoryModel->get_result_parent($id));
        $priorities = array();
        foreach ($prioritiesObject as $item) {
            array_push($priorities, $item->priority);
        }

        $data['priorities'] = $priorities;
        $this->load->view('admin_panel/pages/results/link/edit', $data);
    }
}
