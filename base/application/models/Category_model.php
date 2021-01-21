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
 * @copyright	Copyright (c) 2020
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
     * @param string $subcategory_id
     * @param string $order
     * @return object
     */
    public function get_adlinks($subcategory_id, $orderby)
    {
        if ($orderby == 'asc')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY title ASC");
        else if ($orderby == 'desc')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY title DESC");
        else if ($orderby == 'random')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY RAND()");
        else if ($orderby == 'priority')
            $query = $this->db->query("SELECT * FROM (
                SELECT 1 as Rank, title, description_short, display_url, priority, www FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id AND priority > 0
                UNION ALL
                SELECT 2 as Rank, title, description_short, display_url, priority, www FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id AND priority = 0
                ) AS mytable
                ORDER BY Rank, priority ASC");

        return $query->result();
    }

    /**
     * Get suggestions for the homepage
     * 
     * @return object|boolean
     */
    public function get_homepage_results()
    {
        $this->db->select("coalesce(nullif(home_display,''), title)");
        $this->db->from('skearch_categories');
        $this->db->where('skearch_categories.id = skearch_homepage_fields.result_id');
        $sub_query1 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title, null as umbrella", false);
        $this->db->from('skearch_homepage_fields');
        $this->db->where('is_result_umbrella', 1);
        $query1 = $this->db->get_compiled_select();

        $this->db->select("coalesce(nullif(skearch_subcategories.home_display,''), skearch_subcategories.title)");
        $this->db->from('skearch_subcategories');
        $this->db->where('skearch_subcategories.id = skearch_homepage_fields.result_id');
        $sub_query2 = $this->db->get_compiled_select();

        $this->db->select('skearch_categories.title as umbrella');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('skearch_subcategories.id = skearch_homepage_fields.result_id');
        $sub_query3 = $this->db->get_compiled_select();

        $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title, ($sub_query3) as umbrella");
        $this->db->from('skearch_homepage_fields');
        $this->db->where('is_result_umbrella', 0);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

        return $query->result();
    }

    /**
     * Get umbrella title
     * 
     * @param int $limit
     * @return object
     */
    public function get_category_title($umbrella_id)
    {

        $this->db->select('title');
        $this->db->from('skearch_categories');
        $this->db->where('id', $umbrella_id);
        $query = $this->db->get();

        return $query->result();
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

        return $query->result();
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
     * Return status
     *
     * @return void
     */
    public function get_brandlinks_status()
    {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_brandlinks_status');
        $query = $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0]->enabled;
    }

    /**
     * Return all brand keywords and url
     *
     * @return void
     */
    public function get_brands_keywords()
    {
        $this->db->select('keywords, url');
        $this->db->from('skearch_brands_keywords');
        $this->db->where('approved', 1);
        $this->db->where('active', 1);

        $query = $this->db->get();

        return $query->result();
    }
}
