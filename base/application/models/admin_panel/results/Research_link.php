<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/results/Research.php
 *
 * Model for Research
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Research_Link extends CI_Model
{
    /**
     * Get a research link or list of research links
     *
     * @param int $id An id of a research link
     * 
     * @return object
     */
    public function get($id = NULL)
    {
        $this->db->select('rl.id, rl.title, rl.description_short, rl.url, rl.display_url, rl.field_id, rl.enabled, rl.redirect, DATE_FORMAT(rl.date_created, "%m-%d-%Y") as date_created, field.title as field');
        $this->db->from('skearch_research_links as rl');
        if ($id !== NULL) {
            $this->db->where('rl.id', $id);
            $this->db->join('skearch_subcategories as field', 'rl.field_id = field.id');
            $query = $this->db->get();
            return $query->row();
        }
        $this->db->join('skearch_subcategories as field', 'rl.field_id = field.id');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Creae a research link
     *
     * @param String $description
     * @param String $url
     * @param String $field_id
     * 
     * @return void
     */
    public function create($description, $url, $field_id)
    {
        $data = array(
            'description_short' => $description,
            'url' => $url,
            'field_id' => $field_id
        );
        $query = $this->db->insert('skearch_research_links', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete research link
     *
     * @param int $id An id of a research link
     * 
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('skearch_research_links');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Save research link
     *
     * @param int $id
     * @param String $description
     * @param String $url
     * @param String $display_url
     * @param int $field_id
     * @param int $priority
     * @param bool $enabled
     * @param bool $redirect
     * 
     * @return void
     */
    public function update($id, $title, $description, $url, $display_url, $field_id, $enabled, $redirect)
    {
        $data = array(
            'title' => $title,
            'description_short' => $description,
            'url' => $url,
            'display_url' => $display_url,
            'field_id' => $field_id,
            'enabled' => $enabled,
            'redirect' => $redirect
        );

        $this->db->where('id', $id);
        $query = $this->db->update('skearch_research_links', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
