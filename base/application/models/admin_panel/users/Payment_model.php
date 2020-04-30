<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/users/Payment_model.php
 *
 * User group model
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Payment_model extends CI_Model
{
    /**
     * Creates payment information for the user
     * 
     * @param array $payment_data Information regarding user payment
     * 
     * @return boolean
     */
    public function create($payment_data)
    {
        $this->db->insert('skearch_users_payments', $payment_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get payment information for the user
     *
     * @param int $user_id ID of the user
     * 
     * @return object|false
     */
    public function get($user_id)
    {
        $this->db->select("*");
        $this->db->from('skearch_users_payments');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Updates payment information 
     *
     * @param int $user_id ID of the user
     * @param array $payment_data Information regarding user payment
     * 
     * @return boolean
     */

    public function update($user_id, $payment_data)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('skearch_users_payments', $payment_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
