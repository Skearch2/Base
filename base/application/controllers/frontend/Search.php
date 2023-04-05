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
     * Determines redirect url based on keyword
     *
     * @return void
     */
    public function index()
    {
        $keyword = $this->input->get('search_keyword');

        if (empty($keyword)) {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }

        /* If keyword matches with link's url hostname then redirect to that url */
        $links = $this->Category_model->get_results();
        if ($this->Category_model->get_brandlinks_status()) {
            foreach ($links as $item) {
                if ($item->www) {
                    $hostname = $this->parse_hostname($item->www);
                    if (strcmp(strtolower($hostname), strtolower($keyword)) == 0) {
                        echo json_encode(array("type" => "external", "url" => $item->www));
                        return;
                    }
                }
            }
        }

        /* If keyword matches with a brandlink then redirect to the brandlink drop page */
        $brandlinks = $this->Category_model->get_brandlinks();
        foreach ($brandlinks as $brandlink) {
            if (strcasecmp($brandlink->keyword, $keyword) == 0) {
                echo json_encode(array("type" => "external", "url" => $brandlink->url));
                return;
            }
        }

        /* If keyword matches with search keyword then redirect to its linked umbrella or field page */
        $search_keyword = $this->Keywords->get_by_keyword($keyword);
        if ($search_keyword) {
            if ($search_keyword->link_type === 'umbrella') {
                $umbrella = $this->Category_model->get_category_title($search_keyword->link_id);
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . strtolower($umbrella->title))));
                return;
            } else if ($search_keyword->link_type === 'field') {
                $title = $this->Category_model->get_field_and_umbrella_title($search_keyword->link_id);
                echo json_encode(array("type" => "internal", "url" => site_url("browse/" . strtolower($title->umbrella) . "/" . strtolower($title->field))));
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

        echo json_encode(array("type" => "external", "url" => $search_url . strtolower($keyword)));
        return;
    }

    /**
     * Returns hostname from the url
     *
     * @param string $url
     * @return void
     */
    private function parse_hostname($url)
    {
        // regex can be replaced with parse_url
        preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/", $matches);

        $parts = explode(".", $matches[2]);
        $tld = array_pop($parts);
        $host = array_pop($parts);

        return $host;
    }
}
