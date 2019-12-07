<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/Category_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2018
 * @version		2.0
 */
class Category_model extends CI_Model {

    /**
     * Returns category ID
     * @param string $category_name
     * @return int
     */
    public function get_category_id($category_name) {

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
    public function get_subcategory_id($subcategory_name) {

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
    public function get_categories($limit = NULL, $order = 'ASC', $columns = '*') {

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
    public function get_subcategories($category_id = NULL, $limit = NULL, $order = 'ASC', $columns = '*') {

        $query = $this->db->select($columns);
        $query = $this->db->from('skearch_subcategories');
        if($category_id != NULL) {
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
     * @param string $subcategory_id
     * @param string $order
     * @return object
     */
    public function get_adlinks($subcategory_id, $orderby) {

        if($orderby == 'asc')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY title ASC");
        else if($orderby == 'desc')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY title DESC");
        else if($orderby == 'random')
            $query = $this->db->query("SELECT * FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id
            ORDER BY RAND()");
        else if($orderby == 'priority')
            $query = $this->db->query("SELECT * FROM (
                SELECT 1 as Rank, title, description_short, display_url, priority, www FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id AND priority > 0
                UNION ALL
                SELECT 2 as Rank, title, description_short, display_url, priority, www FROM skearch_listings WHERE enabled = 1 AND sub_id = $subcategory_id AND priority = 0
                ) AS mytable
                ORDER BY Rank, priority ASC");

    return $query->result();
    }

    /* Return homepage fields */
    public function get_homepage_fields() {
        $query = $this->db->query("SELECT * FROM (
            (SELECT skearch_homepage_fields.id AS id, skearch_categories.title, null AS parent_title FROM skearch_categories
            INNER JOIN skearch_homepage_fields
            ON skearch_categories.id = skearch_homepage_fields.field_id AND skearch_categories.title = skearch_homepage_fields.title)
            UNION
            (SELECT skearch_homepage_fields.id AS id, skearch_subcategories.title, (SELECT title FROM skearch_categories WHERE skearch_categories.id = skearch_subcategories.parent_id) FROM skearch_subcategories
            INNER JOIN skearch_homepage_fields
            ON skearch_subcategories.id = skearch_homepage_fields.field_id AND skearch_subcategories.title = skearch_homepage_fields.title)
            UNION
            (SELECT skearch_homepage_fields.id AS id, skearch_homepage_fields.title, null AS parent_title FROM skearch_homepage_fields
            WHERE skearch_homepage_fields.title = 'empty' )
            )
            AS mytable
            ORDER BY id");
        return $query->result();

    }

    /**
     * Returns number of categories based on defined limit
     * @param int $limit
     * @return object
     */
    public function get_category_title($id) {

        $query = $this->db->select('title');
        $query = $this->db->from('skearch_categories');
        $query = $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * Returns ad results that are enabled and has active redirection
     */

    public function get_results() {

        $query = $this->db->select('display_url, www');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->where('redirect', 1);
        $query = $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();

    }

    /**
 * Updates fields suggestions
 *
 * @param [type] $field_id
 * @param [type] $suggest_array
 * @return void
 */
public function get_field_suggestions($field_id) {
    $this->db->select('*');
    $this->db->from('skearch_fields_suggestions');
    $this->db->where('field_id', $field_id);
    $query = $this->db->get();
    if($query->num_rows() > 0) return $query->result();
    else return false;
  }
  
  /**
   * Updates umbrella suggestions
   *
   * @param [type] $field_id
   * @param [type] $suggest_array
   * @return void
   */
  public function get_umbrella_suggestions($umbrella_id) {
    $this->db->select('*');
    $this->db->from('skearch_umbrella_suggestions');
    $this->db->where('umbrella_id', $umbrella_id);
    $query = $this->db->get();
    if($query->num_rows() > 0) return $query->result();
    else return false;
  }
  
  /**
     * Return status
     *
     * @return void
     */
    public function get_brandlinks_status() {
        $query = $this->db->select('*');
        $query = $this->db->from('skearch_brandlinks_status');
        $query = $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0]->enabled;
    }




}
