<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/users/User_model.php
 *
 * User model
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
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
        $self_registration = 0;

        $query = $this->ion_auth->register($self_registration, $username, $password, $email, $additional_data, $group);

        return $query;
    }

    /**
     * Deletes user
     *
     * @param int $id ID of the user
     * @return void
     */
    public function delete($id)
    {
        $query = $this->ion_auth->delete_user($id);

        return $query;
    }

    /**
     * Gets a user or all users
     *
     * @param int $id ID of the user
     * @param boolean $is_group Whether the id given is a user group id
     * @return object
     */
    public function get($id, $is_group = FALSE)
    {
        if ($is_group) {
            // return all users from the group
            if ($id == 1 or $id == 2) {
                return $this->ion_auth->users(array(1, 2))->result();
            } else {
                return $this->ion_auth->users($id)->result();
            }
        } else {
            // return user
            return $this->ion_auth->user($id)->row();
        }
    }

    /**
     * Get users by lastname
     *
     * @param String $lastname Last name of the user
     * @return object
     */
    public function get_by_lastname($lastname)
    {
        $this->db->select('id, lastname, firstname, email');
        $this->db->from('skearch_users');
        $this->db->where('active', 1);
        $this->db->like('lastname', $lastname, 'after');
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get all active users from brands, premium, and registered group
     *
     * @return object
     */
    public function get_active_users()
    {
        $this->db->select('id, email');
        $this->db->from('skearch_users');
        $this->db->join('skearch_users_groups', 'skearch_users_groups.user_id = skearch_users.id', 'left');
        $this->db->join('skearch_groups', 'skearch_groups.id = skearch_users_groups.group_id', 'left');
        $this->db->where_in('skearch_groups.id', array(3, 4, 5));
        $this->db->where('skearch_users.active', 1);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Updates user data
     *
     * @param int $id ID of the user
     * @param array $user_data User data
     * @return boolean
     */
    public function update($id, $data)
    {
        if (array_key_exists('group', $data)) {
            $group_id = $data['group'];
            // remove user from all groups
            $this->ion_auth->remove_from_group(NULL, $id);
            // add user to the group
            $this->ion_auth->add_to_group($group_id, $id);
        }

        $query = $this->ion_auth->update($id, $data);

        return $query;
    }
}
