
<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/frontend/Ads_model.php
 *
 * Ads model for front end
 * Fetch ads, updates clicks and impressions
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Ads_model extends CI_Model
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
            array('ad_id' => $id, 'clicks' => 0, 'impressions' => 0, 'date' => date("Y-m-d"))
        );

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get ads
     *
     * @param int    $banner       Banner type
     * @param int    $scope        Scope of the banner
     * @param int    $scope_id     Scope ID
     * @return mixed object
     */
    public function get_ads($banner, $scope, $scope_id)
    {
        $this->db->select('skearch_ads.id, skearch_ads.title, CONCAT(skearch_banners.folder,"/",skearch_ads.media) as media, skearch_ads.url, (skearch_ads.duration * 1000) as duration, skearch_ads.has_sign');
        $this->db->from('skearch_ads');
        $this->db->join('skearch_banners', 'skearch_ads.banner_id = skearch_banners.id', 'left');
        $this->db->where('skearch_banners.banner', $banner);
        $this->db->where('skearch_banners.scope', $scope);
        $this->db->where('skearch_banners.scope_id', $scope_id);
        $this->db->where('skearch_ads.is_active', 1);
        $this->db->where('skearch_ads.is_archived', 0);
        $this->db->order_by('priority', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get ads associated to a brand
     *
     * @param int    $brand_id     Brand ID
     * @return mixed object
     */
    public function get_ads_by_brand($brand_id)
    {
        $this->db->select('skearch_ads.id, skearch_ads.title, CONCAT(skearch_banners.folder,"/",skearch_ads.media) as media, skearch_ads.url, skearch_ads.duration, skearch_ads.has_sign, skearch_ads.is_active,
        sum(skearch_ads_activity.clicks) as clicks, sum(skearch_ads_activity.impressions) as impressions');
        $this->db->from('skearch_ads');
        $this->db->join('skearch_ads_activity', 'skearch_ads.id = skearch_ads_activity.ad_id', 'left');
        $this->db->join('skearch_banners', 'skearch_ads.banner_id = skearch_banners.id', 'left');
        $this->db->where('skearch_ads.brand_id', $brand_id);
        $this->db->group_by('skearch_ads.id');

        $query = $this->db->get();

        return $query->result();
    }


    /**
     * Get ad link reference
     *
     * @param int $id Ad ID
     * @return mixed object|false
     */
    public function get_link_reference($id)
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
}
