<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/TOS_PP_model.php
 *
 * Model for TOS/PP
 * Manage TOS/PP
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2023
 * @version        2.0
 */
class Tos_pp_model extends CI_Model
{
    /**
     * Create entry for TOS/PP
     *
     * @param string $data TOS/PP text
     * @return boolean
     */
    public function create($data)
    {
        $this->db->insert('skearch_tos_pp', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete TOS/PP
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('skearch_tos_pp');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all TOS/PP
     *
     * @param  int id
     * @return mixed object
     */
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('skearch_tos_pp');
        $this->db->order_by('date_created', 'DESC');

        if ($id) {
            $this->db->where('id', $id);
            $query = $this->db->get();

            return $query->row();
        } else {
            $query = $this->db->get();

            return $query->result();
        }
    }
}
