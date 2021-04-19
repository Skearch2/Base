<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/admin_panel/brands/Vault.php.
 *
 * Media vault controller for admin panel
 *
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 *
 * @version		2.0
 */
class Vault extends MY_Controller
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

        $this->load->model('admin_panel/ads_manager_model', 'Ads_manager');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
        $this->load->model('admin_panel/brands/vault_model', 'Vault');
        $this->load->model('admin_panel/results/umbrella_model', 'Umbrellas');
        $this->load->model('admin_panel/results/field_model', 'Fields');
    }

    /**
     * Get media from brand media vault
     *
     * @param string $brand_id  Brand ID
     * @return void
     */
    public function get($brand_id)
    {
        $media = $this->Vault->get($brand_id);

        $total_media = count($media);
        $result = [
            'iTotalRecords' => $total_media,
            'iTotalDisplayRecords' => $total_media,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $media,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * View page for brand media vault
     *
     * @param string $brand_id  Brand ID
     * @return void
     */
    public function index($brand_id)
    {
        // page data
        $data['brand'] = $this->Brand->get($brand_id);

        // Load page content
        $data['title'] = ucwords('media vault');
        $this->load->view('admin_panel/pages/brands/vault/view', $data);
    }

    /**
     * Create ad from media in the brand's vault.
     *
     * @param int $brand_id Brand ID
     * @param int $brand_id Media ID
     * @return void
     */
    public function create_ad($brand_id, $media_id)
    {
        if (!$this->ion_auth_acl->has_permission('umbrellas_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('url', 'Link Reference', 'trim|required|valid_url');
            $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
            $this->form_validation->set_rules('has_sign', 'Sponsored', 'required|numeric');
            $this->form_validation->set_rules('is_active', 'Enabled', 'required|numeric');
            $this->form_validation->set_rules('scope', 'Scope', 'required');
            $this->form_validation->set_rules('scope_id', 'Scope Id', 'required|numeric');
            $this->form_validation->set_rules('banner', 'Banner', 'required');

            if ($this->form_validation->run() === false) {

                // page data
                $data['brand']   = $this->Brand->get($brand_id);
                $data['media'] = $this->Vault->get_media($media_id);
                $data['umbrellas'] = $this->Umbrellas->get_by_status();
                $data['fields'] = $this->Fields->get_by_status();

                // page content
                $data['title'] = ucwords('create ad');
                $this->load->view('admin_panel/pages/brands/vault/create_ad', $data);
            } else {

                $media = $this->Vault->get_media($media_id);
                $scope = $this->input->post('scope');
                $scope_id = $this->input->post('scope_id');
                $banner = $this->input->post('banner');

                $folder = strtolower("$scope/$scope_id");

                $target = '.base/media/vault/brand_' . $this->brand_id  . "/";
                $destination = './base/media/' . $folder . "/";

                if (isset($scope_id) && $scope_id != 0) {
                    if (!is_dir($destination)) {
                        if (mkdir($destination, 0755, TRUE)) {
                            $this->ads_manager->create_banner($scope, $scope_id, $banner, $folder);
                            copy("$target{$media->media}", "$destination{$media->media}");
                        } else {
                            show_error('Unable to create media folder.', 500, 'Internal Server Error');
                        }
                    }
                }

                $data = [
                    'brand_id' => $this->input->post('brand'),
                    'title' => $this->input->post('title'),
                    'url' => $this->input->post('url'),
                    'duration' => $this->input->post('duration'),
                    'has_sign' => $this->input->post('has_sign'),
                    'is_active' => $this->input->post('is_active'),
                ];

                $create = $this->ads_manager->create_ad($data);

                if ($update) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }

                redirect("admin/brands/vault/brand/id/1");
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
