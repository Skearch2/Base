<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/brand/Media_vault_model.php
 *
 * Model for Media Vault
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Media_vault_model extends CI_Model
{

    /**
     * Create media
     *
     * @param array $media_data Contains media data
     * @return boolean
     */
    public function create($media_data)
    {
        $this->db->insert('brands_media_vault', $media_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete media
     *
     * @param array $id Media ID
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('brands_media_vault');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get particular media
     *
     * @param int $id Media ID
     * @return object|false
     */
    public function get($id)
    {
        $this->db->select('*');
        $this->db->from('brands_media_vault');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Get all media for the brand
     *
     * @param int $brand_id Brand ID
     * @return object|false
     */
    public function get_by_brand($brand_id)
    {
        $this->db->select('*');
        $this->db->from('brands_media_vault');
        $this->db->where('brand_id', $brand_id);

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Update media
     *
     * @param int $id Media ID
     * @param array $media_data Contains media data
     * @return boolean
     */
    public function update($id, $media_data)
    {
        $this->db->where('id', $id);
        $this->db->update('brands_media_vault', $media_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
