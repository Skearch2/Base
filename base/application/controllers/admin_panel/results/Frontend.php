<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/results/Frondend.php
 *
 * A controller to manage results on homepage and suggestions on 
 * umbrellas and fields page
 * 
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Frontend extends MY_Controller
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
     * Undocumented function
     *
     * @return void
     */
    public function homepage()
    {
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
        $data['title'] = ucfirst("Homepage Results");
        $this->load->view('admin_panel/pages/frontend/homepage', $data);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function umbrella_suggestions()
    {
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
        $data['title'] = ucfirst("Related Umbrellas");

        // Load page content
        $this->load->view('admin_panel/pages/frontend/umbrella_suggestions', $data);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function field_suggestions()
    {
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
        $data['title'] = ucfirst("Related Fields");

        // Load page content
        $this->load->view('admin_panel/pages/frontend/field_suggestions', $data);
    }


    /**
     * Api to get field suggestions 
     *
     * @return void
     */
    public function get_field_suggestions($field_id)
    {
        $data['results'] = $this->Frontend->get_results();
        $data['suggestions'] = $this->Frontend->get_field_suggestions($field_id);
        echo json_encode($data);
    }

    /**
     * Api to get field suggestions 
     *
     * @return void
     */
    public function get_umbrella_suggestions($umbrella_id)
    {
        $data['results'] = $this->Frontend->get_results();
        $data['suggestions'] = $this->Frontend->get_umbrella_suggestions($umbrella_id);
        echo json_encode($data);
    }
}
