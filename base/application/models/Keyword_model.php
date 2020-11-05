<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Keyword_model.php
 *
 * This model is responsible for managing keywords which is
 * used for searching umbrellas and fields
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Keyword_model extends CI_Model
{

    /**
     * Create a keyword
     *
     * @param string $keyword
     * @param int $link_id Umbrella or Field id
     * @param boolean $is_link_umbrella Whether the link id given is an umbrella
     * @return void
     */
    public function create($keyword, $link_id, $is_link_umbrella)
    {
        $data = array(
            'keyword' => $keyword,
            'link_id' => $link_id,
            'is_link_umbrella' => $is_link_umbrella
        );

        $this->db->insert('skearch_search_keywords', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all keywords linked to the umbrella or field
     *
     * @param int $link_id Umbrella or Field id
     * @param boolean $is_link_umbrella Whether the link id given is an umbrella
     * @return void
     */
    public function get($link_id, $is_link_umbrella)
    {
        $this->db->select('id, keyword');
        $this->db->from('skearch_search_keywords');
        $this->db->where('link_id', $link_id);
        $this->db->where('is_result_umbrella', $is_link_umbrella);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
}
