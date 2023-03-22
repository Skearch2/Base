<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Keywords_model.php
 *
 * This model is responsible for managing keywords which is
 * used for searching umbrellas and fields
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Keywords_model extends CI_Model
{

    /**
     * Create keyword(s)
     *
     * @param array $data Array of keywords data [$keyword, $link_id, $link_type, $status]
     * @return boolean
     */
    public function create($data)
    {
        $this->db->insert_batch('search_keywords', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes keyword
     *
     * @param int $id Keyword Id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('search_keywords');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the keyword already exist
     *
     * @param string $keyword Keyword
     * @param int    $id Keyword ID
     * @return boolean
     */
    public function duplicate_check($keyword)
    {
        $this->db->select('keyword');
        $this->db->from('search_keywords');
        $this->db->where('keyword', $keyword);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the keyword already exists as brandlink keyword or search keyword
     *
     * @param string $keyword   Keyword
     * @param int    $link_id   Link ID
     * @param string $link_type Link Type  umbrella|field
     * @return boolean
     */
    public function duplicate_check_using_link($keyword, $link_id = null, $link_type = null)
    {
        $this->db->select("id");
        $this->db->from('search_keywords');
        $this->db->where('keyword', $keyword);
        if ($link_id !== null) {
            $this->db->where('link_id !=', $link_id);
            // $this->db->where('link_type !=', $link_type);
        }

        $query1 = $this->db->get_compiled_select();

        $this->db->select('id');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->where('keyword', $keyword);

        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2);

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all keywords
     *
     * @return object
     */
    public function get()
    {
        $this->db->select("title");
        $this->db->from('skearch_categories');
        $this->db->where('skearch_categories.id = search_keywords.link_id');
        $umbrella = $this->db->get_compiled_select();

        $this->db->select("id, keyword, link_type, ($umbrella) as link_name, link_id, status");
        $this->db->from('search_keywords');
        $this->db->where('link_type', 'umbrella');
        $query1 = $this->db->get_compiled_select();

        $this->db->select("title");
        $this->db->from('skearch_subcategories');
        $this->db->where('skearch_subcategories.id = search_keywords.link_id');
        $field = $this->db->get_compiled_select();

        $this->db->select("id, keyword, link_type, ($field) as link_name, link_id, status");
        $this->db->from('search_keywords');
        $this->db->where('link_type', 'field');
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . "ORDER BY keyword");

        return $query->result();
    }

    /**
     * Get keyword data
     *
     * @param string $keyword
     * @return object
     */
    public function get_by_keyword($keyword)
    {
        $this->db->select("link_id, link_type");
        $this->db->from('search_keywords');
        $this->db->where('keyword', $keyword);
        $this->db->where('status', 1);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Get keyword data
     *
     * @param int $id Keyword ID
     * @return object
     */
    public function get_by_id($id)
    {
        $this->db->select("*");
        $this->db->from('search_keywords');
        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Get keyword(s) by link_id
     *
     * @param int $link_id
     * @param int $link_type umbrella|field
     * @return object
     */
    public function get_by_link_id($link_id, $link_type)
    {
        $this->db->select("keyword");
        $this->db->from('search_keywords');
        $this->db->where('link_id', $link_id);
        $this->db->where('link_type', $link_type);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Update keyword data
     *
     * @param int $id Keyword ID
     * @param array $data[$keyword, $link_id, $link_type, $status] Keyword data
     * @return boolean
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('search_keywords', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete all previous keywords and insert new keywords thats links to link id
     *
     * @param int $id link_id
     * @param array $data Array of keywords data [$keyword, $link_id, $link_type, $status]
     * @return boolean
     */
    public function replace($link_id, $data)
    {
        $this->db->where('link_id', $link_id);
        $this->db->delete('search_keywords');

        if ($data !== null) {
            $this->create($data);
        }
    }

    // public function get_link_info($keyword)
    // {
    //     $this->db->select("link_id");
    //     $this->db->from('search_keywords');
    //     $this->db->where('keyword', $keyword);
    //     $link_id = $this->db->get_compiled_select();

    //     $this->db->select("title");
    //     $this->db->from('skearch_categories');
    //     $this->db->where('link_id', $link_id);
    //     $query1 = $this->db->get_compiled_select();

    //     $this->db->select("title");
    //     $this->db->from('skearch_categories');
    //     $this->db->where('link_id', $link_id);
    //     $query1 = $this->db->get_compiled_select();

    //     $query = $this->db->query($query1 . " UNION " . $query2);

    //     return $query->result();
    // }
}
