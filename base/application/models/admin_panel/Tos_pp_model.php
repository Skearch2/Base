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

        if ($this->db->affected_rows()) {
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

        if (!empty($id)) {
            $this->db->where('id', $id);
            $query = $this->db->get();

            return $query->row();
        } else {
            $query = $this->db->get();

            return $query->result();
        }
    }

    /**
     * Get latest TOS/PP
     *
     * @return mixed object
     */
    public function get_latest()
    {
        $this->db->select('id');
        $this->db->from('skearch_tos_pp');
        $this->db->order_by('date_created', 'DESC');
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Update latest TOS/PP
     *
     * @param int   $id   TOS/PP id
     * @param array $data array contains TOS data
     *              $data[title, content]
     * @return boolean
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('skearch_tos_pp', $data);

        $this->db->where('tos_id', $id);
        $this->db->delete('skearch_users_tos');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
