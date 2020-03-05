<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/Search.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package        Skearch
 * @author         Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright      Copyright (c) 2019
 * @version        2.0
 */

class Search extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->session->userdata('id');

        $this->load->model('admin_panel/Category_model', 'categoryModel');
        $this->load->model('my_skearch/User_model', 'User');
    }

    public function index()
    {

        $keyword = $this->input->get('search_keyword');

        $cat = $this->Category_model->get_categories();
        $sub_cat = $this->Category_model->get_subcategories();
        $links = $this->Category_model->get_results();

        /* If keyword matches with the title of umbrella page or given keywords of umbrella page then
           redirect to the umbrella page */

        foreach ($cat as $item) {
            if (strtolower($item->title) === strtolower($keyword)) {
                //redirect(site_url("browse/" . $item->title), 'refresh');
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                return;
            } else if (strtolower($item->keywords) === strtolower($keyword)) {
                //redirect(site_url("browse/" . $item->title), 'refresh');
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                return;
            } else if (strlen($keyword) > 1 && substr($keyword, -1) == 's') {
                if (strpos(strtolower($item->title), strtolower(substr($keyword, 0, -1))) !== false) {
                    //redirect(site_url("browse/" . $item->title), 'refresh');
                    echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                    return;
                }
            }
        }

        /* If keyword matches with the title of field page or given keywords of field page then
           redirect to the field  page */

        foreach ($sub_cat as $item) {
            $ptitle = $this->categoryModel->get_category_title($item->parent_id)[0]->title;
            if (strtolower($item->title) === strtolower($keyword)) {
                //redirect(site_url("browse/" . $ptitle . "/" . $item->title), 'refresh');
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                return;
            } else if (strtolower($item->keywords) === strtolower($keyword)) {
                //redirect(site_url("browse/" . $ptitle . "/" . $item->title), 'refresh');
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                return;
            } else if (strlen($keyword) > 1 && substr($keyword, -1) == 's') {
                if (strtolower($item->title) === strtolower(substr($keyword, 0, -1))) {
                    //redirect(site_url("browse/" . $ptitle . "/" . $item->title), 'refresh');
                    echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                    return;
                }
            }
        }

        /* If keyword matches with adlink's url then redirect to the url */
        if ($this->categoryModel->get_brandlinks_status()) {
            foreach ($links as $item) {
                if ($item->www) {
                    $urlhost = $this->get_domainInfo($item->www);
                    if (strtolower($urlhost['host']) === strtolower($keyword)) {
                        echo json_encode(array("type" => "external", "url" => $item->www));
                        return;
                    }
                }
            }
        }

        $settings = $this->User->get_settings($this->user_id, 'search_engine');

        if ($settings->search_engine === 'startpage') {
            $search_url = 'https://www.startpage.com/do/dsearch?query=';
        } elseif ($settings->search_engine === 'google') {
            $search_url = 'http://www.google.com/search?q=';
        } else {
            $search_url = 'http://www.duckduckgo.com/?q=';
        }
        /* Else rediect to duckduckgo with given keyword */
        echo json_encode(array("type" => "external", "url" => $search_url . $keyword));
        return;
    }

    /**
     * Returns URL information
     *
     * @param [type] $url
     * @return void
     */
    private function get_domainInfo($url)
    {
        // regex can be replaced with parse_url
        preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/", $matches);
        $parts = explode(".", $matches[2]);
        $tld = array_pop($parts);
        $host = array_pop($parts);
        if (strlen($tld) == 2 && strlen($host) <= 3) {
            $tld = "$host.$tld";
            $host = array_pop($parts);
        }

        return array(
            'protocol' => $matches[1],
            'subdomain' => implode(".", $parts),
            'domain' => "$host.$tld",
            'host' => $host,
            'tld' => $tld
        );
    }
}
