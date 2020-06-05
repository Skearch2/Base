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
     * Get all brands keywords
     *
     * @return object
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('brands_keywords_get') or $this->ion_auth->is_admin()) {
            $keywords = $this->Keywords->get();
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
     * View page for brand keywords
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

            $data['title'] = ucfirst("Brands Keywords");

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
            $status = $this->Keywords->get($id)->active;

            if ($status == 0) {
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
}
