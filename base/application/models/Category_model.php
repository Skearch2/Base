<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/frontend/Results_model.php
 *
 * This model returns all the results which includes:
 * Umbrellas, Fields, Links, Homepage results, Suggestions for umbrellas and fields
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2022
 * @version		2.0
 */
class Category_model extends CI_Model
{

    /**
     * Returns category ID
     * @param string $category_name
     * @return int
     */
    public function get_category_id($category_name)
    {

        $category_name = urldecode($category_name);
        $query = $this->db->select('id');
        $query = $this->db->from('skearch_categories');
        $query = $this->db->where('enabled', 1);
        $query = $this->db->where('title', $category_name);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Returns subcategory ID
     * @param string $subcategory_name
     * @return int
     */
    public function get_subcategory_id($subcategory_name)
    {

        $subcategory_name = urldecode($subcategory_name);
        $query = $this->db->select('id');
        $query = $this->db->from('skearch_subcategories');
        $query = $this->db->where('enabled', 1);
        $query = $this->db->where('title', $subcategory_name);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Returns number of categories based on defined limit
     * @param int $limit
     * @return object
     */
    public function get_categories($limit = NULL, $order = 'ASC', $columns = '*')
    {

        $query = $this->db->select($columns);
        $query = $this->db->from('skearch_categories');
        $query = $this->db->limit($limit);
        $query = $this->db->where('enabled', 1);
        $query = $this->db->order_by("title", $order);
        $query = $this->db->get();
        if ($query) return $query->result();
        else return false;
    }

    /**
     * Returns subcategories of a category
     * Limit can be used to get defined number of subcategories
     * @param string $subcategory_name
     * @param int $limit
     * @return object
     */
    public function get_subcategories($category_id = NULL, $limit = NULL, $order = 'ASC', $columns = '*')
    {

        $query = $this->db->select($columns);
        $query = $this->db->from('skearch_subcategories');
        if ($category_id != NULL) {
            //$query = $this->db->join('skearch_subcategory_to_category','skearch_subcategory_to_category.sub_id = skearch_subcategories.id');
            //$query = $this->db->where('skearch_subcategory_to_category.cat_id', $category_id);
            $query = $this->db->where('parent_id', $category_id);
        }
        $query = $this->db->where('enabled', 1);
        $query = $this->db->limit($limit);
        $query = $this->db->order_by("title", $order);
        $query = $this->db->get();
        if ($query) return $query->result();
        else return false;
    }

    /**
     * Get listings from a category/subcategory
     * Order is used to order the data
     * 
     * @param string $field_id
     * @param string $order
     * @return object
     */
    public function get_adlinks($field_id, $order)
    {
        $this->db->select('skearch_listings.id, priority, title, description_short, display_url, COALESCE(sum(clicks), 0) as clicks');
        $this->db->from('skearch_listings');
        $this->db->join('skearch_links_activity', 'skearch_links_activity.link_id = skearch_listings.id', 'left');
        $this->db->where('enabled', 1);
        $this->db->where('sub_id', $field_id);
        $this->db->group_by('skearch_listings.id');

        if ($order == 'clicks') {
            $this->db->order_by('clicks', 'desc');
            $this->db->order_by('title', 'asc');
        } else if ($order == 'asc') {
            $this->db->order_by('title', 'asc');
        } else if ($order == 'desc') {
            $this->db->order_by('title', 'desc');
        } else if ($order == 'random') {
            $this->db->order_by('title', 'random');
        } else {
            $this->db->order_by('priority', 'asc');
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get suggestions for the homepage
     * 
     * @return object|boolean
     */
    public function get_homepage_results()
    {
        $this->db->select("skearch_homepage_fields.id, skearch_homepage_fields.result_id, skearch_homepage_fields.is_result_umbrella, skearch_categories.title, skearch_categories.home_display, null as umbrella", false);
        $this->db->from('skearch_homepage_fields');
        $this->db->join('skearch_categories', 'skearch_homepage_fields.result_id = skearch_categories.id', 'left');
        $this->db->where('skearch_homepage_fields.is_result_umbrella', 1);
        $query1 = $this->db->get_compiled_select();

        $this->db->select("skearch_homepage_fields.id, skearch_homepage_fields.result_id, skearch_homepage_fields.is_result_umbrella, skearch_subcategories.title, skearch_subcategories.home_display, skearch_categories.title as umbrella", false);
        $this->db->from('skearch_homepage_fields');
        $this->db->join('skearch_subcategories', 'skearch_homepage_fields.result_id = skearch_subcategories.id', 'left');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('is_result_umbrella', 0);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id ASC");

        return $query->result();
    }

    /**
     * Get umbrella title
     * 
     * @param int $umbrella_id
     * @return object
     */
    public function get_category_title($umbrella_id)
    {

        $this->db->select('title');
        $this->db->from('skearch_categories');
        $this->db->where('id', $umbrella_id);

        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Get field and its umbrella title
     * 
     * @param int $field_id
     * @return object
     */
    public function get_field_and_umbrella_title($field_id)
    {

        $this->db->select('skearch_categories.title as umbrella, skearch_subcategories.title as field');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('skearch_subcategories.id', $field_id);
        $query = $this->db->get();

        return $query->row();
    }

    /*
     * Returns ad results that are enabled and has active redirection
     */
    public function get_results()
    {
        $query = $this->db->select('display_url, www');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->where('redirect', 1);
        $query = $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get suggestions for the field
     *
     * @param int $field_id
     * @return object|boolean
     */
    public function get_field_suggestions($field_id)
    {
        $this->db->select('title');
        $this->db->from('skearch_categories');
        $this->db->where('skearch_categories.id = skearch_fields_suggestions.result_id');
        $sub_query1 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title, null as umbrella", false);
        $this->db->from('skearch_fields_suggestions');
        $this->db->where('field_id', $field_id);
        $this->db->where('is_result_umbrella', 1);
        $query1 = $this->db->get_compiled_select();

        $this->db->select('skearch_subcategories.title');
        $this->db->from('skearch_subcategories');
        $this->db->where('skearch_subcategories.id = skearch_fields_suggestions.result_id');
        $sub_query2 = $this->db->get_compiled_select();

        $this->db->select('skearch_categories.title as umbrella');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('skearch_subcategories.id = skearch_fields_suggestions.result_id');
        $sub_query3 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title, ($sub_query3) as umbrella");
        $this->db->from('skearch_fields_suggestions');
        $this->db->where('field_id', $field_id);
        $this->db->where('is_result_umbrella', 0);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

        return $query->result();
    }

    /**
     * Get suggestions for the umbrella
     *
     * @param int $umbrella_id
     * @return object|boolean
     */
    public function get_umbrella_suggestions($umbrella_id)
    {
        $this->db->select('title');
        $this->db->from('skearch_categories');
        $this->db->where('skearch_categories.id = skearch_umbrella_suggestions.result_id');
        $sub_query1 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title, null as umbrella", false);
        $this->db->from('skearch_umbrella_suggestions');
        $this->db->where('umbrella_id', $umbrella_id);
        $this->db->where('is_result_umbrella', 1);
        $query1 = $this->db->get_compiled_select();

        $this->db->select('skearch_subcategories.title');
        $this->db->from('skearch_subcategories');
        $this->db->where('skearch_subcategories.id = skearch_umbrella_suggestions.result_id');
        $sub_query2 = $this->db->get_compiled_select();

        $this->db->select('skearch_categories.title as umbrella');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('skearch_subcategories.id = skearch_umbrella_suggestions.result_id');
        $sub_query3 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title, ($sub_query3) as umbrella");
        $this->db->from('skearch_umbrella_suggestions');
        $this->db->where('umbrella_id', $umbrella_id);
        $this->db->where('is_result_umbrella', 0);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

        return $query->result();
    }

    /**
     * Return global brandlink status
     *
     * @return boolean
     */
    public function get_brandlinks_status()
    {
        $this->db->select('brandlinks_status');
        $this->db->from('skearch_settings');

        $query = $this->db->get();

        return $query->row()->brandlinks_status;
    }

    /**
     * Get brandlinks
     *
     * @return object
     */
    public function get_brandlinks()
    {
        $this->db->select('keyword, url');
        $this->db->from('skearch_brands_brandlinks');
        $this->db->where('approved', 1);
        $this->db->where('active', 1);

        $query = $this->db->get();

        return $query->result();
    }
}
