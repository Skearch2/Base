<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/brand/Deal_model.php
 *
 * This model helps create, update, and view brand deals
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2022
 * @version        2.0
 */
class Deals_model extends CI_Model
{

    /**
     * Create deal
     *
     * @param array $deal_data Contains deal data
     * @return boolean
     */
    public function create($deal_data)
    {
        $this->db->insert('brands_deals', $deal_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete deal
     *
     * @param array $id Deal ID
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('brands_deals');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all deals
     *
     * @param string $status Status of the brand
     * @return object|false
     */
    public function get($status = null)
    {
        $this->db->select('*');
        $this->db->from('brands_deals');
        $this->db->join('skearch_brands', 'brands_deals.brand_id = skearch_brands.id', 'left');

        if ($status) {
            $this->db->where('status', $status);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get deals by brand id
     *
     * @param int $brand_id Brand ID
     * @return object|false
     */
    public function get_by_brand($brand_id)
    {
        $this->db->select('*');
        $this->db->from('brands_deals');
        $this->db->where('brand_id', $brand_id);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get deal by id
     *
     * @param int $id Deal ID
     * @return object|false
     */
    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('brands_deals');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Verify user particiaption in the brand deals
     *
     * @param int   $giveaway_id   giveaway id
     * @param int   $user_id   user id
     * @return mixed object|false
     */
    public function get_brands_deals_opted_in_by_user($user_id)
    {
        $this->db->select('brands_deals.id');
        $this->db->from('brands_deals_participants');
        $this->db->join('brands_deals', 'brands_deals_participants.brand_deal_id = brands_deals.id', 'left');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'running');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    /**
     * Insert participants for the brand deal
     *
     * @param int   $id   deal id
     * @param int   $id   user id

     * @return boolean
     */
    public function insert_participant($deal_id, $user_id)
    {
        $data = [
            'brand_deal_id' => $deal_id,
            'user_id' => $user_id
        ];

        $this->db->insert('brands_deals_participants', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update deal
     *
     * @param int $id Deal ID
     * @param array $deal_data Contains deal data
     * @return boolean
     */
    public function update($id, $deal_data)
    {
        $this->db->where('id', $id);
        $this->db->update('brands_deals', $deal_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update deals status on start date or end date
     *
     * @return boolean
     */
    public function update_status()
    {
        $this->db->trans_start();

        $this->db->set('status', 'running');
        $this->db->where('status', 'pending');
        $this->db->where('start_date < NOW()');
        $this->db->update('brands_deals');

        $this->db->set('status', 'completed');
        $this->db->where('status', 'running');
        $this->db->where('end_date < NOW()');
        $this->db->update('brands_deals');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            print_r($this->db->trans_status());
            die();
            return false;
        }
    }
}
