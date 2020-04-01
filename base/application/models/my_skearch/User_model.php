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
                'firstname' => $this->input->post('name'),
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
            if ($query) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $data = array(
                'name'      => $this->input->post('name'),
                'brandname' => $this->input->post('brandname'),
                'email'     => $this->input->post('email'),
                'phone'     => $this->input->post('phone')
            );

            $query = $this->db->insert('skearch_brand_leads', $data);
            if ($query) {
                return $query;
            } else {
                return FALSE;
            }
        }
    }

    /**
     * Get user customized settings
     *
     * @param int $id ID of the user
     * @return void
     */
    public function get_settings($id, $columns = '*')
    {
        $this->db->select($columns);
        $this->db->from('skearch_users_settings');
        $this->db->where('user_id', $id);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
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
     * Update customized settings for user
     *
     * @param int $id ID of the user
     * @param int $search_engine Search engine for Skearch frontend
     * @param int $theme Skearch frontend theme
     * @return void
     */
    public function update_settings($id, $search_engine, $theme)
    {

        if (!is_null($search_engine))            $data['search_engine']          = $search_engine;
        if (!is_null($theme))                    $data['theme']                  = $theme;

        // check if POST data is null
        if (!isset($data)) {
            return FALSE;
        }

        $this->db->where('user_id', $id);
        $query = $this->db->update('skearch_users_settings', $data);

        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }
}
