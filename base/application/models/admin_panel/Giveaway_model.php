<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/Giveaway_model.php
 *
 * Model for Give away
 * Create, edit, delete, and manage give aways
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */
class Giveaway_model extends CI_Model
{
    /**
     * Create an ad
     *
     * @param array $data array contains data for the giveaway
     *              $data[id, title, date_created, end_date, is_archived]
     * @return boolean
     */
    public function create($data)
    {
        $this->db->set('is_archived', 1);
        $this->db->update('giveaways');

        $this->db->insert('giveaways', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete giveaway
     *
     * @param int $id giveaway id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('giveaways');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all giveaways
     *
     * @return mixed object|false
     */
    public function get()
    {
        $this->db->select('giveaways.id, title, DATE_FORMAT(giveaways.date_created, "%b %d %Y %h:%i %p") as date_created, DATE_FORMAT(end_date, "%b %d %Y %h:%i %p") as end_date, is_archived, count(user_id) as participants, status');
        $this->db->from('giveaways');
        $this->db->join('giveaways_participants', 'giveaways_participants.giveaway_id = giveaways.id', 'left');
        $this->db->group_by('giveaways.id');

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Get giveaway by id
     *
     * @param int $id giveaway id
     * @return mixed object|false
     */
    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('giveaways');
        $this->db->where('id', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Get giveaway participants
     *
     * @param int $giveaway_id giveaway id
     * @return mixed object|false
     */
    public function get_participants($giveaway_id)
    {
        $this->db->select('skearch_users.id, username, firstname, lastname, email, gender, is_winner');
        $this->db->from('skearch_users');
        $this->db->join('giveaways_participants', 'giveaways_participants.user_id = skearch_users.id', 'left');
        $this->db->where('giveaway_id', $giveaway_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an ad information
     *
     * @param int   $id   giveaway id
     * @param array $data array contains data for the giveaway
     *              $data[title, end_date]
     * @return boolean
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('giveaways', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set winner in the giveaway
     *
     * @param int   $id   giveaway id
     * @param int   $id   user id

     * @return boolean
     */
    public function set_winner($giveaway_id, $user_id)
    {
        $this->db->set('is_winner', 1);
        $this->db->where('giveaway_id', $giveaway_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('giveaways_participants');

        $this->db->set('is_winner', 0);
        $this->db->where('giveaway_id', $giveaway_id);
        $this->db->where('user_id !=', $user_id);
        $this->db->update('giveaways_participants');

        $this->db->set('status', 0);
        $this->db->where('id', $giveaway_id);
        $this->db->update('giveaways');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
