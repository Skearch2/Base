<?php

/**
 * File: ~/application/controller/admin/results/Links.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * A controller for links
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Links extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect('admin/auth/login');
        }
        $this->load->model('admin_panel/results/link_model', 'links');
    }

    /**
     * Duplicate a link to selected field
     * 
     * @param int $id ID of a link to duplicate
     * @param int $field_id ID of a field to duplicate link to
     * @param int $priority Priority of the duplicated link
     * @return void
     */
    public function duplicate($id, $field_id, $priority)
    {
        $link = $this->links->get($id);

        $title              = $link->title;
        $description_short  = $link->description_short;
        $display_url        = $link->display_url;
        $www                = $link->www;
        $redirect           = $link->redirect;
        $enabled            = $link->enabled;

        $this->links->create($priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled);
    }

    public function get($id = NULL)
    {
        $link = $this->links->get($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($link));
    }

    /**
     * Move a link to a selected field
     * 
     * @param int $id ID of a link to move
     * @param int $field_id ID of a field to move link to
     * @param int $priority Priority of the moved link
     * @return void
     */
    public function move($id, $field_id, $priority)
    {
        $title              = NULL;
        $description_short  = NULL;
        $display_url        = NULL;
        $www                = NULL;
        $redirect           = NULL;
        $enabled            = NULL;

        $this->links->update($id, $priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled);
    }
}
