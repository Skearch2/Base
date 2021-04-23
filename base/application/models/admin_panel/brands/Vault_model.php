<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/brands/Vault_model.php
 *
 * Model for Media Vault
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Vault_model extends CI_Model
{
    /**
     * Get media from the media vault of the brand
     *
     * @param int $brand_id Brand ID
     * @return object|false
     */
    public function get($brand_id)
    {
        $this->db->select('*');
        $this->db->from('brands_media_vault');
        $this->db->where('brand_id', $brand_id);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get particular media from the media vault
     *
     * @param int $id Media ID
     * @return object|false
     */
    public function get_media($id)
    {
        $this->db->select('*');
        $this->db->from('brands_media_vault');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Update media status
     *
     * @param int $id Media ID
     * @param int $status Media status
     * @return boolean
     */
    public function update_status($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('brands_media_vault');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
