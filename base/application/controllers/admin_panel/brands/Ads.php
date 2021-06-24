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

        $this->load->model('admin_panel/ads_manager_model', 'ads_manager');
        $this->load->model('admin_panel/brands/brand_model', 'Brand');
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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
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
        $this->load->view('admin_panel/pages/brands/ads', $data);
    }
}
