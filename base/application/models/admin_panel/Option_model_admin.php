<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Category_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package        Skearch
 * @author        Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018
 * @version        2.0
 */
class Option_model_admin extends CI_Model
{

    public function get_skearch_ver() {
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

    public function update_skearch_ver($version) {
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
    public function brandlinks_status_all($status) {
        $data['enabled'] = $status;
        $this->db->where("id", 0);
        return $this->db->update('skearch_brandlinks_status', $data);
    }
    
    /**
     * Return status
     *
     * @return void
     */
    public function get_brandlinks_status() {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_brandlinks_status');
        $query = $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0]->enabled;
    }
}
