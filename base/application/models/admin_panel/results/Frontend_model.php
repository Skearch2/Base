<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/results/Frontend_model.php
 *
 * A model to manage results on homepage and suggestions on 
 * umbrellas and fields page
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Frontend_model extends CI_Model
{
  /**
   * Returns all featured umbrella and fields
   * 
   * @return object|false
   */
  public function get_featured_fields()
  {
    $this->db->select("id, title, 1 as is_umbrella");
    $this->db->from('skearch_categories');
    $this->db->where('enabled', 1);
    $this->db->where('featured', 1);
    $query1 = $this->db->get_compiled_select();

    $this->db->select("id, title, 0 as is_umbrella");
    $this->db->from('skearch_subcategories');
    $this->db->where('enabled', 1);
    $this->db->where('featured', 1);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY title");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  /**
   * Returns suggestions for a field
   *
   * @param int $field_id ID of the field
   * @return object|false
   */
  public function get_field_suggestions($field_id)
  {
    $this->db->select('title');
    $this->db->from('skearch_categories');
    $this->db->where('skearch_categories.id = skearch_fields_suggestions.result_id');
    $sub_query1 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title");
    $this->db->from('skearch_fields_suggestions');
    $this->db->where('field_id', $field_id);
    $this->db->where('is_result_umbrella', 1);
    $query1 = $this->db->get_compiled_select();

    $this->db->select('title');
    $this->db->from('skearch_subcategories');
    $this->db->where('skearch_subcategories.id = skearch_fields_suggestions.result_id');
    $sub_query2 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title");
    $this->db->from('skearch_fields_suggestions');
    $this->db->where('field_id', $field_id);
    $this->db->where('is_result_umbrella', 0);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  /**
   * Returns results for homepage
   *
   * @return object|false
   */
  public function get_homepage_fields()
  {
    $this->db->select('title');
    $this->db->from('skearch_categories');
    $this->db->where('skearch_categories.id = skearch_homepage_fields.result_id');
    $sub_query1 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title");
    $this->db->from('skearch_homepage_fields');
    $this->db->where('is_result_umbrella', 1);
    $query1 = $this->db->get_compiled_select();

    $this->db->select('title');
    $this->db->from('skearch_subcategories');
    $this->db->where('skearch_subcategories.id = skearch_homepage_fields.result_id');
    $sub_query2 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title");
    $this->db->from('skearch_homepage_fields');
    $this->db->where('is_result_umbrella', 0);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  /**
   * Returns all active umbrellas and fields
   * 
   * @return object|false
   */
  public function get_results()
  {
    $this->db->select("id, title, 1 as is_umbrella");
    $this->db->from('skearch_categories');
    $this->db->where('enabled', 1);
    $query1 = $this->db->get_compiled_select();

    $this->db->select("id, title, 0 as is_umbrella");
    $this->db->from('skearch_subcategories');
    $this->db->where('enabled', 1);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY title");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  /**
   * Rpdates suggestions for a umbrella
   *
   * @param int $field_id
   * @return object|false
   */
  public function get_umbrella_suggestions($umbrella_id)
  {
    $this->db->select('title');
    $this->db->from('skearch_categories');
    $this->db->where('skearch_categories.id = skearch_umbrella_suggestions.result_id');
    $sub_query1 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query1) as title");
    $this->db->from('skearch_umbrella_suggestions');
    $this->db->where('umbrella_id', $umbrella_id);
    $this->db->where('is_result_umbrella', 1);
    $query1 = $this->db->get_compiled_select();

    $this->db->select('title');
    $this->db->from('skearch_subcategories');
    $this->db->where('skearch_subcategories.id = skearch_umbrella_suggestions.result_id');
    $sub_query2 = $this->db->get_compiled_select();

    $this->db->select("id, result_id, is_result_umbrella, ($sub_query2) as title");
    $this->db->from('skearch_umbrella_suggestions');
    $this->db->where('umbrella_id', $umbrella_id);
    $this->db->where('is_result_umbrella', 0);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY id");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  /**
   * Updates suggestions for a field
   *
   * @param int $field_id ID of the field
   * @param array $suggestions Array of results for field
   * @return void
   */
  public function update_field_suggestions($field_id, $suggestions)
  {
    $this->db->where('field_id', $field_id);
    $this->db->delete('skearch_fields_suggestions');
    if (!empty($suggestions)) {
      $query = $this->db->insert_batch('skearch_fields_suggestions', $suggestions);
    } else {
      return FALSE;
    }


    if ($query) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Update results for homepage
   *
   * @param array $results Results for homepage
   * @return void
   */
  public function update_homepage_fields($results)
  {
    $this->db->empty_table('skearch_homepage_fields');
    if (!empty($results)) {
      $this->db->query('ALTER TABLE skearch_homepage_fields AUTO_INCREMENT = 1');
      $query = $this->db->insert_batch('skearch_homepage_fields', $results);
    } else {
      return FALSE;
    }

    if ($query) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Updates suggestions for an umbrella
   *
   * @param int $umbrella_id ID of the umbrella
   * @param array $suggestions Array of results for umbrella
   * @return void
   */
  public function update_umbrella_suggestions($umbrella_id, $suggestions)
  {
    $this->db->where('umbrella_id', $umbrella_id);
    $this->db->delete('skearch_umbrella_suggestions');
    if (!empty($suggestions)) {
      $query = $this->db->insert_batch('skearch_umbrella_suggestions', $suggestions);
    } else {
      return FALSE;
    }

    if ($query) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}
