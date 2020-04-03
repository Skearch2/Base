<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

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
class Category_model_admin extends CI_Model
{

  /**
   * Returns number of categories based on defined limit
   * @param int $limit
   * @return object
   */
  public function get_categories($limit = NULL, $order = 'ASC', $status = NULL)
  {

    $this->db->select("*");
    $this->db->from('skearch_categories');
    $this->db->limit($limit);
    if ($status == 'inactive') {
      $this->db->where('enabled', 0);
    } elseif ($status == 'active') {
      $this->db->where('enabled', 1);
    }
    $this->db->order_by("title", $order);
    $query = $this->db->get();
    if ($query) return $query->result();
    else return false;
  }

  /**
   * Returns total number of umbrellas or active umbrellas
   * @param int $active
   * @return integer
   */
  public function count_umbrellas($active = 0)
  {

    $this->db->select('id');
    $this->db->from('skearch_categories');
    if ($active === 1) {
      $this->db->where('enabled', 1);
    }
    return $this->db->count_all_results();
  }

  /**
   * Returns total number of fields or active fields
   * @param int $active
   * @return integer
   */
  public function count_fields($active = 0)
  {

    $this->db->select('id');
    $this->db->from('skearch_subcategories');
    if ($active === 1) {
      $this->db->where('enabled', 1);
    }
    return $this->db->count_all_results();
  }

  /**
   * Returns total number of results or active results
   * @param int $active
   * @return integer
   */
  public function count_results($active = 0)
  {

    $this->db->select('id');
    $this->db->from('skearch_listings');
    if ($active === 1) {
      $this->db->where('enabled', 1);
    }
    return $this->db->count_all_results();
  }

