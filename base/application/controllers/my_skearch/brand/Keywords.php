<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


/**
 * File:    ~/application/controller/my_skearch/brands/keywords.php
 *
 * Controller for Brand Keywords.
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Keywords extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        if (!($this->ion_auth->get_users_groups()->row()->id == 3)) {
            redirect('myskearch', 'refresh');
        }

        $this->load->model('my_skearch/brand/Keywords_model', 'Keywords');
        $this->load->model('my_skearch/User_model', 'User');

        $this->user_id  = $this->session->userdata('id');
        $this->brand_id = $this->User->get_brand_details($this->user_id)->brand_id;
        $this->is_primary_brand_user = $this->User->get_brand_details($this->user_id)->primary_brand_user;

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

        $this->form_validation->set_rules('keyword', 'Keywords', 'trim|required|is_unique[skearch_brands_keywords.keywords]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required|callback_valid_url');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(0);
            return;
        }

        $user_data =  array(
            'brand_id' => $this->brand_id,
            'keywords' => $this->input->get('keyword'),
            'url' => $this->input->get('url'),
            'active' => 0,
            'approved' => 0
        );

        $create = $this->Keywords->create($user_data);

        if ($create) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Delete brand keywords
     *
     * @param int $id Keyword ID
     * @return void
     */
    public function delete($id)
    {
        $delete = $this->Keywords->delete($id);

        if ($delete) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    /**
     * Get brand keywords
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function get()
    {
        $keywords = $this->Keywords->get_by_brand($this->brand_id);
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

    /**
     * View page for brand keywords
     *
     * @return void
     */
    public function index()
    {
        // page data
        $data['is_primary_brand_user'] = $this->is_primary_brand_user;

        // template data
        $data['section'] = $this->section;
        $data['page'] = 'keywords';
        $data['title'] = ucwords("my skearch | brands - keywords");

        // Load page content
        $this->load->view('my_skearch/pages/brand/keywords', $data);
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
     * Callback function to validate url
     *
     * @param string $url URL
     * @return void
     */
    function valid_url($url)
    {
        return (filter_var($url, FILTER_VALIDATE_URL) !== FALSE);
    }
}
