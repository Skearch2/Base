<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/User_model.php
 *
 * User model for MySkearch
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class User_model extends CI_Model
{

    /**
     * Creates user
     *
     * @param string $username Username
     * @param string $password Random generated password
     * @param string $email User email
     * @param array $additional_data Additional user data
     * @param int $group User group
     * @return int|false User ID or false
     */
    public function create($username, $password, $email, $additional_data, $group)
    {
        // whether the user registering account themself
        $self_registration = 1;

        $query = $this->ion_auth->register($self_registration, $username, $password, $email, $additional_data, $group);

        return $query;
    }

    /**
     * Create a brand lead
     *
     * @param array $data Brand lead data
     * @return boolean
     */
    public function create_lead($data)
    {
        $this->db->insert('skearch_brand_leads', $data);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /**
     * Get brand details if a user is linked with a brand
     *
     * @param int $id ID of the user
     * @return object|false
     */
    public function get_brand_details($id)
    {
        $this->db->select('brand_id, primary_brand_user');
        $this->db->from('skearch_users_brands');
        $this->db->where('user_id', $id);

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get user  personalized settings
     *
     * @param int $id ID of the user
     * @return object|false
     */
    public function get_settings($id)
    {
        $this->db->select('theme, search_engine');
        $this->db->from('skearch_users_settings');
        $this->db->where('user_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * Update user
     *
     * @param int $id ID of the user
     * @param array $data User data
     * @return object
     */
    public function update($id, $data)
    {
        $query = $this->ion_auth->update($id, $data);

        return $query;
    }

    /**
     * Update user personalized settings
     *
     * @param int $id ID of the user
     * @param array $data User settings
     * @return boolean
     */
    public function update_settings($id, $data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('skearch_users_settings', $data);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Unsubscribe email from marketing list
     *
     * @param string $email User email
     * @return boolean
     */
    public function unsubsribe_user_email($email)
    {
        $this->db->set('is_subscribed', 0);
        $this->db->where('email', $email);
        $this->db->update('marketing_emails');

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
