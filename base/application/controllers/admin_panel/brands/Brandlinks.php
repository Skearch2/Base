<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/brands/Brandlinks.php
 *
 * A controller for BrandLinks
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2021
 * @version      2.0
 */
class Brandlinks extends MY_Controller
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

        $this->load->model('admin_panel/brands/brandlink_model', 'Brandlinks');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
        $this->load->model('Keywords_model', 'Keywords');
    }

    /**
     * Approve Brandlinks
     *
     * @param int $id Brandlink ID
     * @return void
     */
    public function approve($id)
    {
        if (!$this->ion_auth_acl->has_permission('brandlinks_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $brandlink_data = array(
                'active' => 1,
                'approved' => 1
            );

            $update = $this->Brandlinks->update($id, $brandlink_data);

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
            $this->form_validation->set_rules('keyword', 'BrandLink Keyword', 'trim|required|callback_validate_keyword');
            $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required|valid_url');
            $this->form_validation->set_rules('active', 'Enabled', 'trim|required');

            if ($this->form_validation->run() == false) {
                $data['brand_id'] = $brand_id;

                // set page title
                $data['title'] = ucwords("add BrandLink");

                $this->load->view('admin_panel/pages/brands/brandlinks/create', $data);
            } else {

                $data['keyword'] = $this->input->post('keyword');
                $data['url'] = $this->input->post('url');
                $data['active'] = $this->input->post('active');
                $data['approved'] = 1;
                $data['brand_id'] = $this->input->post('brand_id');

                $create = $this->Brandlinks->create($data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/brands/brandlinks/brand_id/$brand_id");
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
        if (!$this->ion_auth_acl->has_permission('brandlinks_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Brandlinks->delete($id);

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
        if ($this->ion_auth_acl->has_permission('brandlinks_get') or $this->ion_auth->is_admin()) {
            $brandlinks = $this->Brandlinks->get($brand_id);
            $total_brandlinks = count($brandlinks);
            $result = array(
                'iTotalRecords' => $total_brandlinks,
                'iTotalDisplayRecords' => $total_brandlinks,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $brandlinks,
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
        if (!$this->ion_auth_acl->has_permission('brandlinks_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("BrandLinks");

            // Load page content
            $this->load->view('admin_panel/pages/brands/brandlinks/view', $data);
        }
    }

    /**
     * Toggle brand Brandlinks status
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('brandlinks_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $brandlink = $this->Brandlinks->get_by_id($id);

            if ($brandlink->active == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            $brandlink_data = array(
                'active' => $status,
            );

            $this->Brandlinks->update($id, $brandlink_data);

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
            $this->form_validation->set_rules('keyword', 'BrandLink Keyword', 'trim|required|callback_validate_keyword[' . $id . ']');
            $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required|valid_url');
            $this->form_validation->set_rules('active', 'Enabled', 'trim|required');

            $brandlink = $this->Brandlinks->get_by_id($id);

            if ($this->form_validation->run() == false) {
                $data['brandlink'] = $brandlink;

                // set page title
                $data['title'] = ucwords("update BrandLink");

                $this->load->view('admin_panel/pages/brands/brandlinks/edit', $data);
            } else {

                $data = [
                    'brand_id' => $this->input->post('brand_id'),
                    'keyword' => $this->input->post('keyword'),
                    'url' => $this->input->post('url'),
                    'active' => $this->input->post('active'),
                    'last_updated' => date("Y-m-d H:i:s")
                ];

                $update = $this->Brandlinks->update($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/brands/brandlinks/brand_id/$brandlink->brand_id");
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
        if (!$this->ion_auth_acl->has_permission('brandlinks_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("BrandLinks");
            $data['brand'] = $this->Brand->get($brand_id);

            // Load page content
            $this->load->view('admin_panel/pages/brands/brandlinks/view_by_brand', $data);
        }
    }

    /**
     * Validate keyword
     *
     * @param string $keyword Keyword
     * @return void
     */
    public function validate_keyword($keyword, $id = null)
    {
        if ($this->Brandlinks->duplicate_check($keyword)) {
            if (empty($id)) {
                $this->form_validation->set_message('validate_keyword', "%s already exists.");
                return false;
            } else {
                if ($this->Brandlinks->get_by_id($id)->keyword !== $keyword) {
                    $this->form_validation->set_message('validate_keyword', "%s already exists.");
                    return false;
                }
            }
        }

        if ($this->Keywords->duplicate_check($keyword)) {
            $this->form_validation->set_message('validate_keyword', "%s already exists as a Search keyword.");
            return false;
        }

        return true;
    }
}
