<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/admin_panel/brands/Ads.php.
 *
 * Controller for Ads within Brands
 *
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 *
 * @version		2.0
 */
class Ads extends MY_Controller
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

        $this->load->model('admin_panel/brands/vault_model', 'media_vault');
        $this->load->model('admin_panel/ads_manager_model', 'ads_manager');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
        $this->load->model('admin_panel/results/field_model', 'Field');
        $this->load->model('admin_panel/results/umbrella_model', 'Umbrella');
    }

    /**
     * Create an ad
     *
     * @param int $brand_id  Brand ID
     * @return void
     */
    public function create($brand_id)
    {
        if (!$this->ion_auth_acl->has_permission('ads_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('url', 'Link Reference', 'trim|callback_url_check');
            $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
            $this->form_validation->set_rules('has_sign', 'Sponsored', 'required|numeric');
            $this->form_validation->set_rules('is_active', 'Enabled', 'required|numeric');

            if ($this->form_validation->run() === false) {

                // page data
                $data['brand'] = $this->Brand->get($brand_id);
                $data['umbrellas'] = $this->Umbrella->get_by_status();
                $data['fields'] = $this->Field->get_by_status();
                $data['title'] = ucwords('create ad');

                $this->load->view('admin_panel/pages/brands/ads/create', $data);
            } else {

                $scope = $this->input->post('scope');
                if ($scope == 'umbrella') {
                    $scope_id = $this->input->post('umbrella');
                } elseif ($scope == 'field') {
                    $scope_id = $this->input->post('field');
                } else {
                    $scope_id = 0;
                }
                $banner = $this->input->post('banner');

                $current_banner = $this->ads_manager->get_banner($scope, $scope_id, $banner);

                // get banner otherwise create new banner
                if ($current_banner) {
                    $banner_id = $current_banner->id;
                } else {
                    $folder = strtolower("$scope/$scope_id");
                    $banner_id = $this->ads_manager->create_banner($scope, $scope_id, $banner, $folder);
                }

                $last_priority = $this->ads_manager->get_last_priority($banner_id)->priority;
                $priority = $last_priority + 1;

                $data = [
                    'banner_id' => $banner_id,
                    'brand_id'  => $brand_id,
                    'title'     => $this->input->post('title'),
                    'media'     => $this->upload_media($scope, $scope_id),
                    'url'       => $this->input->post('has_no_url') == 1 ? '' : $this->input->post('url'),
                    'duration'  => $this->input->post('duration'),
                    'has_sign'  => $this->input->post('has_sign'),
                    'is_active' => $this->input->post('is_active'),
                    'priority'  => $priority
                ];

                $ad_id = (int) $this->ads_manager->create_ad($data);

                if ($ad_id) {
                    $this->copy_to_media_vault($ad_id);
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }

                redirect("admin/brands/ads/brand/id/$brand_id/show/library");
            }
        }
    }

    /**
     * Copy media to media vault
     * 
     * @param int $ad_id Ad id
     * @return void
     */
    public function copy_to_media_vault($ad_id)
    {
        $ad = $this->ads_manager->get_ad($ad_id);

        $data = [
            'brand_id'  => $ad->brand_id,
            'title'     => $ad->title,
            'url'       => $ad->url,
            'media'     => $ad->filename
        ];

        $target = FCPATH . "base/media/$ad->folder/";

        $destination = FCPATH . "base/media/vault/brand_{$ad->brand_id}/";

        // create the destination folder if not exists
        if (!is_dir($destination)) {
            if (!mkdir($destination, 0755, TRUE)) {
                show_error('Unable to create media folder.', 500, 'Internal Server Error');
                return;
            }
        }

        if (copy("$target{$ad->filename}", "$destination{$ad->filename}")) {

            $create = $this->media_vault->create($data);

            if ($create) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        } else {
            show_error('Unable to copy media to target folder.', 500, 'Internal Server Error');
        }
    }

    /**
     * Get list of all ads based on the brand
     *
     * @param int $brand_id          Brand id
     * @param bool $is_archvied      Is ad archived?
     * @return void
     */
    public function get($brand_id, $is_archived = 0)
    {
        $ads = $this->ads_manager->get_ads_by_brand_id($brand_id, $is_archived);
        $total_ads = count($ads);
        $result = [
            'iTotalRecords' => $total_ads,
            'iTotalDisplayRecords' => $total_ads,
            'sEcho' => 0,
            'sColumns' => '',
            'aaData' => $ads,
        ];

        // get umbrella and field for each ad if exists
        foreach ($result['aaData'] as $i => $ad) {
            if ($ad->scope == 'umbrella') {
                $result['aaData'][$i]->umbrella = $this->Umbrella->get($ad->scope_id)->title;
                $result['aaData'][$i]->field = null;
            } else if ($ad->scope == 'field') {
                $result['aaData'][$i]->umbrella = $this->Field->get_umbrella($ad->scope_id)->umbrella;
                $result['aaData'][$i]->field = $this->Field->get($ad->scope_id)->title;
            } else {
                $result['aaData'][$i]->umbrella = null;
                $result['aaData'][$i]->field = null;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Update an ad
     *
     * @param int $id Ad ID
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('ads_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('url', 'Link Reference', 'trim|callback_url_check');
            $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
            $this->form_validation->set_rules('has_sign', 'Sponsored', 'required|numeric');
            $this->form_validation->set_rules('is_active', 'Enabled', 'required|numeric');

            $ad = $this->ads_manager->get_ad($id);

            if ($this->form_validation->run() === false) {

                // page data
                $data['ad'] = $ad;
                $data['title'] = ucwords('edit ad');

                $this->load->view('admin_panel/pages/brands/ads/edit', $data);
            } else {
                $data = [
                    'title'     => $this->input->post('title'),
                    'url'       => $this->input->post('has_no_url') == 1 ? '' : $this->input->post('url'),
                    'duration'  => $this->input->post('duration'),
                    'has_sign'  => $this->input->post('has_sign'),
                    'is_active' => $this->input->post('is_active'),
                ];

                if ($_FILES['media']['error'] == 0) {
                    $data['media'] = $this->upload_media($ad->scope, $ad->scope_id);
                }

                $update = (int) $this->ads_manager->update_ad($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }

                redirect("admin/brands/ads/brand/id/$ad->brand_id/show/library");
            }
        }
    }

    /**
     * View page for ads.
     *
     * @param string $brand_id    Brand ID
     * @param string $view        View: Library|Archived
     * @return void
     */
    public function view($brand_id, $view)
    {
        // page data
        if ($view == 'archived') {
            $data['is_archived'] = 1;
        } else {
            $data['is_archived'] = 0;
        }

        // Page data
        $data['brand'] = $this->Brand->get($brand_id);

        // Load page content
        $data['title'] = ucwords('brands | ads');
        $this->load->view('admin_panel/pages/brands/ads/view', $data);
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

        $this->load->library('upload', $config);

        $upload = $this->upload->do_upload('media');

        if ($upload) {

            $media = $this->upload->data();

            $folder = strtolower("{$scope}/{$scope_id}");

            // structure example: base/media/umbrella/123/
            $structure = './base/media/' . $folder . "/";

            // create media folder for selected umbrella or field
            if (!is_dir($structure)) {
                if (!mkdir($structure, 0755, TRUE)) {
                    show_error('Unable to create media folder.', 500, 'Internal Server Error');
                }
            }

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

    /**
     * Custome validation for link reference
     *
     * @param string $str URL
     * @return void
     */
    public function url_check($str)
    {
        $has_no_link_checked = $this->input->post('has_no_url');

        if (!$has_no_link_checked) {
            if ($str === '') {
                $this->form_validation->set_message('url_check', 'The {field} field is required.');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
}
