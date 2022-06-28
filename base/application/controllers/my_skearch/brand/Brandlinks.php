<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


/**
 * File:    ~/application/controller/my_skearch/brands/brandlinks.php
 *
 * Controller for BrandLinks
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2021
 * @version		2.0
 */
class Brandlinks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        // check if user is a brand member
        if (!($this->ion_auth->get_users_groups()->row()->id == 3 || $this->ion_auth->is_admin())) {
            redirect('myskearch', 'refresh');
        }

        $this->load->model('my_skearch/brand/Brandlink_model', 'Brandlink');
        $this->load->model('my_skearch/User_model', 'User');

        if (!$this->ion_auth->is_admin()) {
            $this->user_id  = $this->session->userdata('user_id');
            $this->brand_id = $this->User->get_brand_details($this->user_id)->brand_id;
            $this->is_primary_brand_user = $this->User->get_brand_details($this->user_id)->primary_brand_user;
        }

        // defines section in myskearch
        $this->section = 'brand';
    }

    /**
     * Add keywords for brand direct
     *
     * @return void
     */
    public function create()
    {
        $this->form_validation->set_data($this->input->get());

        $this->form_validation->set_rules('keyword', 'BrandLink Keyword', 'trim|required|callback_validate_keyword|callback_check_maximum_allowed');
        $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required|valid_url');

        if ($this->form_validation->run() === FALSE) {
            echo validation_errors();
            return;
        }

        $user_data =  array(
            'brand_id'  => $this->brand_id,
            'keyword'   => $this->input->get('keyword'),
            'url'       => $this->input->get('url'),
            'active'    => 0,
            'approved'  => 1
        );

        $create = $this->Brandlink->create($user_data);

        if ($create) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Delete brandlink
     *
     * @param int $id Brandlink ID
     * @return void
     */
    public function delete($id)
    {
        $delete = $this->Brandlink->delete($id);

        if ($delete) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Get brandlinks
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function get()
    {
        // get brand id
        $brand_id = $this->input->get('brand_id') != 0 ? $this->input->get('brand_id') : $this->brand_id;

        $brandlinks = $this->Brandlink->get($brand_id);
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

    /**
     * Get keyword by id
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function get_by_id($id)
    {
        $brandlink = $this->Brandlink->get_by_id($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($brandlink));
    }

    /**
     * View page for brand keywords
     *
     * @return void
     */
    public function index($brand_id = null)
    {

        if ($brand_id) {
            $data['viewas'] = 1;
            $data['brand_id'] = $brand_id;
            $data['is_primary_brand_user'] = 0;
        } else {
            $data['brand_id'] = 0;
            $data['is_primary_brand_user'] = $this->is_primary_brand_user;
        }

        // template data
        $data['section'] = $this->section;
        $data['page'] = 'keywords';
        $data['title'] = ucwords("MySkearch | brands - BrandLinks");

        // Load page content
        $this->load->view('my_skearch/pages/brand/brandlinks', $data);
    }

    // /**
    //  * Toggle brand keywords status
    //  *
    //  * @param int $id Keyword ID
    //  * @return void
    //  */
    // public function toggle($id)
    // {
    //     $user_data = array(
    //         'active' => 0,
    //         'approved' => 0,
    //     );

    //     $update = $this->Keywords->update($id, $user_data);

    //     if ($update) {
    //         echo json_encode(1);
    //     } else {
    //         echo json_encode(0);
    //     }
    // }

    /**
     * Update brandlink
     *
     * @param int $id brandlink id
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_data($this->input->get());

        $this->form_validation->set_rules('keyword', 'BrandLink Keyword', 'trim|required|callback_validate_keyword');
        $this->form_validation->set_rules('url', 'URL - Droppage', 'trim|required|valid_url');

        if ($this->form_validation->run() === FALSE) {
            echo validation_errors();
            return;
        }

        $data = [
            'keyword'      => $this->input->get('keyword'),
            'url'          => $this->input->get('url'),
            'last_updated' => date("Y-m-d H:i:s")
        ];

        $update = $this->Brandlink->update($id, $data);

        if ($update) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Validate keyword
     *
     * @param string $keyword Keyword
     * @return boolean
     */
    public function validate_keyword($keyword)
    {
        $brandlink_id = $this->input->get('brandlink_id');

        if ($this->Brandlink->duplicate_check($keyword)) {
            if (isset($brandlink_id) && $this->Brandlink->get_by_id($brandlink_id)->keyword === $keyword) {
                return true;
            } else {
                $this->form_validation->set_message('validate_keyword', "Keyword already exists either as BrandLink or Search keyword.");
                return false;
            }
        }

        return true;
    }

    /**
     * Check for maximum # of brandlinks per brand account
     *
     * @return boolean
     */
    public function check_maximum_allowed()
    {
        $brandlinks = $this->Brandlink->get($this->brand_id);

        // limit brandlinks upto 10 per brand account
        if (count($brandlinks) > 10) {
            $this->form_validation->set_message('check_maximum_allowed', "Maximum amount of Branded Keywords reached.");
            return false;
        }

        return true;
    }
}
