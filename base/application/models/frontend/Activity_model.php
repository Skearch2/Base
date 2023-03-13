
<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/frontend/Ads_model.php
 *
 * This model monitors user interaction with ads and listing
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2023
 * @version        2.0
 */
class Activity_model extends CI_Model
{
    /**
     * Create ad activity record
     *
     * @param int $id Ad ID
     * @return boolean
     */
    private function create_ad_activity($id)
    {
        $this->db->insert(
            'skearch_ads_activity',
            array('ad_id' => $id, 'clicks' => 1, 'impressions' => 1, 'date' => date("Y-m-d"))
        );

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create link activity record
     *
     * @param int $id Link ID
     * @return boolean
     */
    private function create_link_activity($id)
    {
        $this->db->insert(
            'skearch_links_activity',
            array('link_id' => $id, 'clicks' => 1, 'date' => date("Y-m-d"))
        );

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get ad link reference
     *
     * @param int $id Ad ID
     * @return mixed object|false
     */
    public function get_ad_link_reference($id)
    {
        $this->db->select('skearch_ads.url');
        $this->db->from('skearch_ads');
        $this->db->where('skearch_ads.id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get link url reference
     *
     * @param int $id Link ID
     * @return mixed object|false
     */
    public function get_link_url_reference($id)
    {
        $this->db->select('www');
        $this->db->from('skearch_listings');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Update ad activity
     *
     * @param int    $id     Ad ID
     * @param string $column Column in the ads_activity table: clicks|impressions
     * @return boolean
     */
    public function update_ad_activity($id, $column)
    {
        $this->db->where('ad_id', $id);
        $this->db->where('date', date("Y-m-d"));
        if ($column == 'clicks') {
            $this->db->set('clicks', 'clicks + 1', FALSE);
        } else if ($column == 'impressions') {
            $this->db->set('impressions', 'impressions + 1', FALSE);
        }
        $this->db->update('skearch_ads_activity');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            // if no existing record is updated, create a new activity with current date
            return $this->create_ad_activity($id);
        }
    }

    /**
     * Update link activity
     *
     * @param int    $id     Link ID
     * @return boolean
     */
    public function update_link_activity($id)
    {
        $this->db->where('link_id', $id);
        $this->db->where('date', date("Y-m-d"));
        $this->db->set('clicks', 'clicks + 1', FALSE);
        $this->db->update('skearch_links_activity');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            // if no existing record is updated, create a new activity with current date
            return $this->create_link_activity($id);
        }
    }
}
