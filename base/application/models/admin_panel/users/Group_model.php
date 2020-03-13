<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/users/Group_model.php
 *
 * User group model
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Group_model extends CI_Model
{
    /**
     * Creates group
     *
     * @return int|boolean
     */
    public function create()
    {
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $query = $this->ion_auth->create_group($name, $description);

        return $query;
    }

    /**
     * Deletes group
     *
     * @param int $id ID of the group
     * @return boolean
     */
    public function delete($id)
    {
        $query = $this->ion_auth->delete_group($id);

        return $query;
    }

    /**
     * Get group or all groups
     *
     * @param int $id ID of the group
     * @return object
     */
    public function get($id = NULL)
    {
        if ($id) {
            return $this->ion_auth->group($id)->row();
        } else {
            return $this->ion_auth->groups()->result();
        }
    }

    /**
     * Updates group
     *
     * @param int $id ID of the group
     * @return boolean
     */
    public function update($id)
    {
        $name = $this->input->post('name');
        $additional_data = array(
            'description' => $this->input->post('description')
        );

        $query = $this->ion_auth->update_group($id, $name, $additional_data);

        return $query;
    }
}
