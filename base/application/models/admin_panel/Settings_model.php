<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Category_model.php
 *
 * Model for Site settings
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2021
 * @version      2.0
 */
class Settings_model extends CI_Model
{

    /**
     * Get settings
     *
     * @return void
     */
    public function get()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_settings');

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Update settings
     *
     * @param array $data Array containing mix data
     * @return boolean
     */
    public function update($data)
    {
        $this->db->update('skearch_settings', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
