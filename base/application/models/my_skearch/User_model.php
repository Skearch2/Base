<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Category_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package        Skearch
 * @author        Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018
 * @version        2.0
 */
class User_model extends CI_Model
{

    public function register($is_regular = 1)
    {

        if ($is_regular) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $additional_data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'gender' => $this->input->post('gender'),
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

            return $this->ion_auth->register($username, $password, $email, $additional_data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'brandname' => $this->input->post('brandname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone')
            );

            return $this->db->insert('skearch_brand_leads', $data);
        }
    }

    public function update_profile($user_id)
    {

        $group_name = $this->ion_auth->group($this->input->post('group'))->result();
        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'organization' => $this->input->post('organization'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'country' => $this->input->post('country'),
            'zip' => $this->input->post('zip'),
            'phone' => $this->input->post('phone'),
            'active' => $this->input->post('active'),
            'group' => $group_name,
            'gender' => $this->input->post('gender'),
            'age_group' => $this->input->post('age_group'),
        );

        $this->ion_auth->update($user_id, $data);
    }
}
