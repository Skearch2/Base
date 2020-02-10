<?php

/**
 * File: ~/application/controller/admin/results/Research.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for research links
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Research extends MY_Controller
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

        $this->load->model('admin_panel/results/research_link', 'research');
        $this->load->model('admin_panel/category_model_admin', 'fields');
    }

    /**
     * Undocumented function
     */
    public function get()
    {
        $research = $this->research->get();
        $total_records = sizeof($research);
        $result = array(
            'iTotalRecords' => $total_records,
            'iTotalDisplayRecords' => $total_records,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $research
        );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Undocumented function
     */
    public function index()
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/results/research/view.php')) {
            show_404();
        }

        $data['title'] = ucfirst("Research list");
        $data['subTitle'] = ucfirst("Showing All");

        // Load page content
        $this->load->view('admin_panel/pages/results/research/view', $data);
    }

    /**
     * Undocumented function
     */
    public function create()
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/results/research/create.php')) {
            show_404();
        }

        $this->form_validation->set_rules('description', 'Short Description', 'required|max_length[85]');
        $this->form_validation->set_rules('url', 'URL', 'required|valid_url');
        $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');


        if ($this->form_validation->run() == true) {

            // POST data
            $description = $this->input->post('description');
            $url = $this->input->post('url');
            $field_id = $this->input->post('field_id');

            $this->research->create($description, $url, $field_id);

            // Display success flash message
            $this->session->set_flashdata('success', 1);

            redirect('/admin/results/research/add');
        }

        $data['title'] = ucfirst("Add Research");
        $data['fields'] = $this->fields->get_subcategories();

        $this->load->view('admin_panel/pages/results/research/create', $data);
    }

    /**
     * Undocumented function
     */
    public function make_link($id)
    {

        if (!file_exists(APPPATH . '/views/admin_panel/pages/results/research/make_link.php')) {
            show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[85]');
        $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display');
        $this->form_validation->set_rules('www', 'WWW', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');


        if ($this->form_validation->run() == true) {

            $title = $this->input->post('title');
            $description_short = $this->input->post('description_short');
            $display_url = $this->input->post('display_url');
            $www = $this->input->post('www');
            $field_id = $this->input->post('field_id');
            $priority = $this->input->post('priority');
            $enabled = $this->input->post('enabled');
            $redirect = $this->input->post('redirect');

            // create ad link
            $this->fields->create_result_listing($title, $enabled, $description_short, $display_url, $www, $field_id, $priority, $redirect);

            // delete the research link
            $this->delete($id);

            // Display success flash message
            $this->session->set_flashdata('success', 1);

            redirect('/admin/results/research/list');
        }

        $research = $this->research->get($id);

        $data['description'] = $research->description;
        $data['url'] = $research->url;
        $data['field']['id'] = $research->field_id;
        $data['field']['name'] = $research->field;

        $prioritiesObject = $this->fields->get_links_priority($research->field_id);
        $priorities = array();
        foreach ($prioritiesObject as $item) {
            array_push($priorities, $item->priority);
        }
        $data['priorities'] = $priorities;

        $data['title'] = ucfirst("Make Link");
        $this->load->view('admin_panel/pages/results/research/make_link', $data);
    }

    /**
     * Undocumented function
     */
    public function delete($id)
    {
        $this->research->delete($id);
    }
}
