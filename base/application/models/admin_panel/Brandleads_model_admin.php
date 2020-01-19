<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Brandleads_model_admin.php
 *
 * This model fetch brand leads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Brandleads_model_admin extends CI_Model
{
    /**
     * Get all brandleads
     *
     * @return object
     */
    public function get()
    {
        $this->db->select('*');
        $this->db->from('skearch_brand_leads');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Delete a brandlead
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_brand_leads');
    }
}
