<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/my_skearch/brand/Deals.php
 *
 * This controller allows brands to create, edit, and view brand deals
 * and offers for users to opt in
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2022
 * @version		2.0
 */
class Deals extends MY_Controller
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
        $this->load->model('my_skearch/brand/Deals_model', 'Deals');

        // update status on deals based on start/end date
        $this->Deals->update_status();

        // check if the user is primary brand user (key member for the brand)
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
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required|min_length[1]|max_length[30]');

        if ($this->form_validation->run() === false) {

            // page data
            $data['title'] = ucwords('create deal');
            $this->load->view('my_skearch/pages/brand/deals/create', $data);
        } else {
            $duration = $this->input->post('duration');
            $end_date = date_create($this->input->post('start_date'));
            date_add($end_date, date_interval_create_from_date_string("{$duration} days"));
            $end_date = date_format($end_date, 'Y-m-d H:i');

            $data = [
                'brand_id'     => $this->brand_id,
                'title'        => $this->input->post('title'),
                'description'  => $this->input->post('description'),
                'start_date'   => $this->input->post('start_date'),
                'end_date'     => $end_date
            ];

            $create = $this->Deals->create($data);

            if ($create) {
                $this->session->set_flashdata('create_success', 1);
            } else {
                $this->session->set_flashdata('create_success', 0);
            }

            redirect("myskearch/brand/deals");
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
        $delete = $this->Deals->delete($id);

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

        $deals =  $this->Deals->get_by_brand($brand_id);
        $total_deals = count($deals);
        $result = array(
            'iTotalRecords' => $total_deals,
            'iTotalDisplayRecords' => $total_deals,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $deals
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * View page for brand deals
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
        $data['page'] = 'deals';
        $data['title'] = ucwords("my skearch | brands - media vault");

        // Load page content
        $this->load->view('my_skearch/pages/brand/deals/view', $data);
    }

    /**
     * Update deal
     *
     * @param int $id Ad ID
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required|min_length[1]|max_length[30]');

        if ($this->form_validation->run() === false) {
            $deal = $this->Deals->get_by_id($id);

            $start_date = date_create($deal->start_date);
            $end_date = date_create($deal->end_date);
            $interval = date_diff($start_date, $end_date);
            $deal->duration = $interval->format('%a');

            // page data
            $data['brand_id'] = $this->brand_id;
            $data['deal'] = $deal;

            // page title
            $data['title'] = ucwords('edit deal');
            $this->load->view('my_skearch/pages/brand/deals/edit', $data);
        } else {

            $duration = $this->input->post('duration');
            $end_date = date_create($this->input->post('start_date'));
            date_add($end_date, date_interval_create_from_date_string("{$duration} days"));
            $end_date = date_format($end_date, 'Y-m-d H:i');

            $data = [
                'brand_id'     => $this->brand_id,
                'title'        => $this->input->post('title'),
                'description'  => $this->input->post('description'),
                'start_date'   => $this->input->post('start_date'),
                'end_date'     => $end_date
            ];

            $update = $this->Deals->update($id, $data);

            if ($update) {
                $this->session->set_flashdata('update_success', 1);
            } else {
                $this->session->set_flashdata('update_success', 0);
            }

            redirect("myskearch/brand/deals");
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
