<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is an admin panel controller.
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Frontend extends MY_Controller
{

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

        $this->load->model('admin_panel/Category_model_admin', 'categoryModel');
    }

    public function homepage()
    {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post(NULL, TRUE);
            if (empty($data)) $this->categoryModel->update_homepage_fields($data);
            else $this->categoryModel->update_homepage_fields($data['item']);

            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            Homepage has been successfully updated.
                    </div>
                </div>', 1);
        }

        $data['title'] = ucfirst("Hompage Fields");
        $data['featured_fields'] = $this->categoryModel->get_featured_fields();

        // $duplicate = array();
        // foreach ($data['featured_fields'] as $index => $item) {
        //     if (isset($duplicate[$item->id])) {
        //         unset($data['featured_fields'][$index]);
        //     } else
        //         $duplicate[$item->id] = true;
        // }   

        $data['homepage_fields'] = $this->categoryModel->get_homepage_fields();

        // Load page content
        $this->load->view('admin_panel/pages/frontend/homepage', $data);
    }

    public function umbrella_suggestions()
    {
        // If request method is POST
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post(NULL, TRUE);
            if (empty($data['item'])) $this->categoryModel->update_umbrella_suggestions($data['umbrellaId'], null);
            else $this->categoryModel->update_umbrella_suggestions($data['umbrellaId'], $data['item']);

            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            Umbrella suggestions has been successfully updated.
                    </div>
                </div>', 1);
        }

        // Set page data
        $data['umbrella'] = $this->categoryModel->get_categories();
        $data['title'] = ucfirst("Umbrella Suggestions");

        // Load page content
        $this->load->view('admin_panel/pages/frontend/umbrella_suggestions', $data);
    }

    public function field_suggestions()
    {
        // If requerst method is POST
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post(NULL, TRUE);
            if (empty($data['item'])) $this->categoryModel->update_field_suggestions($data['fieldId'], null);
            else $this->categoryModel->update_field_suggestions($data['fieldId'], $data['item']);

            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            Field suggestions has been successfully updated.
                    </div>
                </div>', 1);
        }

        // Set page data
        $data['fields'] = $this->categoryModel->get_subcategories();
        $data['title'] = ucfirst("Fields Suggestions");

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
        $data['fields'] = $this->categoryModel->get_subcategories();
        $data['suggestions'] = $this->categoryModel->get_field_suggestions($field_id);
        echo json_encode($data);
    }

    /**
     * Api to get field suggestions 
     *
     * @return void
     */
    public function get_umbrella_suggestions($umbrella_id)
    {
        $data['umbrella'] = $this->categoryModel->get_categories();
        $data['suggestions'] = $this->categoryModel->get_umbrella_suggestions($umbrella_id);
        echo json_encode($data);
    }
}
