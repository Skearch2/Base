<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/brands/brand_model.php
 *
 * Brand model
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Brand_model extends CI_Model
{
    /**
     * Creates a brand
     *
     * @param array $brand_data Required information for brands
     * @return boolean
     */
    public function create($brand_data)
    {
        $this->db->insert('skearch_brands', $brand_data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Deletes brand
     *
     * @param int $id Brand ID
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_brands');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets brand
     *
     * @param int $id Brand ID
     * @return object
     */
    public function get($id = null)
    {
        $this->db->select("*");
        $this->db->from('skearch_brands');

        if ($id) {
            $this->db->where('id', $id);
            $query = $this->db->get();

            return $query->row();
        } else {
            $query = $this->db->get();

            return $query->result();
        }
    }

    /**
     * Gets brand by brand name
     *
     * @param string $brand Brand name
     * @return object
     */
    public function get_by_name($brand)
    {
        $this->db->select('id, brand, organization');
        $this->db->from('skearch_brands');
        $this->db->like('brand', $brand, 'after');
        $this->db->order_by('brand', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Gets brand by user ID
     *
     * @param string $id User ID
     * @return object
     */
    public function get_by_user($id)
    {
        $this->db->select('skearch_brands.id, brand as name, primary_brand_user');
        $this->db->from('skearch_users_brands');
        $this->db->join('skearch_brands', 'skearch_users_brands.brand_id = skearch_brands.id');
        $this->db->where('user_id', $id);
        $query = $this->db->get();

        return $query->row();
    }


    /**
     * Get brand users associated to the brand
     *
     * @param string $id Brand ID
     * @param int $primary_member_only Whether to get only primary member of the brand
     * @return object
     */
    public function get_members($id, $primary_member_only = 0)
    {
        $this->db->select('*');
        $this->db->from('skearch_users');
        $this->db->join('skearch_users_brands', 'skearch_users_brands.user_id = skearch_users.id', 'left');
        $this->db->where('skearch_users_brands.brand_id', $id);
        if ($primary_member_only) {
            $this->db->where('skearch_users_brands.primary_brand_user', 1);
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Link the user to the brand
     *
     * @param int $user_id User ID
     * @param int $brand_id Brand ID
     * @param int $is_primary_brand_user Primary user for the brand
     * @return void
     */
    public function link_user($user_id, $brand_id, $is_primary_brand_user)
    {
        $this->db->replace(
            'skearch_users_brands',
            array('user_id' => $user_id, 'brand_id' => $brand_id, 'primary_brand_user' => $is_primary_brand_user)
        );

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates brand
     *
     * @param int $id Brand ID
     * @param Array $brand_data Required information for brands
     * @return boolean
     */
    public function update($id, $brand_data)
    {
        $this->db->where('id', $id);
        $this->db->update('skearch_brands', $brand_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
