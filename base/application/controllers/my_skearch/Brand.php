<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is the My Skearch controller.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Brand extends MY_Controller
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

        $this->user_id = $this->session->userdata('id');

        $this->load->model('my_skearch/User_model', 'User');
    }

    public function index()
    {
        $brand_id = $this->User->get_brand_id($this->user_id)->id;

        // curl request for media box
        $this->curl->create("https://media.skearch.com/api/npm/activity/$brand_id");
        $this->curl->{'get'}();
        $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
        $this->curl->http_header('X-I-USER', 1);

        $xml = $this->curl->execute();

        // parse xml to array
        $data['stats'] = new SimpleXMLElement($xml);

        $data['title'] = ucwords("my skearch | brands");

        // Load page content
        $this->load->view('my_skearch/brand/default', $data);
    }
}
