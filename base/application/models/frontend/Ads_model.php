
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
}
