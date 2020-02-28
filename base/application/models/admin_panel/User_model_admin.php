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
class User_model_admin extends CI_Model
{

    public function get_user($id)
    {
        return $this->ion_auth->user($id)->row();
    }

    public function get_user_list($group)
    {
        return $this->ion_auth->Users($group)->result();
    }

    public function get_users_by_lastname($last_name)
    {
        $this->db->select('last_name, first_name, username, email');
        $this->db->from('skearch_users');
        $this->db->like('last_name', $last_name, 'after');
        $this->db->order_by('last_name', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function create_user()
    {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $group_name = $this->ion_auth->group($this->input->post('group'))->row()->name;
        $additional_data = array(
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
            'gender' => $this->input->post('gender'),
            'age_group' => $this->input->post('age_group'),
            'group_name' => $group_name,
        );
        $group = array($this->input->post('group'));
        $this->ion_auth->register($username, $password, $email, $additional_data, $group);
    }

    public function update_user($user_id)
    {

        $group_id = $this->input->post('group');
        $group_name = $this->ion_auth->group($this->input->post('group'))->result();
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
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

        $this->ion_auth->remove_from_group(NULL, $user_id);
        $this->ion_auth->add_to_group($group_id, $user_id);

        $this->ion_auth->update($user_id, $data);
    }

    public function delete_user($user_id)
    {
        $this->ion_auth->delete_user($user_id);
    }

    public function toggle_user_activation($id, $status)
    {

        $this->db->set('active', $status);
        $this->db->where('id', $id);
        $this->db->update('skearch_users');
    }

    public function get_user_group($user_id)
    {
        return $this->ion_auth->get_users_groups($user_id)->row();
    }

    public function get_group($group_id)
    {
        return $this->ion_auth->group($group_id)->row();
    }

    public function get_user_groups()
    {
        return $this->ion_auth->groups()->result();
    }

    public function create_user_group()
    {

        $groupname = $this->input->post('groupname');
        $description = $this->input->post('description');

        $group = $this->ion_auth->create_group($groupname, $description);

        return $group;
    }

    public function update_user_group($group_id)
    {

        $group_name = $this->input->post('groupname');
        $additional_data = array(
            'description' => $this->input->post('description')
        );

        $group_update = $this->ion_auth->update_group($group_id, $group_name, $additional_data);

        return $group_update;
    }

    public function delete_user_group($group_id)
    {

        $group_delete = $this->ion_auth->delete_group($group_id);

        return $group_delete;
    }
}
