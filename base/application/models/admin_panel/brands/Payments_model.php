<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Payments_model.php
 *
 * This model fetch brand payment history
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Payments_model extends CI_Model
{
    /**
     * Create transaction record for Brand payment
     * @param int $data Transcation data
     * @return object
     */
    public function create($data)
    {
        $this->db->insert('skearch_brands_payments', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets payment history for the brand
     *
     * @param int $id Brand ID
     * @return object
     */
    public function get($id)
    {
        $this->db->select('*');
        $this->db->from('skearch_brands_payments');
        $this->db->where('brand_id', $id);
        $this->db->order_by('payment_date', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }
}
