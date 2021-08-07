<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/brands/Keywords.php
 *
 * A controller for brand keywords
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
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

        if (!$this->ion_auth->logged_in()) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/brands/keywords_model', 'Keywords');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
    }

    /**
     * Approve brand keywords
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function approve($id)
    {
        if (!$this->ion_auth_acl->has_permission('brands_keywords_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $keyword_data = array(
                'active' => 1,
                'approved' => 1
            );

            $update = $this->Keywords->update($id, $keyword_data);

            if ($update) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Create brandlink for brand
     *
     * @param int $brand_id Brand ID
     * @return void
     */
    public function create($brand_id)
    {
        if (!$this->ion_auth_acl->has_permission('brandlinks_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('keywords', 'BrandLink Keyword', 'trim|required');
            $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required');
            $this->form_validation->set_rules('active', 'Enabled', 'trim|required');

            if ($this->form_validation->run() == false) {
                $data['brand_id'] = $brand_id;

                // set page title
                $data['title'] = ucwords("add BrandLink");

                $this->load->view('admin_panel/pages/brands/brandlinks/create', $data);
            } else {

                $data['keywords'] = $this->input->post('keywords');
                $data['url'] = $this->input->post('url');
                $data['active'] = $this->input->post('active');
                $data['approved'] = 1;
                $data['brand_id'] = $this->input->post('brand_id');

                $create = $this->Keywords->create($data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/brands/brandlinks/brand/id/$brand_id");
            }
        }
    }

    /**
     * Delete a keyword
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('brands_keywords_delete') && !$this->ion_auth->is_admin()) {
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
     * Get brandlinks
     *
     * @param int $brand_id Brand ID
     * @return void
     */
    public function get($brand_id = false)
    {
        if ($this->ion_auth_acl->has_permission('brands_keywords_get') or $this->ion_auth->is_admin()) {
            $keywords = $this->Keywords->get($brand_id);
            $total_keywords = count($keywords);
            $result = array(
                'iTotalRecords' => $total_keywords,
                'iTotalDisplayRecords' => $total_keywords,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $keywords,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for brandlinks
     *
     * @return object
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brands_keywords_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("BrandLinks");

            // Load page content
            $this->load->view('admin_panel/pages/brands/keywords', $data);
        }
    }

    /**
     * Toggle brand keywords status
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('brands_keywords_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $keyword = $this->Keywords->get_by_id($id);

            if ($keyword->active == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $keyword_data = array(
                'active' => $status,
            );

            $this->Keywords->update($id, $keyword_data);

            echo json_encode($status);
        }
    }

    /**
     * Update brandlink
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('brandlinks_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('keywords', 'BrandLink Keyword', 'trim|required');
            $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required');
            $this->form_validation->set_rules('active', 'Enabled', 'trim|required');

            $brandlink = $this->Keywords->get_by_id($id);

            if ($this->form_validation->run() == false) {
                $data['brandlink'] = $brandlink;

                // set page title
                $data['title'] = ucwords("update BrandLink");

                $this->load->view('admin_panel/pages/brands/brandlinks/edit', $data);
            } else {

                $data['keywords'] = $this->input->post('keywords');
                $data['url'] = $this->input->post('url');
                $data['active'] = $this->input->post('active');
                $data['brand_id'] = $this->input->post('brand_id');

                $update = $this->Keywords->update($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/brands/brandlinks/brand/id/$brandlink->brand_id");
            }
        }
    }

    /**
     * View page for brandlinks for particular brand
     *
     * @param int $brand_id Brand ID
     * @return void
     */
    public function view_by_brand($brand_id)
    {
        if (!$this->ion_auth_acl->has_permission('brands_keywords_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("BrandLinks");
            $data['brand'] = $this->Brand->get($brand_id);

            // Load page content
            $this->load->view('admin_panel/pages/brands/brandlinks/view', $data);
        }
    }
}
