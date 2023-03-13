<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/results/Link_model.php
 *
 * Model for Links
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Link_model extends CI_Model
{
    /**
     * Creates a link
     *
     * @param array $link_data Array contains data for the link
     * @return void
     */
    public function create($link_data)
    {
        $this->db->insert('skearch_listings', $link_data);

        $link_id = $this->db->insert_id();

        if ($this->db->affected_rows()) {
            // create initial activity record for the link after it is created
            return $this->create_link_activity($link_id);
        } else {
            return false;
        }
    }

    /**
     * Create link click activity record
     *
     * @param int $link_id Ad ID
     * @return boolean
     */
    private function create_link_activity($link_id)
    {
        $this->db->insert(
            'skearch_links_activity',
            array('link_id' => $link_id, 'clicks' => 0, 'date' => date("Y-m-d"))
        );

        if ($this->db->affected_rows()) {
            return $link_id;
        } else {
            return false;
        }
    }

    /**
     * Reset link clicks history
     *
     * @param int  $id   Link ID
     * @return boolean
     */
    public function reset_link_activity($id)
    {
        $this->db->where('link_id', $id);
        $this->db->delete('skearch_ads_activity');

        if ($this->db->affected_rows()) {
            return $this->create_link_activity($id);
        } else {
            return false;
        }
    }

    /**
     * Deletes a link
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('skearch_listings');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the url already associated to a link in the field
     *
     * @param string $url URL
     * @param int    $field_id Field ID
     * @return boolean
     */
    public function check_duplicate_url_in_field($url, $field_id)
    {
        $this->db->select("id");
        $this->db->from('skearch_listings');
        $this->db->where('www', $url);
        $this->db->where('sub_id', $field_id);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets a link
     *
     * @param int $id An id of a link
     * @return object|false
     */
    public function get($id)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS field_id, skearch_subcategories.title AS field');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
        $this->db->where('skearch_listings.id', $id);
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }


    /**
     * Gets links by brand direct status
     *
     * @param int $id An id of a link
     * @param string $status Status for the brandlinks
     * @return object
     */
    public function get_by_branddirect_status($status = NULL)
    {
        $this->db->select('links.id, links.title, links.description_short, COALESCE(sum(skearch_links_activity.clicks), 0) as clicks,
        links.enabled, links.www, links.display_url, links.priority, links.redirect, fields.id AS field_id, fields.title AS field');
        $this->db->from('skearch_listings as links');
        $this->db->join('skearch_subcategories as fields', 'fields.id = links.sub_id', 'left');
        $this->db->join('skearch_categories as umbrellas', 'umbrellas.id = fields.parent_id', 'left');
        $this->db->join('skearch_links_activity', 'skearch_links_activity.link_id = links.id', 'left');
        $this->db->where('umbrellas.enabled', 1);
        $this->db->where('fields.enabled', 1);
        $this->db->where('links.enabled', 1);
        if ($status == 'inactive') {
            $this->db->where('links.redirect', 0);
        } elseif ($status == 'active') {
            $this->db->where('links.redirect', 1);
        }
        $this->db->group_by('links.id');
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }


    /**
     * Gets links by field
     *
     * @param int $id An id of a link
     * @param string $status Status for the links
     * @return object|false
     */
    public function get_by_field($field_id, $status = NULL)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        COALESCE(sum(skearch_links_activity.clicks), 0) as clicks, skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS field_id, skearch_subcategories.title AS field');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id', 'left');
        $this->db->join('skearch_links_activity', 'skearch_links_activity.link_id = skearch_listings.id', 'left');
        $this->db->where('skearch_listings.sub_id', $field_id);
        if ($status == 'inactive') {
            $this->db->where('skearch_listings.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_listings.enabled', 1);
        }
        $this->db->group_by('skearch_listings.id');
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Gets links by status
     *
     * @param int $id An id of a link
     * @param string $status Status for the links
     * @return object
     */
    public function get_by_status($status = NULL)
    {
        $this->db->select('skearch_listings.id, skearch_listings.title, skearch_listings.description_short,
        COALESCE(sum(skearch_links_activity.clicks), 0) as clicks, skearch_listings.enabled, skearch_listings.www, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect, skearch_subcategories.id AS field_id, skearch_subcategories.title AS field');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id', 'left');
        $this->db->join('skearch_links_activity', 'skearch_links_activity.link_id = skearch_listings.id', 'left');
        if ($status == 'inactive') {
            $this->db->where('skearch_listings.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_listings.enabled', 1);
        }
        $this->db->group_by('skearch_listings.id');
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Get links based on keywords
     *
     * @param string $keywords Keywords for the title of the link
     * @return void
     */
    public function get_by_keywords($keywords)
    {
        if ($keywords == NULL) {
            return;
        }

        $this->db->select('skearch_subcategories.title AS stitle, skearch_listings.title, skearch_listings.id, skearch_listings.description_short,
        COALESCE(sum(skearch_links_activity.clicks), 0) as clicks, skearch_listings.enabled, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect ');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id', 'left');
        $this->db->join('skearch_links_activity', 'skearch_links_activity.link_id = skearch_listings.id', 'left');
        $this->db->like('skearch_listings.title', $keywords, 'after');
        $this->db->group_by('skearch_listings.id');
        $this->db->order_by('title', 'ASC');

        $query = $this->db->get();

        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Get clicks and impressions history based on month and year for the link
     *
     * @param int $id Link ID
     * @param int $month_and_year Month and Year
     * @return mixed object
     */
    public function get_link_activity($id, $month_and_year)
    {
        $this->db->select('link_id, clicks, DATE_FORMAT(date, "%b %d %Y") as date');
        $this->db->from('skearch_links_activity');
        $this->db->where('link_id', $id);
        $this->db->like('date', $month_and_year, 'after');
        $this->db->order_by('date', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get monthly clicks and impressions based on the year for the link
     *
     * @param int $id Ad ID
     * @param int $year Year
     * @return mixed object
     */
    public function get_ad_yearly_stats($id, $year)
    {
        $this->db->select('link_id, COALESCE(sum(skearch_links_activity.clicks), 0) as clicks, DATE_FORMAT(date, "%c") as month, DATE_FORMAT(date, "%Y") as year');
        $this->db->from('skearch_links_activity');
        $this->db->where('link_id', $id);
        $this->db->like('date', $year, 'after');
        $this->db->group_by(array('DATE_FORMAT(date, "%c")', 'DATE_FORMAT(date, "%Y")'));
        $this->db->order_by('month', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get oldest activity year for the link
     *
     * @param int $id Link ID
     * @return mixed object
     */
    public function get_oldest_activity_year($id)
    {
        $this->db->select('DATE_FORMAT(date, "%Y") as year');
        $this->db->from('skearch_links_activity');
        $this->db->where('link_id', $id);
        $this->db->order_by('date', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row()->year;
        } else {
            return Date('Y');
        }
    }

    /**
     * Get priorities of the links for the field
     *
     * @param int $field_id ID of the field
     *
     * @return void
     */
    public function get_links_priority($field_id)
    {
        $query = $this->db->select('title, priority');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->where('sub_id', $field_id);
        $query = $this->db->order_by('priority', 'AESC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Updates a link
     *
     * @param int $id ID of the link
     * @param array $link_data Array contains data for the umbrella
     * @return void
     */
    public function update($id, $link_data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('skearch_listings', $link_data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
