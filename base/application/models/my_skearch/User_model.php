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

    public function register($is_brandmember = NULL)
    {

        $username = $this->input->post('myskearch_id');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $group_name = "members";
        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'gender' => $this->input->post('gender'),
            'age_group' => $this->input->post('age_group'),
            'group_name' => $group_name,
        );
        if ($is_brandmember == 1) {
            array_push($additional_data, array(
                'organization' => $this->input->post('organization'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'zip' => $this->input->post('zip')
            ));
            $group = array('3'); // brand member group
        } else {
            $group = array('5'); // regular member group
        }

        return $this->ion_auth->register($username, $password, $email, $additional_data, $group);
    }

    public function update_profile($user_id)
    {

        $group_name = $this->ion_auth->group($this->input->post('group'))->result();
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
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
