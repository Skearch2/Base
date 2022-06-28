<?php

/**
 * File: ~/application/models/my_skearch/Giveaway_model.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Giveaway model for MySkearch
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2021 Skearch LLC
 */
class Giveaway_model extends CI_Model
{
    /**
     * Get latest giveaway
     *
     * @param int   $id   user id
     * @return mixed object|false
     */
    public function get()
    {
        $this->db->select('giveaways.id, title, DATE_FORMAT(giveaways.date_created, "%b %d %Y %h:%i %p") as date_created, DATE_FORMAT(end_date, "%b %d %Y %h:%i %p") as end_date, status, is_archived, giveaways_participants.user_id, crypto, amount');
        $this->db->from('giveaways');
        $this->db->join('giveaways_participants', 'giveaways.status = 0 AND giveaways_participants.giveaway_id = giveaways.id AND giveaways_participants.is_winner = 1', 'left');
        $this->db->where('is_archived', 0);
        // $this->db->where('end_date > NOW()');
        $this->db->order_by('date_created', 'desc');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }


    /**
     * verify participant in the giveaway
     *
     * @param int   $giveaway_id   giveaway id
     * @param int   $user_id   user id
     * @return mixed object|false
     */
    public function verify_participant($giveaway_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('giveaways_participants');
        $this->db->where('giveaway_id', $giveaway_id);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /**
     * Insert participant in the giveaway
     *
     * @param int   $id   giveaway id
     * @param int   $id   user id

     * @return boolean
     */
    public function insert_participant($giveaway_id, $user_id)
    {
        $data = [
            'giveaway_id' => $giveaway_id,
            'user_id' => $user_id
        ];

        $this->db->insert('giveaways_participants', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
