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
     * Show brand links page
     *
     * @param active|inactive $status Status for the brandlinks
     * @return void
     */
    public function brandlinks($status)
    {
        if (!$this->ion_auth_acl->has_permission('links_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['status'] = $status;
            $data['heading'] = ucfirst($status);
            $data['title'] = ucfirst("Links");
            $this->load->view('admin_panel/pages/results/link/view_brandlinks', $data);
        }
    }

    /**
     * Creates a link
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

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[85]');
            $this->form_validation->set_rules('display_url', 'Home Display');
            $this->form_validation->set_rules('www', 'URL', 'required|valid_url');
            $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
            $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');

            if ($this->form_validation->run() === true) {

                $link_data = array(
                    'title' => $this->input->post('title'),
                    'description_short' => $this->input->post('description_short'),
                    'sub_id' => $this->input->post('field_id'),
                    'priority' => $this->input->post('priority'),
                    'display_url' => $this->input->post('display_url'),
                    'www' => $this->input->post('www'),
                    'redirect' => $this->input->post('redirect'),
                    'enabled' => $this->input->post('enabled'),
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
    }

    /**
     * Deletes a link
     *
     * @param int $id ID of a link
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {

            $delete = $this->links->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
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
        if (!$this->ion_auth_acl->has_permission('links_create') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $link = $this->links->get($id);

            $link_data = array(
                'title' => $link->title,
                'description_short' => $link->description_short,
                'sub_id' => $field_id,
                'priority' => $priority,
                'display_url' => $link->display_url,
                'www' => $link->www,
                'redirect' => $link->redirect,
                'enabled' => $link->enabled,
            );

            $duplicate = $this->links->create($link_data);

            if ($duplicate) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Gets a link
     *
     * @param int $id
     *
     * @return void
     */
    public function get($id = null)
    {
        if ($this->ion_auth_acl->has_permission('links_get') or $this->ion_auth->is_admin()) {
            $link = $this->links->get($id);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($link));
        }
    }

    /**
     * Get links by brand direct status
     *
     * @param active|inactive $status Status for the fields
     * @return void
     */
    public function get_by_branddirect_status($status = null)
    {
        if ($this->ion_auth_acl->has_permission('links_get') or $this->ion_auth->is_admin()) {
            $links = $this->links->get_by_branddirect_status($status);
            $total_links = sizeof($links);

            $result = array(
                'iTotalRecords' => $total_links,
                'iTotalDisplayRecords' => $total_links,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $links,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get links by field
     *
     * @param int $umbrella_id ID of umbrella
     * @param String $status Status of the fields
     * @return void
     */
    public function get_by_field($field_id, $status = null)
    {
        if ($this->ion_auth_acl->has_permission('links_get') or $this->ion_auth->is_admin()) {
            $links = $this->links->get_by_field($field_id, $status);
            $total_links = sizeof($links);

            $result = array(
                'iTotalRecords' => $total_links,
                'iTotalDisplayRecords' => $total_links,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $links,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get links based on keywords
     *
     * @param string $keywords Keywords for the title of the link
     * @return void
     */
    public function get_by_keywords($keywords = null)
    {
        if ($this->ion_auth_acl->has_permission('links_get') or $this->ion_auth->is_admin()) {
            $links = $this->links->get_by_keywords($keywords);
            $total_links = sizeof($links);

            $result = array(
                'iTotalRecords' => $total_links,
                'iTotalDisplayRecords' => $total_links,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $links,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get links by status
     *
     * @param active|inactive $status Status for the fields
     * @return void
     */
    public function get_by_status($status = null)
    {
        if ($this->ion_auth_acl->has_permission('links_get') or $this->ion_auth->is_admin()) {
            $links = $this->links->get_by_status($status);
            $total_links = sizeof($links);

            $result = array(
                'iTotalRecords' => $total_links,
                'iTotalDisplayRecords' => $total_links,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $links,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get clicks and impressions history based on month and year for the link
     *
     * @param int    $link_id          Link id
     * @param int    $month_and_year Month and Year
     * @return void
     */
    public function get_activity($link_id, $month_and_year = "")
    {
        $activity = $this->links->get_link_activity($link_id, $month_and_year);

        $total_activity = count($activity);
        $result = [
            'iTotalRecords' => $total_activity,
            'iTotalDisplayRecords' => $total_activity,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $activity,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Get monthly clicks history based on the year for the link
     *
     * @param int    $ad_id         Ad id
     * @param int    $year          Year
     * @return void
     */
    public function get_yearly_stats($link_id, $year = null)
    {
        if ($year == null) {
            $year = date('Y');
        }

        $yearly_stats = $this->links->get_ad_yearly_stats($link_id, $year);

        $clicks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($yearly_stats as $monthly_stats) {
            $clicks[$monthly_stats->month - 1] = $monthly_stats->clicks;
        }

        $stats['clicks'] = $clicks;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($stats));
    }

    /**
     * View page for Ad clicks history
     *
     * @param int $id Ad id
     * @return void
     */
    public function view_activity($id)
    {
        $link = $this->links->get($id);
        $stats = $this->links->get_ad_yearly_stats($id, date('Y'));
        $year = $this->links->get_oldest_activity_year($id);

        $clicks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($stats as $activity) {
            $clicks[$activity->month - 1] = $activity->clicks;
        }

        $link->monthly_clicks = $clicks;
        $link->oldest_activity_year = $year;

        // page data
        $data['link'] = $link;

        // Load page content
        $data['title'] = ucwords('link - click activity');
        $this->load->view('admin_panel/pages/results/link/activity', $data);
    }

    /**
     * Show links page
     *
     * @param int|active|inactive|search $value Id of the field or status for the links or keyword search
     * @return void
     */
    public function index($value)
    {
        if (!$this->ion_auth_acl->has_permission('links_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['fields'] = $this->fields->get_by_status();

            $data['title'] = ucfirst("Links");

            if (is_numeric($value)) {
                $data['field_id'] = $value;
                $field_name = $this->fields->get($value)->title;
                $data['heading'] = ucfirst($field_name);
                $this->load->view('admin_panel/pages/results/link/view_by_field', $data);
            } else if ($value == "search") {
                $this->load->view('admin_panel/pages/results/link/search', $data);
            } else {
                $data['status'] = $value;
                $data['heading'] = ucfirst($value);
                $this->load->view('admin_panel/pages/results/link/view', $data);
            }
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
        if (!$this->ion_auth_acl->has_permission('links_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $link = $this->links->get($id);

            $link_data = array(
                'title' => $link->title,
                'description_short' => $link->description_short,
                'sub_id' => $field_id,
                'priority' => $priority,
                'display_url' => $link->display_url,
                'www' => $link->www,
                'redirect' => $link->redirect,
                'enabled' => $link->enabled,
            );

            $move = $this->links->update($id, $link_data);

            if ($move) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
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
        if (!$this->ion_auth_acl->has_permission('links_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {

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
    }

    /**
     * Toggle link  status
     *
     * @param int $id ID of the link
     * @return void
     */
    public function toggle($id)
    {

        if (!$this->ion_auth_acl->has_permission('links_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
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
    }

    /**
     * Updates a link
     *
     * @param int $id ID of a link
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('links_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[85]');
            $this->form_validation->set_rules('display_url', 'Home Display');
            $this->form_validation->set_rules('www', 'URL', 'required|valid_url');
            $this->form_validation->set_rules('field_id', 'Field', 'required|numeric');
            $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');

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
                    'title' => $this->input->post('title'),
                    'description_short' => $this->input->post('description_short'),
                    'sub_id' => $this->input->post('field_id'),
                    'priority' => $this->input->post('priority'),
                    'display_url' => $this->input->post('display_url'),
                    'www' => $this->input->post('www'),
                    'redirect' => $this->input->post('redirect'),
                    'enabled' => $this->input->post('enabled'),
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
        if (!$this->ion_auth_acl->has_permission('links_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            // make sure priority value is within limits (1 to 250)
            if ($priority < 1 || $priority > 250) {
                echo json_encode(0);
                return;
            }

            $links = $this->links->get_by_field($this->input->post('field_id'));

            // check if the priority number is already taken
            foreach ($links as $link) {
                if ($link->priority == $priority) {
                    echo json_encode(0);
                    return;
                }
            }

            $link_data = array(
                'priority' => $priority,
            );

            $update = $this->links->update($id, $link_data);

            if ($update) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
}
