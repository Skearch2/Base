<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/results/Umbrella_model.php
 *
 * Model for Umbrella
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Umbrella_model extends CI_Model
{
    /**
     * Creates an umbrella
     *
     * @param array $data Array contains data for the umbrella
     * 
     * @return void
     */
    public function create($umbrella_data)
    {
        // $data = array(
        //     'title'             => $data['title'],
        //     'description'       => $data['description'],
        //     'description_short' => $data['description_short'],
        //     'umbrella_name'     => $data['umbrella_name'],
        //     'home_display'      => $data['home_display'],
        //     'keywords'          => $data['keywords'],
        //     'featured'          => $data['featured'],
        //     'enabled'           => $data['enabled']
        // );

        $this->db->insert('skearch_categories', $umbrella_data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Deletes an umbrella
     *
     * @param int $id An id of the umbrella
     * 
     * @return void
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('skearch_categories');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check for duplicate umbrella or field title 
     *
     * @param string $string String
     * @return boolean
     */
    public function duplicate_check($string)
    {
        $this->db->select('title');
        $this->db->from('skearch_categories');
        $this->db->where('title', $string);

        $query1 = $this->db->get_compiled_select();

        $this->db->select('title');
        $this->db->from('skearch_subcategories');
        $this->db->where('title', $string);

        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2);

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get an umbrella
     *
     * @param int $id An id of an umbrella
     * 
     * @return object|false
     */
    public function get($id)
    {
        $this->db->select("*");
        $this->db->from('skearch_categories');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get umbrellas based on status
     *
     * @param string active|inactive $status Status of the umbrellas
     * 
     * @return object|false
     */
    public function get_by_status($status = NULL)
    {
        $this->db->select("*");
        $this->db->from('skearch_categories');
        if ($status == 'inactive') {
            $this->db->where('enabled', 0);
        } elseif ($status == 'active') {
            $this->db->where('enabled', 1);
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
     * Updates an umbrella
     *
     * @param int $id
     * @param array $umbrella_data Array contains data for the umbrella
     * @return void
     */
    public function update($id, $umbrella_data)
    {
        // if (array_key_exists('title', $umbrella_data))                      $data['title']              = $umbrella_data['title'];
        // if (array_key_exists('description', $umbrella_data))                $data['description']        = $umbrella_data['description'];
        // if (array_key_exists('description_short', $umbrella_data))          $data['description_short']  = $umbrella_data['description_short'];
        // if (array_key_exists('umbrella_name', $umbrella_data))              $data['umbrella_name']      = $umbrella_data['umbrella_name'];
        // if (array_key_exists('home_display', $umbrella_data))               $data['home_display']       = $umbrella_data['home_display'];
        // if (array_key_exists('keywords', $umbrella_data))                   $data['keywords']           = $umbrella_data['keywords'];
        // if (array_key_exists('featured', $umbrella_data))                   $data['featured']           = $umbrella_data['featured'];
        // if (array_key_exists('enabled', $umbrella_data))                    $data['enabled']            = $umbrella_data['enabled'];

        $this->db->where('id', $id);
        $this->db->update('skearch_categories', $umbrella_data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
