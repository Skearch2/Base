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
        $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display');
        $this->form_validation->set_rules('www', 'URL', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

        if ($this->form_validation->run() === true) {

            $link_data = array(
                'title'             => $this->input->post('title'),
                'description_short' => $this->input->post('description_short'),
                'sub_id'            => $this->input->post('field_id'),
                'priority'          => $this->input->post('priority'),
                'display_url'       => $this->input->post('display_url'),
                'www'               => $this->input->post('www'),
                'redirect'          => $this->input->post('redirect'),
                'enabled'           => $this->input->post('enabled')
            );

            $create = $this->links->create($link_data);

            if ($create) {
                $this->session->set_flashdata('create_success', 1);
                redirect('/admin/results/link/create');
            } else {
                $this->session->set_flashdata('create_success', 0);
            }
        }

        $data['fields'] = $this->fields->get_by_status();

        $data['title'] = ucwords("add link");
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
        $this->links->delete($id);
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

        $link_data = array(
            'title'             => $link->title,
            'description_short' => $link->description_short,
            'sub_id'            => $field_id,
            'priority'          => $priority,
            'display_url'       => $link->display_url,
            'www'               => $link->www,
            'redirect'          => $link->redirect,
            'enabled'           => $link->enabled
        );

        $this->links->create($link_data);
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

    /**
     * Show links page
     *
     * @param int|string $value
     * @return void
     */
    public function index($value)
    {
        $data['fields'] = $this->fields->get_by_status();

        $data['title'] = ucfirst("Links");

        if ($value != NULL && is_numeric($value)) {
            $data['field_id'] = $value;
            $field_title = $this->fields->get($value)->title;
            $data['heading'] = ucfirst($field_title);
            $this->load->view('admin_panel/pages/results/link/view_by_field', $data);
        } else if ($value != NULL && strcmp($value, "search") === 0) {
            $this->load->view('admin_panel/pages/results/link/search', $data);
        } else {
            $data['status'] = $value;
            $data['heading'] = ucfirst($value);
            $this->load->view('admin_panel/pages/results/link/view', $data);
        }
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
        $link = $this->links->get($id);

        $link_data = array(
            'title'             => $link->title,
            'description_short' => $link->description_short,
            'sub_id'            => $field_id,
            'priority'          => $priority,
            'display_url'       => $link->display_url,
            'www'               => $link->www,
            'redirect'          => $link->redirect,
            'enabled'           => $link->enabled
        );

        $this->links->update($id, $link_data);
    }


    /**
     * Get priorities of the links for the given field id
     *
     * @param int $id ID of the field
     * @return void
     */
    public function priorities($field_id)
    {
        $priorities = $this->links->get_by_field($field_id);

        // $this->output
        //     ->set_content_type('application/json')
        //     ->set_output(json_encode($priorities));

        echo json_encode($priorities);
    }

    /**
     * Toggle redirection for the link
     *
     * @param int $id ID of the link
     * @return void
     */
    public function redirect($id)
    {
        $status = $this->links->get($id)->redirect;

        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        $link_data = array(
            'redirect' => $status,
        );

        $this->links->update($id, $link_data);

        echo json_encode($status);
    }

    /**
     * Toggle link  status
     *
     * @param int $id ID of the link
     * @return void
     */
    public function toggle($id)
    {
        $status = $this->links->get($id)->enabled;

        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        $link_data = array(
            'enabled' => $status,
        );

        $this->links->update($id, $link_data);

        echo json_encode($status);
    }

    /**
     * Updates a link
     *
     * @param int $id ID of a link
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display');
        $this->form_validation->set_rules('www', 'URL', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

        if ($this->form_validation->run() === false) {

            $data['link'] = $this->links->get($id);

            // get all fields
            $data['fields'] = $this->fields->get_by_status();

            // $prioritiesObject = $this->categoryModel->get_links_priority($this->categoryModel->get_result_parent($id));
            // $priorities = array();
            // foreach ($prioritiesObject as $item) {
            //     array_push($priorities, $item->priority);
            // }

            // $data['priorities'] = $priorities;

            $data['title'] = ucfirst("edit link");
            $this->load->view('admin_panel/pages/results/link/edit', $data);
        } else {

            $link_data = array(
                'title'             => $this->input->post('title'),
                'description_short' => $this->input->post('description_short'),
                'sub_id'            => $this->input->post('field_id'),
                'priority'          => $this->input->post('priority'),
                'display_url'       => $this->input->post('display_url'),
                'www'               => $this->input->post('www'),
                'redirect'          => $this->input->post('redirect'),
                'enabled'           => $this->input->post('enabled')
            );

            $update = $this->links->update($id, $link_data);

            if ($update) {
                $this->session->set_flashdata('update_success', 1);
                redirect('/admin/results/links/search');
            } else {
                $this->session->set_flashdata('update_success', 0);
            }
        }
    }

    /**
     * Update priority of the link
     *
     * @param int $id ID of the link
     * @param int $priority Priority for the link
     * @return void
     */
    public function update_priority($id, $priority)
    {
        $link_data = array(
            'priority' => $priority,
        );

        $this->links->update($id, $link_data);
    }
}
