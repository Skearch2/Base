<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/admin_model/Dashboard.php
 *
 * The model for admin dashboard widgets
 * 
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2020
 * @version		2.0
 */
class Dashboard_model extends CI_Model
{

  /**
   * Returns the statistics of results which includes
   * Umbrellas, Fields, and Links
   * 
   * @return object
   */
  public function get_brands_stats()
  {
    $this->db->select('links.id');
    $this->db->from('skearch_listings as links');
    $this->db->join('skearch_subcategories as fields', 'fields.id = links.sub_id', 'left');
    $this->db->join('skearch_categories as umbrellas', 'umbrellas.id = fields.parent_id', 'left');
    $this->db->where('umbrellas.enabled', 1);
    $this->db->where('fields.enabled', 1);
    $this->db->where('links.enabled', 1);
    $this->db->where('links.redirect', 0);
    $results['total_brandlinks_inactive'] = $this->db->count_all_results();

    // get total links whose field and umbrella is active
    $this->db->select('links.id');
    $this->db->from('skearch_listings as links');
    $this->db->join('skearch_subcategories as fields', 'fields.id = links.sub_id', 'left');
    $this->db->join('skearch_categories as umbrellas', 'umbrellas.id = fields.parent_id', 'left');
    $this->db->where('umbrellas.enabled', 1);
    $this->db->where('fields.enabled', 1);
    $this->db->where('links.enabled', 1);
    $this->db->where('links.redirect', 1);
    $results['total_brandlinks_active'] = $this->db->count_all_results();

    return (object) ($results);
  }

  /**
   * Returns the statistics of results which includes
   * Umbrellas, Fields, and Links
   * 
   * @return object
   */
  public function get_results_stats()
  {
    $this->db->select('id');
    $this->db->from('skearch_categories');
    $results['total_umbrellas'] = $this->db->count_all_results();

    $this->db->select('id');
    $this->db->from('skearch_categories');
    $this->db->where('enabled', 1);
    $results['total_umbrellas_active'] = $this->db->count_all_results();

    $this->db->select('id');
    $this->db->from('skearch_subcategories');
    $results['total_fields'] = $this->db->count_all_results();

    $this->db->select('id');
    $this->db->from('skearch_subcategories');
    $this->db->where('enabled', 1);
    $results['total_fields_active'] = $this->db->count_all_results();

    $this->db->select('id');
    $this->db->from('skearch_listings');
    $results['total_links'] = $this->db->count_all_results();

    $this->db->select('id');
    $this->db->from('skearch_listings');
    $this->db->where('enabled', 1);
    $results['total_links_active'] = $this->db->count_all_results();

    // get total links whose field and umbrella is active
    $this->db->select('links.id');
    $this->db->from('skearch_listings as links');
    $this->db->join('skearch_subcategories as fields', 'fields.id = links.sub_id', 'left');
    $this->db->join('skearch_categories as umbrellas', 'umbrellas.id = fields.parent_id', 'left');
    $this->db->where('umbrellas.enabled', 1);
    $this->db->where('fields.enabled', 1);
    $this->db->where('links.enabled', 1);
    $results['total_links_live'] = $this->db->count_all_results();

    return (object) ($results);
  }

  /**
   * Returns statistics for research links
   * 
   * @return object
   */
  public function get_research_stats()
  {
    // total numbers of research links
    $this->db->select('id');
    $this->db->from('skearch_research_links');
    $results['total_research_links'] = $this->db->count_all_results();

    // total number of fields assigned to research links
    $this->db->select('field_id');
    $this->db->group_by('field_id');
    $this->db->from('skearch_research_links');
    $results['total_research_links_fields'] = $this->db->count_all_results();

    return (object) ($results);
  }
}
