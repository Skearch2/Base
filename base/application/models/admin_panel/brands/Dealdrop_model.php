<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/brand/Dealdrop_model.php
 *
 * This model helps create, update, and view brand deal drop
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2022
 * @version        2.0
 */
class Dealdrop_model extends CI_Model
{
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
    public function get()
    {
        $this->db->select('*');
        $this->db->from('brands_deals');

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
