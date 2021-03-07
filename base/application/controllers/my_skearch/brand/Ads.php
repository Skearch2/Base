<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/my_skearch/brand/Ads.php
 *
 * Controller for Brand Ads.
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Ads extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('myskearch/auth/login', 'refresh');
        }

        // check if user is a brand member
        if (!$this->ion_auth->in_group($this->config->item('brand', 'ion_auth') || $this->ion_auth->is_admin())) {
            redirect('myskearch', 'refresh');
        }

        $this->user_id = $this->session->userdata('user_id');

        // defines section in myskearch
        $this->section = 'brand';

        $this->load->model('my_skearch/User_model', 'User');
    }

    /**
     * View page for brand ads
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
            $data['brand_id'] = $brand_id;
        }

        $data['section'] = $this->section;
        $data['page'] = 'ads';
        $data['title'] = ucwords("my skearch | brands - ads");

        // Load page content
        $this->load->view('my_skearch/pages/brand/ads', $data);
    }

    /**
     * Get stats for brand ads
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

        // curl request for media box
        $this->curl->create("https://media.skearch.com/api/npm/activity/{$brand_id}");
        $this->curl->{'get'}();
        $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
        $this->curl->http_header('X-I-USER', 1);

        $xml = $this->curl->execute();
        // convert simplexml to array
        $xml_array = json_decode(json_encode(new SimpleXMLElement($xml)), TRUE);

        $stats = isset($xml_array['item']) ? $xml_array['item'] : array();
        $total_ads = count($stats);
        $result = array(
            'iTotalRecords' => $total_ads,
            'iTotalDisplayRecords' => $total_ads,
            'sEcho' => 0,
            'sColumns' => "",
            'aaData' => $stats,
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
