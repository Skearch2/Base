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
     * Get research links
     *
     * @return object
     */
    public function get($id = NULL)
    {
        $this->db->select('rl.id, rl.description, rl.url, rl.field_id, DATE_FORMAT(rl.date_created, "%m-%d-%Y") as date_created, field.title as field');
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
     * Delete research link
     *
     * @param int $id
     * @return void
     */
    public function create($description, $url, $field_id)
    {
        $data = array(
            'description' => $description,
            'url' => $url,
            'field_id' => $field_id
        );
        $this->db->insert('skearch_research_links', $data);
    }

    /**
     * Delete research link
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_research_links');
    }
}
