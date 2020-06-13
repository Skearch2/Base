<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/controller/frontend/Search.php
 *
 * Search controller for Skearch
 * 
 * @package        Skearch
 * @author         Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */

class Search extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Category_model');
    }

    /**
     * Determines web page based on keywords
     *
     * @return void
     */
    public function index()
    {
        $cat = $this->Category_model->get_categories();
        $sub_cat = $this->Category_model->get_subcategories();
        $links = $this->Category_model->get_results();
        $brands_keywords = $this->Category_model->get_brands_keywords();

        $keyword = $this->input->get('search_keyword');

        /* If keyword matches with the title of umbrella page or keywords for umbrella page then
           redirect to the umbrella page */

        foreach ($cat as $item) {
            if (strtolower($item->title) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                return;
            } else if (strtolower($item->keywords) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                return;
            } else if (strlen($keyword) > 1 && substr($keyword, -1) === 's') {
                if (strpos(strtolower($item->title), strtolower(substr($keyword, 0, -1))) !== false) {
                    echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                    return;
                }
            }
        }

        /* If keyword matches with the title of field page or keywords for field page then
           redirect to the field  page */

        foreach ($sub_cat as $item) {
            $ptitle = $this->Category_model->get_category_title($item->parent_id)[0]->title;
            if (strtolower($item->title) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                return;
            } else if (strtolower($item->keywords) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                return;
            } else if (strlen($keyword) > 1 && substr($keyword, -1) === 's') {
                if (strtolower($item->title) === strtolower(substr($keyword, 0, -1))) {
                    echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                    return;
                }
            }
        }

        /* If keyword matches with adlink's url then redirect to that url */
        if ($this->Category_model->get_brandlinks_status()) {
            foreach ($links as $item) {
                if ($item->www) {
                    $urlhost = $this->get_domainInfo($item->www);
                    if (strcmp(strtolower($urlhost['host']), strtolower($keyword)) == 0) {
                        echo json_encode(array("type" => "external", "url" => $item->www));
                        return;
                    }
                }
            }
        }

        /* If keyword matches with brand keywords then redirect to brand specified url */
        foreach ($brands_keywords as $item) {
            if (strcmp(strtolower($item->keywords), strtolower($keyword)) == 0) {
                echo json_encode(array("type" => "external", "url" => $item->url));
                return;
            }
        }

        // default external skearch search engine
        $search_url = 'http://www.duckduckgo.com/?q=';

        // get search engine from user settings
        if ($this->ion_auth->logged_in()) {

            $search_engine = $this->session->userdata('settings')->search_engine;

            if ($search_engine === 'startpage') {
                $search_url = 'https://www.startpage.com/do/dsearch?query=';
            } elseif ($search_engine === 'google') {
                $search_url = 'http://www.google.com/search?q=';
            }
        }

        echo json_encode(array("type" => "external", "url" => $search_url . $keyword));
        return;
    }

    /**
     * Returns URL information
     *
     * @param string $url
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
