<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Ads_manager_model.php
 *
 * Model for Ads manager
 * Create, edit, delete, and manage ads
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Ads_manager_model extends CI_Model
{
    /**
     * Create an ad
     *
     * @param array $data Array contains data for the ad
     *              $data[banner_id, brand_id, title, media, url, duration, priority, is_active, has_sign, is_archived, date_created]
     * @return boolean
     */
    public function create_ad($data)
    {
        $this->db->insert('skearch_ads', $data);

        $ad_id = $this->db->insert_id();

        if ($this->db->affected_rows()) {
            // create initial activity record for the ad after it is created
            return $this->create_ad_activity($ad_id);
        } else {
            return false;
        }
    }

    /**
     * Create ad activity record
     *
     * @param int $ad_id Ad ID
     * @return boolean
     */
    private function create_ad_activity($ad_id)
    {
        $this->db->insert(
            'skearch_ads_activity',
            array('ad_id' => $ad_id, 'clicks' => 0, 'impressions' => 0, 'date' => date("Y-m-d"))
        );

        if ($this->db->affected_rows()) {
            return $ad_id;
        } else {
            return false;
        }
    }

    /**
     * Create ad banner
     *
     * @param string $scope     Scope of the banner
     * @param int    $scope_id  Scope ID
     * @param string $banner    Banner type
     * @param string $folder    Folder where media are stored
     * @return void
     */
    public function create_banner($scope, $scope_id, $banner, $folder)
    {
        $data = array(
            'scope'     => $scope,
            'scope_id'  => $scope_id,
            'banner'    => $banner,
            'folder'    => $folder
        );

        $this->db->insert('skearch_banners', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Get number of ads in a banner
     *
     * @param int $banner_id anner ID
     * @return int number of rows
     */
    public function count_ads_in_banner($banner_id)
    {
        $this->db->select('skearch_ads.priority');
        $this->db->from('skearch_ads');
        $this->db->where('skearch_ads.banner_id', $banner_id);
        $this->db->where('skearch_ads.is_archived', 0);

        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * Delete ad
     *
     * @param int $id Ad id
     * @return boolean
     */
    public function delete_ad($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_ads');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all current or archived ads that corresponds to defined banner, scope and scope id
     *
     * @param int    $banner       Banner type
     * @param int    $scope        Scope of the banner
     * @param int    $scope_id     Scope ID
     * @param int    $is_archived  Whether ad is current or archived
     * @return mixed object
     */
    public function get_ads($banner, $scope, $scope_id, $is_archived = 0)
    {
        $this->db->select('skearch_ads.id, skearch_ads.title, CONCAT(skearch_banners.folder,"/",skearch_ads.media) as media, skearch_ads.url, skearch_ads.duration, skearch_ads.priority,
        sum(skearch_ads_activity.clicks) as clicks, sum(skearch_ads_activity.impressions) as impressions, skearch_ads.is_active, skearch_ads.has_sign, skearch_ads.is_archived, skearch_ads.date_modified, skearch_ads.date_created,
        skearch_ads.brand_id, skearch_brands.brand');
        $this->db->from('skearch_ads');
        $this->db->join('skearch_ads_activity', 'skearch_ads.id = skearch_ads_activity.ad_id', 'left');
        $this->db->join('skearch_banners', 'skearch_ads.banner_id = skearch_banners.id', 'left');
        $this->db->join('skearch_brands', 'skearch_ads.brand_id = skearch_brands.id', 'left');
        $this->db->where('skearch_banners.banner', $banner);
        $this->db->where('skearch_banners.scope', $scope);
        $this->db->where('skearch_banners.scope_id', $scope_id);
        $this->db->where('skearch_ads.is_archived', $is_archived);
        $this->db->order_by('priority', 'ASC');
        $this->db->group_by('skearch_ads.id');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get all current ads that corresponds to brand
     *
     * @param int    $scope_id     Brand ID
     * @return mixed object
     */
    public function get_ads_by_brand_id($brand_id, $is_archived = 0)
    {
        $this->db->select('skearch_ads.id, skearch_ads.title, CONCAT(skearch_banners.folder,"/",skearch_ads.media) as media, skearch_ads.url, skearch_ads.duration, skearch_ads.priority,
        sum(skearch_ads_activity.clicks) as clicks, sum(skearch_ads_activity.impressions) as impressions, skearch_ads.is_active, skearch_ads.has_sign, skearch_ads.is_archived, skearch_ads.date_modified, skearch_ads.date_created,
        skearch_ads.brand_id, skearch_brands.brand, skearch_banners.scope, skearch_banners.scope_id');
        $this->db->from('skearch_ads');
        $this->db->join('skearch_ads_activity', 'skearch_ads.id = skearch_ads_activity.ad_id', 'left');
        $this->db->join('skearch_banners', 'skearch_ads.banner_id = skearch_banners.id', 'left');
        $this->db->join('skearch_brands', 'skearch_ads.brand_id = skearch_brands.id', 'left');
        $this->db->where('skearch_ads.brand_id', $brand_id);
        $this->db->where('skearch_ads.is_archived', $is_archived);
        $this->db->order_by('skearch_ads.date_modified', 'DESC');
        $this->db->group_by('skearch_ads.id');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get last priority in a banner
     *
     * @param int    $banner_id  Banner ID
     * @return mixed object
     */
    public function get_last_priority($banner_id)
    {
        $this->db->select('skearch_ads.priority');
        $this->db->from('skearch_ads');
        $this->db->where('banner_id', $banner_id);
        $this->db->where('is_archived', 0);
        $this->db->order_by('priority', 'DESC');

        $query = $this->db->get();

        return $query->row();
    }


    /**
     * Sequence ads priority after archiving an ad in the banner
     *
     * @param int    $banner_id  Banner ID
     * @param int    $priority   Deleted ad's priority
     * @return boolean
     */
    public function sequence_priority($banner_id, $priority)
    {
        $this->db->set('priority', 'priority-1', false);
        $this->db->where('banner_id', $banner_id);
        $this->db->where('priority >', $priority);
        $this->db->update('skearch_ads');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Get specific ad
     *
     * @param int $id Ad ID
     * @return mixed object|false
     */
    public function get_ad($id)
    {
        $this->db->select('skearch_ads.id, skearch_ads.title, CONCAT(skearch_banners.folder,"/",skearch_ads.media) as media, skearch_ads.url, skearch_ads.duration, skearch_ads.priority,
        sum(skearch_ads_activity.clicks) as clicks, sum(skearch_ads_activity.impressions) as impressions, skearch_ads.is_active, skearch_ads.has_sign, skearch_ads.is_archived, skearch_ads.date_modified, skearch_ads.date_created,
        skearch_ads.brand_id, skearch_brands.brand, skearch_banners.scope, skearch_banners.scope_id');
        $this->db->from('skearch_ads');
        $this->db->join('skearch_ads_activity', 'skearch_ads.id = skearch_ads_activity.ad_id', 'left');
        $this->db->join('skearch_banners', 'skearch_ads.banner_id = skearch_banners.id', 'left');
        $this->db->join('skearch_brands', 'skearch_ads.brand_id = skearch_brands.id', 'left');
        $this->db->where('skearch_ads.id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get clicks and impressions history based on month and year for the ad
     *
     * @param int $id Ad ID
     * @param int $month_and_year Month and Year
     * @return mixed object
     */
    public function get_ad_activity($id, $month_and_year)
    {
        $this->db->select('ad_id, clicks, impressions, DATE_FORMAT(date, "%b %d %Y") as date');
        $this->db->from('skearch_ads_activity');
        $this->db->where('ad_id', $id);
        $this->db->like('date', $month_and_year, 'after');
        $this->db->order_by('date', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get monthly clicks and impressions based on the year for the ad
     *
     * @param int $id Ad ID
     * @param int $year Year
     * @return mixed object
     */
    public function get_ad_yearly_stats($id, $year)
    {
        $this->db->select('ad_id, sum(skearch_ads_activity.clicks) as clicks, sum(skearch_ads_activity.impressions) as impressions, DATE_FORMAT(date, "%c") as month, DATE_FORMAT(date, "%Y") as year');
        $this->db->from('skearch_ads_activity');
        $this->db->where('ad_id', $id);
        $this->db->like('date', $year, 'after');
        $this->db->group_by(array('DATE_FORMAT(date, "%c")', 'DATE_FORMAT(date, "%Y")'));
        $this->db->order_by('month', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get oldest activity year for the ad
     *
     * @param int $id Ad ID
     * @return mixed object
     */
    public function get_oldest_activity_year($id)
    {
        $this->db->select('DATE_FORMAT(date, "%Y") as year');
        $this->db->from('skearch_ads_activity');
        $this->db->where('ad_id', $id);
        $this->db->order_by('date', 'ASC');

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Get banner id
     *
     * @param int    $scope        Scope of the banner
     * @param int    $scope_id     Scope ID
     * @param int    $banner       Banner type
     * @return mixed object|false
     */
    public function get_banner($scope, $scope_id, $banner)
    {
        $this->db->select('id');
        $this->db->from('skearch_banners');
        $this->db->where('scope', $scope);
        $this->db->where('scope_id', $scope_id);
        $this->db->where('banner', $banner);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Reset ad clicks and impressions history
     *
     * @param int   $id   Ad ID
     * @return boolean
     */
    public function reset_ad_activity($id)
    {
        $this->db->where('ad_id', $id);
        $this->db->delete('skearch_ads_activity');

        if ($this->db->affected_rows()) {
            return $this->create_ad_activity($id);
        } else {
            return false;
        }
    }

    /**
     * Updates an ad information
     *
     * @param int   $id   Ad ID
     * @param array $data Array contains data for the ad
     *              $data[banner_id, brand_id, title, media, url, duration, priority, is_active, has_sign, is_archived, date_created]
     * @return boolean
     */
    public function update_ad($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('skearch_ads', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates ad priorities in the banner
     *
     * @param int   $banner_id   Banner ID
     * @param array $data Array of arrays containing id and its priority
     * @return boolean
     */
    public function update_ad_priority($banner_id, $data)
    {
        $this->db->update_batch('skearch_ads', $data, 'id');
        $this->db->where('banner_id', $banner_id);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
