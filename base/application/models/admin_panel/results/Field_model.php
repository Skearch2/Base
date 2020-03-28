<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/results/Field_model.php
 *
 * Model for Fields
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Field_model extends CI_Model
{
    /**
     * Creates a field
     *
     * @param array $data Array contains data for the umbrella
     * @return void
     */
    public function create($data)
    {
        // $data = array(
        //     'title'             => $data['title'],
        //     'description'       => $data['$description'],
        //     'description_short' => $data['$description_short'],
        //     'parent_id'         => $data['$parent_id'],
        //     'home_display'      => $data['$home_display'],
        //     'keywords'          => $data['$keywords'],
        //     'featured'          => $data['$featured'],
        //     'enabled'           => $data['$enabled']
        // );

        $query = $this->db->insert('skearch_subcategories', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete research link
     *
     * @param int $id An id of a research link
     * 
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('skearch_research_links');

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets a field
     *
     * @param int $id ID of the field
     * 
     * @return object|FALSE
     */
    public function get($id)
    {
        $this->db->select("*");
        $this->db->from('skearch_subcategories');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Gets umbrella of the field
     *
     * @param int $id ID of the field
     * 
     * @return object|FALSE
     */
    public function get_umbrella($id)
    {
        $this->db->select("*");
        $this->db->from('skearch_subcategories');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get fields based on status
     *
     * @param string active|inactive $status Status of the fields
     * 
     * @return object|FALSE
     */
    public function get_by_status($status = NULL)
    {
        $this->db->select('skearch_subcategories.id, skearch_subcategories.title, skearch_subcategories.enabled,
        skearch_subcategories.description_short, skearch_subcategories.featured, skearch_categories.title as umbrella');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id');
        if ($status == 'inactive') {
            $this->db->where('skearch_subcategories.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_subcategories.enabled', 1);
        }
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Get fields by umbrella
     *
     * @param int $umbrella_id ID of the umbrella
     * @param string $status Status of the fields
     * @return void
     */
    public function get_by_umbrella($umbrella_id, $status = NULL)
    {
        $this->db->select('skearch_subcategories.id, skearch_subcategories.title, skearch_subcategories.enabled,
        skearch_subcategories.description_short, skearch_subcategories.featured, skearch_categories.title as umbrella');
        $this->db->from('skearch_subcategories');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id');
        $this->db->where('skearch_subcategories.parent_id', $umbrella_id);
        if ($status == 'inactive') {
            $this->db->where('skearch_subcategories.enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('skearch_subcategories.enabled', 1);
        }
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }


    /**
     * Updates the field
     *
     * @param int $id
     * @param array $field_data Array contains data for the field
     * @return void
     */
    public function update($id, $field_data)
    {
        // if (array_key_exists('title', $field_data))                      $data['title']              = $field_data['title'];
        // if (array_key_exists('description', $field_data))                $data['description']        = $field_data['description'];
        // if (array_key_exists('description_short', $field_data))          $data['description_short']  = $field_data['description_short'];
        // if (array_key_exists('parent_id', $field_data))                  $data['parent_id']          = $field_data['parent_id'];
        // if (array_key_exists('home_display', $field_data))               $data['home_display']       = $field_data['home_display'];
        // if (array_key_exists('keywords', $field_data))                   $data['keywords']           = $field_data['keywords'];
        // if (array_key_exists('featured', $field_data))                   $data['featured']           = $field_data['featured'];
        // if (array_key_exists('enabled', $field_data))                    $data['enabled']            = $field_data['enabled'];

        $this->db->where('id', $id);
        $query = $this->db->update('skearch_subcategories', $field_data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
