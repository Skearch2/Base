<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/my_skearch/User_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class User_model extends CI_Model
{

    /**
     * Create user
     *
     * @param int $is_regular Is a user signing up as regular member
     * @return void
     */
    public function create($is_regular = 1)
    {

        if ($is_regular) {
            $username = $this->input->post('skearch_id');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $additional_data = array(
                'gender'    => $this->input->post('gender'),
                'age_group' => $this->input->post('age_group')
            );
            // $additional_data['organization'] = $this->input->post('organization');
            // $additional_data['brand'] = $this->input->post('brand');
            // $additional_data['phone'] = $this->input->post('phone');
            // $additional_data['address1'] = $this->input->post('address1');
            // $additional_data['address2'] = $this->input->post('address2');
            // $additional_data['city'] = $this->input->post('city');
            // $additional_data['state'] = $this->input->post('state');
            // $additional_data['country'] = $this->input->post('country');
            // $additional_data['zipcode'] = $this->input->post('zipcode');

            // $group = array('5'); // regular member group
            $query = $this->ion_auth->register($username, $password, $email, $additional_data);
            
            return $query;

        } else {
            $data = array(
                'name'      => $this->input->post('name'),
                'brandname' => $this->input->post('brandname'),
                'email'     => $this->input->post('email_b'),
                'phone'     => preg_replace("/[^0-9]/", "", $this->input->post('phone'))
            );

            $query = $this->db->insert('skearch_brand_leads', $data);
            
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    /**
     * Get brand details for the user
     * Contails brand id for and boolean to if the user is primary brand member
     *
     * @param int $id ID of the user
     * @return void
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
     * Get user customized settings
     *
     * @param int $id ID of the user
     * @return void
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
     * @return void
     */
    public function update($id)
    {
        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'organization' => $this->input->post('organization'),
            'brand' => $this->input->post('brand'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'country' => $this->input->post('country'),
            'zip' => $this->input->post('zip'),
            'phone' => $this->input->post('phone'),
            'active' => $this->input->post('active'),
            'gender' => $this->input->post('gender'),
            'age_group' => $this->input->post('age_group')
        );

        $query = $this->ion_auth->update($id, $data);

        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }

    /**
     * Update user personalized settings
     *
     * @param int $id ID of the user
     * @param int $user_data Contains user settings
     * @return void
     */
    public function update_settings($id, $user_data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('skearch_users_settings', $user_data);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
