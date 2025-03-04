<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/brand/brandlink_model.php
 *
 * Model for BrandLinks
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
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
     * Check if the keyword already exists as brandlink keyword
     *
     * @param string $keyword Keyword
     * @return boolean
     */
    public function duplicate_check($string)
    {
        $this->db->select('keyword');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->where('keyword', $string);

        $query = $this->db->get();

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
     * @param int $id Brand ID
     * @return object|false
     */
    public function get($brand_id = false)
    {
        $this->db->select('skearch_brands_brandlinks.id, keyword, url, brand_id, brand, active, approved');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->join('skearch_brands', 'skearch_brands_brandlinks.brand_id = skearch_brands.id', 'left');

        if ($brand_id) {
            $this->db->where('skearch_brands_brandlinks.brand_id', $brand_id);
        }

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
