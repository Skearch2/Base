<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/brand/Keywords_model.php
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
     * Create brandlink
     *
     * @param array $data Array contains mixed data
     * @return void
     */
    public function create($data)
    {
        $this->db->insert('skearch_brands_keywords', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete brand keywords
     *
     * @param int $id Keyword ID
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
     * Get brandlink
     *
     * @param int $id Brandlink ID
     * @return object|false
     */
    public function get_by_id($id)
    {
        $this->db->select('id, brand_id, keywords, url, active, approved');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('skearch_brands_keywords.id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Get brandlinks
     *
     * @param int $id Brand ID
     * @return object|false
     */
    public function get($brand_id = false)
    {
        $this->db->select('skearch_brands_keywords.id, keywords, url, brand, active, approved');
        $this->db->from('skearch_brands_keywords');
        $this->db->join('skearch_brands', 'skearch_brands_keywords.brand_id = skearch_brands.id', 'left');

        if ($brand_id) {
            $this->db->where('skearch_brands_keywords.brand_id', $brand_id);
        }

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
