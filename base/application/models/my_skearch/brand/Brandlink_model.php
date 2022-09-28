<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/brand/Brandlink_model.php
 *
 * Model for keywords for brands that will be used in brand direct on search
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Brandlink_model extends CI_Model
{

    /**
     * Create BrandLink
     *
     * @param array $data Array contains mixed data
     * @return void
     */
    public function create($data)
    {
        $this->db->insert('skearch_brands_brandlinks', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete BrandLink
     *
     * @param int $id BrandLink ID
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_brands_brandlinks');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the keyword already exists as brandlink keyword or search keyword
     *
     * @param string $keyword Keyword
     * @return boolean
     */
    public function duplicate_check($keyword)
    {
        $this->db->select('keyword');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->where('keyword', $keyword);

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
     * Get BrandLink
     *
     * @param int $id Brandlink ID
     * @return object|false
     */
    public function get_by_id($id)
    {
        $this->db->select('id, brand_id, keyword, url, active, approved');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->where('skearch_brands_brandlinks.id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Get BrandLinks
     *
     * @param int $brand_id Brand ID
     * @return object|false
     */
    public function get($brand_id)
    {
        $this->db->select('skearch_brands_brandlinks.id, keyword, url, brand, active, approved');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->join('skearch_brands', 'skearch_brands_brandlinks.brand_id = skearch_brands.id', 'left');
        $this->db->where('skearch_brands_brandlinks.brand_id', $brand_id);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Update BrandLink
     *
     * @param int $id BrandLink ID
     * @param array $brandlink_data Array contains mixed data
     * @return boolean
     */
    public function update($id, $brandlink_data)
    {
        $this->db->where('id', $id);
        $this->db->update('skearch_brands_brandlinks', $brandlink_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
