<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/results/Suggestions.php
 *
 * A controller to manage suggestions on homepage, umbrellas and fields page
 * 
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Suggestions extends MY_Controller
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
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/results/Frontend_model', 'Frontend');
        $this->load->model('admin_panel/results/Umbrella_model', 'Umbrellas');
        $this->load->model('admin_panel/results/Field_model', 'Fields');
    }

    /**
     * Manage suggested results for fields
     *
     * @return void
     */
    public function field_suggestions()
    {
        if (!$this->ion_auth_acl->has_permission('frontend') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            // If requerst method is POST
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->input->post(NULL, TRUE);

                if (empty($data['item'])) {
                    $update = $this->Frontend->update_field_suggestions($data['fieldId'], null);
                } else {
                    // limit total items to 8
                    if (sizeof($data['item']) <= 7) {
                        $update =  $this->Frontend->update_field_suggestions($data['fieldId'], $data['item']);
                    } else {
                        $update = FALSE;
                    }
                }

                if ($update) {
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
            }

            // Set page data
            $data['fields'] = $this->Fields->get_by_status();
            $data['title'] = ucwords("suggestions | fields");

            // Load page content
            $this->load->view('admin_panel/pages/suggestions/fields', $data);
        }
    }

    /**
     * Get suggested results for fields
     *
     * @return void
     */
    public function get_field_suggestions($field_id)
    {
        if ($this->ion_auth_acl->has_permission('frontend') or $this->ion_auth->is_admin()) {
            $data['results'] = $this->Frontend->get_results();
            $data['suggestions'] = $this->Frontend->get_field_suggestions($field_id);
            echo json_encode($data);
        }
    }

    /**
     * Get suggested results for umbrellas
     *
     * @return void
     */
    public function get_umbrella_suggestions($umbrella_id)
    {
        if ($this->ion_auth_acl->has_permission('frontend') or $this->ion_auth->is_admin()) {
            $data['results'] = $this->Frontend->get_results();
            $data['suggestions'] = $this->Frontend->get_umbrella_suggestions($umbrella_id);
            echo json_encode($data);
        }
    }

    /**
     * Manage homepage results
     *
     * @return void
     */
    public function homepage()
    {
        if (!$this->ion_auth_acl->has_permission('frontend') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->input->post(NULL, TRUE);

                if (empty($data)) {
                    $update = $this->Frontend->update_homepage_fields($data);
                    if ($update) {
                        $this->session->set_flashdata('success', 1);
                    } else {
                        $this->session->set_flashdata('success', 0);
                    }
                } else {
                    // limit total items to 15
                    if (sizeof($data['item']) <= 15) {
                        $update = $this->Frontend->update_homepage_fields($data['item']);
                        if ($update) {
                            $this->session->set_flashdata('success', 1);
                        } else {
                            $this->session->set_flashdata('success', 0);
                        }
                    } else {
                        $this->session->set_flashdata('success', 0);
                    }
                }
            }

            $data['featured_results'] = $this->Frontend->get_featured_fields();
            $data['homepage_results'] = $this->Frontend->get_homepage_fields();

            // Load page content
            $data['title'] = ucwords("suggestions | homepage");
            $this->load->view('admin_panel/pages/suggestions/homepage', $data);
        }
    }

    /**
     *  Manage suggested results for umbrellas
     *
     * @return void
     */
    public function umbrella_suggestions()
    {
        if (!$this->ion_auth_acl->has_permission('frontend') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            // If request method is POST
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->input->post(NULL, TRUE);

                if (empty($data['item'])) {
                    $update = $this->Frontend->update_umbrella_suggestions($data['umbrellaId'], null);
                } else {
                    // limit total items to 8
                    if (sizeof($data['item']) <= 8) {
                        $update = $this->Frontend->update_umbrella_suggestions($data['umbrellaId'], $data['item']);
                    } else {
                        $update = FALSE;
                    }
                }

                if ($update) {
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
            }

            // Set page data
            $data['umbrellas'] = $this->Umbrellas->get_by_status();
            $data['title'] = ucwords("suggestions | umbrellas");

            // Load page content
            $this->load->view('admin_panel/pages/suggestions/umbrellas', $data);
        }
    }
}
