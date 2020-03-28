<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/results/Link_model.php
 *
 * Model for Links
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Link_model extends CI_Model
{
    /**
     * Creates a link
     *
     * @param array $link_data Array contains data for the umbrella
     * @return void
     */
    public function create($link_data)
    {
        // $data = array(
        //     'priority' => $priority,
        //     'title' => $title,
        //     'description_short' => $description_short,
        //     'display_url' => $display_url,
        //     'www' => $www,
        //     'sub_id' => $field_id,
        //     'redirect' => $redirect,
        //     'enabled' => $enabled
        // );

        $query = $this->db->insert('skearch_listings', $link_data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes a link
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('skearch_listings');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets a link
     *
     * @param int $id An id of a link
     * @return object|false
     */
    public function get($id)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS umbrella_id, skearch_subcategories.title AS umbrella');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $this->db->where('skearch_listings.id', $id);
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Gets links by field
     *
     * @param int $id An id of a link
     * @param string $status $status Status of the links
     * @return object|false
     */
    public function get_by_field($field_id, $status = NULL)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS field_id, skearch_subcategories.title AS field');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $this->db->where('skearch_listings.sub_id', $field_id);
        if ($status == 'inactive') {
            $this->db->where('skearch_listings.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_listings.enabled', 1);
        }
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Gets links by status
     *
     * @param int $id An id of a link
     * @param string $columns Columns to select from the table in the db
     * @return object
     */
    public function get_by_status($status = NULL)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS field_id, skearch_subcategories.title AS field');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        if ($status == 'inactive') {
            $this->db->where('skearch_listings.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_listings.enabled', 1);
        }
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Get links based on keywords
     *
     * @param string $keywords Keywords for the title of the link
     * @return void
     */
    public function get_by_keywords($keywords)
    {
        if ($keywords == NULL) {
            return;
        }

        $this->db->select('skearch_subcategories.title AS stitle, skearch_listings.title, skearch_listings.id, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect ');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $this->db->like('skearch_listings.title', $keywords, 'after');

        $query = $this->db->get();

        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Updates a link
     *
     * @param int $id ID of the link
     * @param array $link_data Array contains data for the umbrella
     * @return void
     */
    public function update($id, $link_data)
    {

        // if (!is_null($priority))            $data['priority']          = $priority;
        // if (!is_null($title))               $data['title']             = $title;
        // if (!is_null($description_short))   $data['description_short'] = $description_short;
        // if (!is_null($display_url))         $data['display_url']       = $display_url;
        // if (!is_null($www))                 $data['www']               = $www;
        // if (!is_null($field_id))            $data['sub_id']            = $field_id;
        // if (!is_null($redirect))            $data['redirect']          = $redirect;
        // if (!is_null($enabled))             $data['enabled']           = $enabled;

        $this->db->where('id', $id);
        $query = $this->db->update('skearch_listings', $link_data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