  /**
   * Returns subcategories of a category if category id is defined
   * otherwise return all the subcategories in the database
   * Limit can be used to get defined number of subcategories
   * @param string $subcategory_name
   * @param int $limit, $categoryid
   * @return object
   */
  public function get_subcategories($categoryid = NULL, $limit = NULL, $order = 'ASC', $status = NULL)
  {
    $query = $this->db->select('skearch_subcategories.id, skearch_subcategories.title, skearch_subcategories.enabled,
      skearch_subcategories.description_short, skearch_subcategories.featured, skearch_categories.title as parent_title');
    $query = $this->db->from('skearch_subcategories');
    // $query = $this->db->join('skearch_subcategory_to_category','skearch_subcategory_to_category.sub_id = skearch_subcategories.id');
    $query = $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
    if ($categoryid != NULL && is_numeric($categoryid)) {
      // $query = $this->db->where('skearch_subcategory_to_category.cat_id', $categoryid);
      $query = $this->db->where('skearch_subcategories.parent_id', $categoryid);
    }
    if ($status == 'inactive') {
      $this->db->where('skearch_subcategories.enabled', 0);
    } elseif ($status == 'active') {
      $this->db->where('skearch_subcategories.enabled', 1);
    }
    $query = $this->db->limit($limit);
    $query = $this->db->order_by('title', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

  public function get_result_listing($subcategoryid = NULL, $limit = NULL, $order = 'ASC', $status = NULL)
  {

    $query = $this->db->select('skearch_subcategories.title AS stitle, skearch_listings.title, skearch_listings.id, skearch_listings.description_short,
      skearch_listings.enabled, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect ');
    $query = $this->db->from('skearch_listings');
    $query = $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id', 'left');
    $query = $this->db->limit($limit);
    if ($subcategoryid != NULL && is_numeric($subcategoryid)) {
      $query = $this->db->where('skearch_subcategories.id', $subcategoryid);
    }
    if ($status == 'inactive') {
      $this->db->where('skearch_listings.enabled', 0);
    } elseif ($status == 'active') {
      $this->db->where('skearch_listings.enabled', 1);
    }
    $query = $this->db->get();
    return $query->result();
  }

  /**
   * Get the parent of the field
   *
   * @param [type] $id
   * @return void
   */
  public function get_field_parent($fieldId)
  {
    $query = $this->db->select('parent_id');
    $query = $this->db->from('skearch_subcategories');
    $query = $this->db->where('id', $fieldId);
    $query = $this->db->get();
    return $query->result()[0]->parent_id;
  }

  public function get_result_parent($id)
  {
    $query = $this->db->select('skearch_subcategories.id');
    $query = $this->db->from('skearch_listings');
    $query = $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
    $query = $this->db->where('skearch_listings.id', $id);
    $query = $this->db->get();
    return $query->result()[0]->id;
  }

  public function get_links_priority($id)
  {
    $query = $this->db->select('title, priority');
    $query = $this->db->from('skearch_listings');
    $query = $this->db->where('sub_id', $id);
    $query = $this->db->order_by('priority', 'AESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_single_category($id)
  {
    $query = $this->db->select('*');
    $query = $this->db->from('skearch_categories');
    $query = $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_single_subcategory($id)
  {
    $query = $this->db->select('*');
    $query = $this->db->from('skearch_subcategories');
    $query = $this->db->where('id', $id);
    $query = $this->db->get();

    // $query2 = $this->db->select('cat_id');
    // $query2 = $this->db->from('skearch_subcategory_to_category');
    // $query2 = $this->db->where('sub_id', $id);
    // $query2 = $this->db->get();

    // return array('data' => $query->result(), 'parent' => $query2->result());
    return $query->result();
  }

  public function get_single_result($id)
  {
    $query = $this->db->select('*');
    $query = $this->db->from('skearch_listings');
    $query = $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->result();
  }

  public function search_adlink($title)
  {
    if ($title == NULL) return;
    $query = $this->db->select('skearch_subcategories.title AS stitle, skearch_listings.title, skearch_listings.id, skearch_listings.description_short,
      skearch_listings.enabled, skearch_listings.display_url, skearch_listings.priority, skearch_listings.redirect ');
    $query = $this->db->from('skearch_listings');
    $query = $this->db->join('skearch_subcategories', 'skearch_subcategories.id = skearch_listings.sub_id');
    $query = $this->db->like('skearch_listings.title', $title, 'after');
    $query = $this->db->get();
    return $query->result();
  }

  // public function create_category(
  //   $title,
  //   $enabled,
  //   $umbrella_name,
  //   $home_display,
  //   $description_short,
  //   $description,
  //   $keywords,
  //   $featured
  // ) {
  //   $data = array(
  //     'title' => $title,
  //     'enabled' => $enabled,
  //     'umbrella_name' => $umbrella_name,
  //     'home_display' => $home_display,
  //     'description_short' => $description_short,
  //     'description' => $description,
  //     'keywords' => $keywords,
  //     'featured' => $featured
  //   );
  //   $this->db->insert('skearch_categories', $data);
  // }

  public function create_subcategory(
    $title,
    $enabled,
    $home_display,
    $description_short,
    $description,
    $keywords,
    $featured,
    $parent_id
  ) {
    $data = array(
      'title' => $title,
      'enabled' => $enabled,
      'home_display' => $home_display,
      'description_short' => $description_short,
      'description' => $description,
      'keywords' => $keywords,
      'featured' => $featured,
      'parent_id' => $parent_id
    );
    $this->db->insert('skearch_subcategories', $data);

    //   $sub_id = $this->db->insert_id();

    //   foreach ($parent_id as $cat_id) {
    //     $this->db->insert('skearch_subcategory_to_category', array('sub_id' => $sub_id, 'cat_id' => $cat_id,));
    //   }
  }

  public function create_result_listing($title, $enabled, $description_short, $display_url, $www, $sub_id, $priority, $redirect)
  {
    $data = array(
      'title' => $title,
      'enabled' => $enabled,
      'display_url' => $display_url,
      'description_short' => $description_short,
      'www' => $www,
      'sub_id' => $sub_id,
      'priority' => $priority,
      'redirect' => $redirect
    );

    $query = $this->db->insert('skearch_listings', $data);

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function update_category(
    $id,
    $title,
    $enabled,
    $umbrella_name,
    $home_display,
    $description_short,
    $description,
    $keywords,
    $featured
  ) {
    $data = array(
      'title' => $title,
      'enabled' => $enabled,
      'umbrella_name' => $umbrella_name,
      'home_display' => $home_display,
      'description_short' => $description_short,
      'description' => $description,
      'keywords' => $keywords,
      'featured' => $featured
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_categories', $data);
  }

  public function update_subcategory(
    $id,
    $title,
    $enabled,
    $home_display,
    $description_short,
    $description,
    $keywords,
    $featured,
    $parent_id
  ) {
    $data = array(
      'title' => $title,
      'enabled' => $enabled,
      'home_display' => $home_display,
      'description_short' => $description_short,
      'description' => $description,
      'keywords' => $keywords,
      'featured' => $featured,
      'parent_id' => $parent_id
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_subcategories', $data);

    //   $this->db->delete('skearch_subcategory_to_category', array('sub_id' => $id));

    //   foreach ($parent_id as $cat_id) {
    //     $this->db->insert('skearch_subcategory_to_category', array('sub_id' => $id, 'cat_id' => $cat_id,));
    //   }
  }

  public function update_result_listing($id, $title, $enabled, $description_short, $display_url, $www, $sub_id, $priority, $redirect)
  {
    $data = array(
      'title' => $title,
      'enabled' => $enabled,
      'display_url' => $display_url,
      'description_short' => $description_short,
      'www' => $www,
      'sub_id' => $sub_id,
      'priority' => $priority,
      'redirect' => $redirect
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_listings', $data);
  }

  public function delete_category($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('skearch_categories');

    // Delete from homepage fields table as well
    $this->db->where('field_id', $id);
    $this->db->delete('skearch_homepage_fields');

    // Delete from field suggestion table as well
    $this->db->where('umbrella_id', $id);
    $this->db->delete('skearch_umbrella_suggestions');
  }

  public function delete_subcategory($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('skearch_subcategories');

    // Delete from homepage fields table as well
    $this->db->where('field_id', $id);
    $this->db->delete('skearch_homepage_fields');

    // Delete from field suggestion table as well
    $this->db->where('field_id', $id);
    $this->db->delete('skearch_fields_suggestions');
  }

  public function delete_result_listing($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('skearch_listings');
  }

  public function toggle_category($id, $status)
  {
    $data = array(
      'enabled' => $status,
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_categories', $data);
  }

  public function toggle_subcategory($id, $status)
  {
    $data = array(
      'enabled' => $status,
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_subcategories', $data);
  }

  public function toggle_result($id, $status)
  {
    $data = array(
      'enabled' => $status,
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_listings', $data);
  }

  public function toggle_redirect($id, $status)
  {
    $data = array(
      'redirect' => $status,
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_listings', $data);
  }

  public function change_priority($id, $priority)
  {
    $data = array(
      'priority' => $priority,
    );
    $this->db->where('id', $id);
    $this->db->update('skearch_listings', $data);
  }




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
   * Update results for homepage
   *
   * @param array $results Results for homepage
   * @return void
   */
  public function update_homepage_fields($results)
  {
    $this->db->empty_table('skearch_homepage_fields');
    if (!empty($data)) {
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
}
