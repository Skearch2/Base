<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/brand/Keywords_model.php
 *
 * Model for keywords for brands that will be used in brand direct on search
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Keywords_model extends CI_Model
{

    /**
     * Create keyword for a brand
     *
     * @param array $keyword_data Contains brand keyword details
     * @return boolean
     */
    public function create($keyword_data)
    {
        $this->db->select('id');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('brand_id', $keyword_data['brand_id']);

        $query = $this->db->get();

        if ($query->num_rows() >= 10) {
            return false;
        }

        $this->db->insert('skearch_brands_keywords', $keyword_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the keyword already exists
     *
     * @param string $keyword Keyword
     * @return boolean
     */
    public function check_exists($keyword)
    {
        $this->db->select('keywords');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('keywords', $keyword);

        $query1 = $this->db->get_compiled_select();

        $this->db->select('keyword');
        $this->db->from('search_keywords');
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
     * Delete brand keywords
     *
     * @param array $id Keyword ID
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_brands_keywords');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get brand keyword
     *
     * @param int $id Keyword ID
     * @return object|false
     */
    public function get($id)
    {
        $this->db->select('*');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Get all keywords for the brand
     *
     * @param int $brand_id Brand ID
     * @return object|false
     */
    public function get_by_brand($brand_id)
    {
        $this->db->select('*');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('brand_id', $brand_id);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Update brand keywords
     *
     * @param int $id Keyword ID
     * @param array $keyword_data Contains brand keyword details
     * @return boolean
     */
    public function update($id, $keyword_data)
    {
        $this->db->where('id', $id);
        $this->db->update('skearch_brands_keywords', $keyword_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
