<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/my_skearch/brand/Media_vault.php
 *
 * Controller for Media Vault
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 * @version		2.0
 */
class Media_vault extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        // check if user is a brand member or admin
        if (!$this->ion_auth->in_group($this->config->item('brand', 'ion_auth') || $this->ion_auth->is_admin())) {
            redirect('myskearch', 'refresh');
        }

        $this->load->model('my_skearch/User_model', 'User');
        $this->load->model('my_skearch/brand/Media_vault_model', 'Media_vault');

        if ($this->ion_auth->in_group($this->config->item('brand', 'ion_auth'))) {
            $this->user_id  = $this->session->userdata('user_id');
            $this->brand_id = $this->User->get_brand_details($this->user_id)->brand_id;
            $this->is_primary_brand_user = $this->User->get_brand_details($this->user_id)->primary_brand_user;
        }

        // defines section in myskearch
        $this->section = 'brand';
    }

    /**
     * Create media
     *
     * @return void
     */
    public function create()
    {
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('url', 'Link', 'trim|required|valid_url');
        $this->form_validation->set_rules('note', 'Note', 'trim|max_length[5000]');
        if (empty($_FILES['media']['name'])) {
            $this->form_validation->set_rules('media', 'Media', 'required');
        }

        if ($this->form_validation->run() === false) {

            // page data
            $data['title'] = ucwords('add media');
            $this->load->view('my_skearch/pages/brand/media_vault/create', $data);
        } else {
            $data = [
                'brand_id'  => $this->brand_id,
                'title'     => $this->input->post('title'),
                'media'     => $this->upload_media(),
                'url'       => $this->input->post('url'),
                'note'      => $this->input->post('note')
            ];

            $create = $this->Media_vault->create($data);

            if ($create) {
                $this->session->set_flashdata('create_success', 1);
            } else {
                $this->session->set_flashdata('create_success', 0);
            }

            redirect("myskearch/brand/vault");
        }
    }


    /**
     * Delete media
     *
     * @param int $id Media ID
     * @return void
     */
    public function delete($id)
    {
        $delete = $this->Media_vault->delete($id);

        if ($delete) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Get media in the vault for the brand
     *
     * @param int $id Brand Id
     * @return void
     */
    public function get($id = null)
    {
        // id is required to view as brand by admin
        if ($this->ion_auth->is_admin() && !$id) {
            redirect('myskearch', 'refresh');
        }

        $brand_id = !is_null($id) ? $id : $this->User->get_brand_details($this->user_id)->brand_id;

        $media =  $this->Media_vault->get_by_brand($brand_id);
        $total_media = count($media);
        $result = array(
            'iTotalRecords' => $total_media,
            'iTotalDisplayRecords' => $total_media,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $media
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * View page for media vault
     *
     * @param int $id Brand Id
     * @return void
     */
    public function index($id = null)
    {
        // id is required to view as brand by admin
        if ($this->ion_auth->is_admin() && !$id) {
            redirect('myskearch', 'refresh');
        }

        // if the brand id not given then get the brand id from the brand user
        $brand_id = !is_null($id) ? $id : $this->User->get_brand_details($this->user_id)->brand_id;

        if ($id) {
            $data['viewas'] = 1;
        }

        $data['is_primary_brand_user'] = $this->is_primary_brand_user;
        $data['brand_id'] = $brand_id;

        $data['section'] = $this->section;
        $data['page'] = 'media vault';
        $data['title'] = ucwords("my skearch | brands - media vault");

        // Load page content
        $this->load->view('my_skearch/pages/brand/media_vault/view', $data);
    }

    /**
     * Update media
     *
     * @param int $media_id Media ID
     * @return void
     */
    public function update($media_id)
    {
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('url', 'Link', 'trim|required|valid_url');
        $this->form_validation->set_rules('note', 'Note', 'trim|max_length[5000]');

        if ($this->form_validation->run() === false) {
            $media = $this->Media_vault->get($media_id);

            // page data
            $data['brand_id'] = $this->brand_id;
            $data['media'] = $media;

            // page title
            $data['title'] = ucwords('edit media');
            $this->load->view('my_skearch/pages/brand/media_vault/edit', $data);
        } else {

            $data = [
                'title'     => $this->input->post('title'),
                'url'       => $this->input->post('url'),
                'note'      => $this->input->post('note')
            ];

            $create = $this->Media_vault->update($media_id, $data);

            if ($create) {
                $this->session->set_flashdata('update_success', 1);
            } else {
                $this->session->set_flashdata('update_success', 0);
            }

            redirect("myskearch/brand/vault");
        }
    }

    /**
     * Upload media
     *
     * @return string|false
     */
    private function upload_media()
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

            $folder_path = FCPATH . 'base/media/vault/brand_' . $this->brand_id  . "/";

            // create folder with brand id
            if (!file_exists($folder_path)) {
                mkdir($folder_path, $this->config->item('tmp_permissions'));
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
        }
    }
}
