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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/results/Research_model', 'Research');
        $this->load->model('admin_panel/results/Field_model', 'Fields');
        $this->load->model('admin_panel/results/Link_model', 'Links');
    }

    /**
     * Get research links from database in JSON format
     * 
     * @return void
     */
    public function get()
    {
        $research = $this->Research->get();
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
     * Show research link page
     * 
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('links_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("Research list");
            $data['subTitle'] = ucfirst("Showing All");

            // Load page content
            $this->load->view('admin_panel/pages/results/research/view', $data);
        }
    }

    /**
     * Shows create page for research link and add research links on POST
     * 
     * @return void
     */
    public function create()
    {

        if (!$this->ion_auth_acl->has_permission('links_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[85]');
            $this->form_validation->set_rules('url', 'URL', 'required|valid_url');
            $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');


            if ($this->form_validation->run() == true) {

                // POST data
                $description_short = $this->input->post('description_short');
                $url = $this->input->post('url');
                $field_id = $this->input->post('field_id');

                $create = $this->Research->create($description_short, $url, $field_id);

                if ($create) {
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('failure', 0);
                }

                redirect('/admin/results/research/add');
            }

            $data['title'] = ucfirst("Add Research");
            $data['fields'] = $this->Fields->get_by_status();

            $this->load->view('admin_panel/pages/results/research/create', $data);
        }
    }

    /**
     * Shows make link page for research link and create add link or save research link on POST
     * 
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('links_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            if ($this->input->post('action') == 'save') {
                $this->form_validation->set_rules('title', 'Title', 'trim');
                $this->form_validation->set_rules('description_short', 'Short Description', 'required|trim|max_length[85]');
                $this->form_validation->set_rules('field_id', 'Field', 'required');
                $this->form_validation->set_rules('display_url', 'Home Display', 'trim');
                $this->form_validation->set_rules('url', 'URL', 'required|valid_url');
            } else if ($this->input->post('action') == 'make_link') {
                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('description_short', 'Short Description', 'trim|required|max_length[85]');
                $this->form_validation->set_rules('display_url', 'Home Display', 'trim');
                $this->form_validation->set_rules('url', 'URL', 'required|valid_url');
                $this->form_validation->set_rules('field_id', 'Field', 'required');
                $this->form_validation->set_rules('priority', 'Priority', 'required');
            }

            if ($this->form_validation->run() == true) {

                if ($this->input->post('action') == 'make_link') {

                    $link_data = array(
                        'title' => $this->input->post('title'),
                        'description_short' => $this->input->post('description_short'),
                        'www' => $this->input->post('url'),
                        'display_url' => $this->input->post('display_url'),
                        'sub_id' => $this->input->post('field_id'),
                        'priority' => $this->input->post('priority'),
                        'enabled' => $this->input->post('enabled'),
                        'redirect' => $this->input->post('redirect')
                    );

                    // create the link
                    $create = $this->Links->create($link_data);

                    if ($create) {
                        // delete the research link
                        $this->Research->delete($id);
                        $this->session->set_flashdata('make_link_success', 1);
                    } else {
                        $this->session->set_flashdata('make_link_failure', 0);
                    }
                } elseif (($this->input->post('action') == 'save')) {

                    $title = $this->input->post('title');
                    $description_short = $this->input->post('description_short');
                    $url = $this->input->post('url');
                    $display_url = $this->input->post('display_url');
                    $field_id = $this->input->post('field_id');
                    $enabled = $this->input->post('enabled');
                    $redirect = $this->input->post('redirect');

                    // save research link information
                    $update = $this->Research->update($id, $title, $description_short, $url, $display_url, $field_id, $enabled, $redirect);

                    if ($update) {
                        $this->session->set_flashdata('save_success', 1);
                    } else {
                        $this->session->set_flashdata('save_failure', 0);
                    }
                }

                redirect('/admin/results/research/list');
            }

            $research = $this->Research->get($id);

            $data['link_title'] = $research->title;
            $data['description_short'] = $research->description_short;
            $data['url'] = $research->url;
            $data['display_url'] = $research->display_url;
            $data['field']['id'] = $research->field_id;
            $data['field']['title'] = $research->field;
            $data['enabled'] = $research->enabled;
            $data['redirect'] = $research->redirect;


            $data['fields'] = $this->Fields->get_by_status();

            $prioritiesObject = $this->Links->get_links_priority($research->field_id);
            $priorities = array();
            foreach ($prioritiesObject as $item) {
                array_push($priorities, $item->priority);
            }
            $data['priorities'] = $priorities;

            $data['title'] = ucfirst("Research Link");
            $this->load->view('admin_panel/pages/results/research/edit', $data);
        }
    }

    /**
     * Delete research link
     * 
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('links_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Research->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
}
