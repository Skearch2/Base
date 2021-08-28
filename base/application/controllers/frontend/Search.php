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
        $this->load->model('Keywords_model', 'Keywords');
    }

    /**
     * Determines web page based on keywords
     *
     * @return void
     */
    public function index()
    {
        $keyword = $this->input->get('search_keyword');

        $cat = $this->Category_model->get_categories();
        $sub_cat = $this->Category_model->get_subcategories();
        $links = $this->Category_model->get_results();
        $brandlinks = $this->Category_model->get_brandlinks();

        /* If keyword matches with the title of umbrella page then redirect to the umbrella page */
        foreach ($cat as $item) {
            if (strtolower($item->title) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $item->title)));
                return;
            }
        }

        /* If keyword matches with the title of field page then redirect to the field page */
        foreach ($sub_cat as $item) {
            $ptitle = $this->Category_model->get_category_title($item->parent_id)[0]->title;
            if (strtolower($item->title) === strtolower($keyword)) {
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $ptitle . "/" . $item->title)));
                return;
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

        /* If keyword matches with brandlinks then redirect to it's drop page */
        foreach ($brandlinks as $brandlink) {
            if (strcmp(strtolower($brandlink->keyword), strtolower($keyword)) == 0) {
                echo json_encode(array("type" => "external", "url" => $brandlink->url));
                return;
            }
        }

        /* If keyword matches with search keyword then redirect to its linked umbrella or field page */
        $matched_keyword = $this->Keywords->get_by_keyword($keyword);
        if ($matched_keyword) {
            if ($matched_keyword->link_type === 'umbrella') {
                $data = $this->Category_model->get_category_title($matched_keyword->link_id);
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $data[0]->title)));
                return;
            } else if ($matched_keyword->link_type === 'field') {
                $data = $this->Category_model->get_field_and_umbrella_title($matched_keyword->link_id);
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . $data[0]->umbrella . "/" . $data[0]->field)));
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
