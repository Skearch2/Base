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
        $this->db->where('id', 0);
        $this->db->update('skearch_settings', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }




    /**
     * Undocumented function
     *
     * @return void
     */
    public function get_skearch_ver()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_options');
        $query = $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result();
        if (count($result) > 0) {
            return $result[0]->version;
        } else {
            return '';
        }
    }

    public function update_skearch_ver($version)
    {
        $data['version'] = $version;
        $this->db->where("id", 0);
        return $this->db->update('skearch_options', $data);
    }

    /**
     * Enables or disables all adlinks
     *
     * @param [int] $status
     * @return void
     */
    public function brandlinks_status_all($status)
    {
        $data['enabled'] = $status;
        $this->db->where("id", 0);
        return $this->db->update('skearch_brandlinks_status', $data);
    }

    /**
     * Return status
     *
     * @return void
     */
    public function get_brandlinks_status()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_brandlinks_status');
        $query = $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0]->enabled;
    }
}
