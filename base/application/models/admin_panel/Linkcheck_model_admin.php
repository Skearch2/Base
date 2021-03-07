<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/Linkcheck_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Linkcheck_model_admin extends CI_Model
{

    /**
     * Get all links
     *
     * @return void
     */
    public function get()
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.enabled, skearch_listings.http_status_code, skearch_listings.last_status_check, skearch_listings.www, skearch_subcategories.title as field, skearch_categories.title as umbrella');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $this->db->join('skearch_categories', 'skearch_categories.id = skearch_subcategories.parent_id');
        // $this->db->not_like('http_status_code', '2', 'after');
        $query = $this->db->get();

        return $query->result();
    }

    /*
     * Returns urls of all adlinks.
     */

    public function get_urls()
    {
        $this->db->select('id, www');
        $this->db->from('skearch_listings');
        $this->db->where('enabled', 1);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Remove link from link checker
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $this->db->set('http_status_code', 200);
        $this->db->where('id', $id);
        $this->db->update('skearch_listings');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_http_status($id, $code)
    {
        $data = array(
            'http_status_code' => $code,
            'last_status_check ' => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id);
        $this->db->update('skearch_listings', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
