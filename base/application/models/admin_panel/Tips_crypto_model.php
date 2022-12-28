<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Tips_crypto_model.php
 *
 * Model for Tips system
 * Create, edit, delete, and manage crpto addresses for tips
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2022
 * @version        2.0
 */
class Tips_crypto_model extends CI_Model
{
    /**
     * Create an ad
     *
     * @param array $data array contains data for the giveaway
     *              $data[id, title, date_created, end_date, is_archived]
     * @return boolean
     */
    public function create($data)
    {
        $this->db->insert('skearch_tips', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete giveaway
     *
     * @param int $id giveaway id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_tips');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all giveaways
     *
     * @return mixed object|false
     */
    public function get()
    {
        $this->db->select('*');
        $this->db->from('skearch_tips');

        $query = $this->db->get();

        return $query->result();
    }
}
