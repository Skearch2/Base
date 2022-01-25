<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/Field_History_model.php
 *
 * Model for User's top 10 most visited field history
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Fields_History_model extends CI_Model
{

    /**
     * Create field history
     *
     * @param array $user_data Contains user id and field id
     * @return boolean
     */
    public function create($user_data)
    {
        $this->db->select('id');
        $this->db->from('skearch_users_fields_history');
        $this->db->where('user_id', $user_data['user_id']);

        $query = $this->db->get();

        if ($query->num_rows() >= 10) {
            $this->db->where('user_id', $user_data['user_id']);
            $this->db->order_by("timestamp", "asc");
            $this->db->limit(1);
            $this->db->delete('skearch_users_fields_history');
        }

        $data = array(
            'user_id' => $user_data['user_id'],
            'field_id' => $user_data['field_id'],
            'recurrence' => 1,
            'timestamp' => date("Y-m-d H:i:s")
        );

        $this->db->insert('skearch_users_fields_history', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete all fields history
     *
     * @param array $id ID of the user
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('user_id', $id);

        $this->db->delete('skearch_users_fields_history');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if a field is already in the history
     *
     * @param array $user_data Contains user id and field id
     * @return boolean
     */
    public function exists($user_data)
    {
        $this->db->select('*');
        $this->db->from('skearch_users_fields_history');
        $this->db->where('user_id', $user_data['user_id']);
        $this->db->where('field_id', $user_data['field_id']);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get most visited fields history
     * +
     *
     * @param int $user_id ID of the user
     * @return object|false
     */
    public function get($user_id)
    {
        $this->db->select('skearch_categories.title as umbrella, skearch_subcategories.title, timestamp, recurrence');
        $this->db->from('skearch_users_fields_history');
        $this->db->join('skearch_subcategories', 'skearch_users_fields_history.field_id = skearch_subcategories.id', 'left');
        $this->db->join('skearch_categories', 'skearch_subcategories.parent_id = skearch_categories.id', 'left');
        $this->db->where('user_id', $user_id);
        $this->db->order_by("timestamp", "desc");

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Update field recurrence
     *
     * @param array $user_data Contains user id and field id
     * @return boolean
     */
    public function update($user_data)
    {
        $this->db->where('user_id', $user_data['user_id']);
        $this->db->where('field_id', $user_data['field_id']);
        $this->db->set('recurrence', 'recurrence + 1', FAlSE);
        $this->db->set('timestamp', date("Y-m-d H:i:s"));

        $this->db->update('skearch_users_fields_history');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
