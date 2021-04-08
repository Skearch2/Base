<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/admin_panel/Ads_manager.php.
 *
 * Ads manager controller
 *
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 *
 * @version		2.0
 */
class Ads_manager extends MY_Controller
{
    /**
     * Constructor.
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

        $this->load->model('admin_panel/ads_manager_model', 'ads_manager');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
        $this->load->model('admin_panel/results/umbrella_model', 'umbrellas');
        $this->load->model('admin_panel/results/field_model', 'fields');
    }

    /**
     * Toggle ad's active status.
     *
     * @param int $id Ad ID
     *
     * @return void
     */
    public function toggle_archive($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $is_archived = $this->ads_manager->get_ad($id)->is_archived;

            if ($is_archived == 0) {
                $is_archived = 1;
            } else {
                $is_archived = 0;
            }

            $data = [
                'priority' => 0,
                'is_active' => 0,
                'is_archived' => $is_archived

            ];

            $update = $this->ads_manager->update_ad($id, $data);

            echo json_encode($update);
        }
    }

    /**
     * Create ad
     *
     * @param string $scope  Ad visibilty scope - default|global|umbrella|field
     * @param int $scope_id  Scope id
     * @param string $banner Ad banner - a|b|u|va
     *
     * @return void
     */
    public function create($scope, $scope_id, $banner)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('brand', 'Brand', 'required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('url', 'Link Reference', 'trim|required|valid_url');
            $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
            $this->form_validation->set_rules('has_sign', 'Sponsored', 'required|numeric');
            $this->form_validation->set_rules('is_active', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {
                // page data
                $data['scope'] = $scope;
                $data['banner'] = $banner;
                $data['brands'] = $this->Brand->get();
                $data['title'] = ucwords('create ad');

                $this->load->view('admin_panel/pages/ads_manager/create', $data);
            } else {

                $data = [
                    'banner_id' => $this->ads_manager->get_banner($scope, $scope_id, $banner)->id,
                    'brand_id'  => $this->input->post('brand'),
                    'title'     => $this->input->post('title'),
                    'media'     => $this->upload_media($scope, $scope_id),
                    'url'       => $this->input->post('url'),
                    'duration'  => $this->input->post('duration'),
                    'has_sign'  => $this->input->post('has_sign'),
                    'is_active' => $this->input->post('is_active'),
                ];

                $create = $this->ads_manager->create_ad($data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }

                if ($scope_id == 0) {
                    redirect("admin/ads/manager/view/$scope/banner/$banner/show/library");
                } else {
                    redirect("admin/ads/manager/view/$scope/id/$scope_id/banner/$banner/show/library");
                }
            }
        }
    }

    /**
     * Ads manager dashboard
     * Shows type of ads to choose from.
     *
     * @return void
     */
    public function index()
    {
        $data['umbrellas'] = $this->umbrellas->get_by_status();
        $data['fields'] = $this->fields->get_by_status();

        // Load page content
        $data['title'] = ucwords('ads manager');
        $this->load->view('admin_panel/pages/ads_manager/dashboard', $data);
    }

    /**
     * Get list of ads based on the following factors
     * Scope, Scope ID, Banner, and if archived or not
     *
     * @param string $scope          Scope: Default|Global|Umbrella|Field
     * @param int $scope_id          Scope id
     * @param string $banner         Banner: A|B|U|VA
     * @param bool $is_archvied      Is ad archived?
     * @return void
     */
    public function get($scope, $scope_id, $banner, $is_archived = 0)
    {
        $ads = $this->ads_manager->get_ads($banner, $scope, $scope_id, $is_archived);

        $total_ads = count($ads);
        $result = [
            'iTotalRecords' => $total_ads,
            'iTotalDisplayRecords' => $total_ads,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $ads,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * View page for default/global ads.
     *
     * @param string $scope    Scope: Default|Global
     * @param string $banner   Banner: A|B|U|VA
     * @param string $view     View: Library|Archived
     * @return void
     */
    public function view($scope, $banner, $view)
    {
        // page data
        $data['scope'] = $scope;
        $data['banner'] = $banner;
        if ($view == 'archived') {
            $data['is_archived'] = 1;
        } else {
            $data['is_archived'] = 0;
        }

        // Load page content
        $data['title'] = ucwords('ads manager');
        $this->load->view('admin_panel/pages/ads_manager/view', $data);
    }

    /**
     * View page for umbrella/field ads.
     *
     * @param string $scope    Scope: Umbrella|Field
     * @param int    $scope_id Scope id (Umbrella or Field ID)
     * @param string $banner   Banner: A|B|U
     * @param string $view     View: Library|Archived
     * @return void
     */
    public function view_by_page($scope, $scope_id, $banner, $view)
    {
        $folder_path = strtolower("{$scope}/{$scope_id}");

        // structure example: base/media/umbrella/123/
        $structure = './base/media/' . $folder_path . "/";

        // create media folder for selected umbrella or field
        if (!is_dir($structure)) {
            if (mkdir($structure, 0755, TRUE)) {
                $this->ads_manager->create_banner($scope, $scope_id, $banner, $folder_path);
            } else {
                show_error('Unable to create media folder.', 500, 'Internal Server Error');
            }
        }

        if ($scope == 'umbrella') {
            $umbrellas = $this->umbrellas->get_by_status();
            foreach ($umbrellas as $umbrella) {
                if ($umbrella->id == $scope_id) {
                    $data['umbrella'] = $umbrella->title;
                }
            }
        } elseif ($scope == 'field') {
            $fields = $this->fields->get_by_status();
            foreach ($fields as $field) {
                if ($field->id == $scope_id) {
                    $data['field'] = $field->title;
                }
            }
        }

        // page data
        $data['scope'] = $scope;
        $data['scope_id'] = $scope_id;
        $data['banner'] = $banner;
        if ($view == 'archived') {
            $data['is_archived'] = 1;
        } else {
            $data['is_archived'] = 0;
        }

        // Load page content
        $data['title'] = ucwords('ads manager');
        $this->load->view('admin_panel/pages/ads_manager/view_by_page', $data);
    }

    /**
     * Get ad click history
     *
     * @param int    $ad_id         Ad id
     * @param string $start_date    Start date
     * @param string $end_date      End date
     * @return void
     */
    public function get_activity($ad_id, $start_date = null, $end_date = null)
    {
        $clicks = $this->ads_manager->get_ad_activity($ad_id, $start_date, $end_date);

        $total_clicks = count($clicks);
        $result = [
            'iTotalRecords' => $total_clicks,
            'iTotalDisplayRecords' => $total_clicks,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $clicks,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * View page for Ad clicks history
     *
     * @param int $id Ad id
     * @return void
     */
    public function view_activity($id)
    {
        // page data
        $data['ad'] = $this->ads_manager->get_ad($id);

        // Load page content
        $data['title'] = ucwords('ads manager');
        $this->load->view('admin_panel/pages/ads_manager/activity', $data);
    }

    /**
     * Toggle ad's active status.
     *
     * @param int $id Ad ID
     *
     * @return void
     */
    public function toggle($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $is_active = $this->ads_manager->get_ad($id)->is_active;

            if ($is_active == 0) {
                $is_active = 1;
            } else {
                $is_active = 0;
            }

            $data = [
                'is_active' => $is_active,
            ];

            $this->ads_manager->update_ad($id, $data);

            echo json_encode($is_active);
        }
    }

    /**
     * Update an ad.
     *
     * @param int $id Ad ID
     * @param string $scope          Scope: Default|Global|Umbrella|Field
     * @param int $scope_id          Scope id
     * @param string $banner         Banner: A|B|U|VA
     *
     * @return void
     */
    public function update($id, $scope, $scope_id, $banner)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('brand', 'Brand', 'required|numeric');
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('url', 'Link Reference', 'trim|required|valid_url');
            $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
            $this->form_validation->set_rules('has_sign', 'Sponsored', 'required|numeric');
            $this->form_validation->set_rules('is_active', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {

                // page data
                $data['brands'] = $this->Brand->get();
                $data['ad'] = $this->ads_manager->get_ad($id);
                $data['title'] = ucwords('edit ad');

                $this->load->view('admin_panel/pages/ads_manager/edit', $data);
            } else {
                $data = [
                    'brand_id' => $this->input->post('brand'),
                    'title' => $this->input->post('title'),
                    'url' => $this->input->post('url'),
                    'duration' => $this->input->post('duration'),
                    'has_sign' => $this->input->post('has_sign'),
                    'is_active' => $this->input->post('is_active'),
                ];

                if ($_FILES['media']['error'] == 0) {
                    $data['media'] = $this->upload_media($scope, $scope_id);
                }

                $update = (int) $this->ads_manager->update_ad($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }

                if ($scope_id == 0) {
                    redirect("admin/ads/manager/view/$scope/banner/$banner/show/library");
                } else {
                    redirect("admin/ads/manager/view/$scope/id/$scope_id/banner/$banner/show/library");
                }
            }
        }
    }

    /**
     * Upload media
     *
     * @param string $scope          Scope: Default|Global|Umbrella|Field
     * @param int $scope_id          Scope id
     * @return string|false
     */
    private function upload_media($scope, $scope_id)
    {
        $tmp = $this->config->item('tmp_dir');

        if (!file_exists("./$tmp/")) {
            mkdir("./$tmp/", $this->config->item('tmp_permissions'));
        }

        $config['upload_path'] = "./$tmp/";
        $config['max_size'] = $this->config->item('upload_file_size');
        $config['allowed_types'] = $this->config->item('upload_file_types');
        $config['encrypt_name'] = true;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $upload = $this->upload->do_upload('media');

        if ($upload) {

            // $data = $this->upload->data();
            // http_response_code(200);
            // echo json_encode($data['media']);

            $media = $this->upload->data();

            if ($scope_id == 0) {
                $folder_path = FCPATH . 'base/media/' . strtolower($scope)  . "/";
            } else {
                $folder_path = FCPATH . 'base/media/' . strtolower("{$scope}/{$scope_id}"  . "/");
            }

            if (move_uploaded_file($_FILES['media']['tmp_name'], $folder_path . $media['file_name'])) {
                return $media['file_name'];
            } else {
                log_message('error', 'Unable to upload media.');
                return false;
            }
        } else {
            log_message('error', 'Unable to upload media.');
            return false;
            // http_response_code(500);
            // echo json_encode($this->upload->display_errors());
        }
    }
}
