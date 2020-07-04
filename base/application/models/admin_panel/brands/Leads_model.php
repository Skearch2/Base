<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Leads_model.php
 *
 * This model fetch brand leads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <i.ejaz@skearch.net>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Leads_model extends CI_Model
{
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

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets leads
     *
     * @param int $id Lead ID
     * @return object
     */
    public function get($id = null)
    {

        $this->db->select('*');
        $this->db->from('skearch_brand_leads');

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
