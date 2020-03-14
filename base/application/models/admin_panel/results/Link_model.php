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
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Link_model extends CI_Model
{
    /**
     * Creates link
     *
     * @param int $id
     * @param int $priority
     * @param String $title
     * @param String $description_short
     * @param String $display_url
     * @param String $www
     * @param int $field_id
     * @param boolean $redirect
     * @param boolean $enabled
     * @return boolean
     */
    public function create($priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled)
    {
        $data = array(
            'priority' => $priority,
            'title' => $title,
            'description_short' => $description_short,
            'display_url' => $display_url,
            'www' => $www,
            'sub_id' => $field_id,
            'redirect' => $redirect,
            'enabled' => $enabled
        );

        $query = $this->db->insert('skearch_listings', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes link
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
     * Gets link or all links
     *
     * @param int $id An id of a link
     * @param string $columns Columns to select from the table in the db
     * @return object
     */
    public function get($id = NULL)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS umbrella_id, skearch_subcategories.title AS umbrella');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id', 'left');
        if ($id != NULL && is_numeric($id)) {
            $this->db->where('skearch_listings.id', $id);
            $query = $this->db->get();
            return $query->row();
        } else {
            $query = $this->db->get();
            return $query->result();
        }
    }

    /**
     * Undocumented function
     */
    public function search_adlink($title)
    {
        if ($title == NULL) return;
        $query = $this->db->select('skearch_subcategories.title AS stitle, skearch_listings.title, skearch_listings.id, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect ');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $query = $this->db->like('skearch_listings.title', $title, 'after');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Updates link
     *
     * @param int $id
     * @param int $priority
     * @param String $title
     * @param String $description_short
     * @param String $display_url
     * @param String $www
     * @param int $field_id
     * @param bool $redirect
     * @param bool $enabled
     * @return void
     */
    public function update($id, $priority, $title, $description_short, $display_url, $www, $field_id, $redirect, $enabled)
    {

        if (!is_null($priority))            $data['priority']          = $priority;
        if (!is_null($title))               $data['title']             = $title;
        if (!is_null($description_short))   $data['description_short'] = $description_short;
        if (!is_null($display_url))         $data['display_url']       = $display_url;
        if (!is_null($www))                 $data['www']               = $www;
        if (!is_null($field_id))            $data['sub_id']            = $field_id;
        if (!is_null($redirect))            $data['redirect']          = $redirect;
        if (!is_null($enabled))             $data['enabled']           = $enabled;

        $this->db->where('id', $id);
        $this->db->update('skearch_listings', $data);
    }
}
