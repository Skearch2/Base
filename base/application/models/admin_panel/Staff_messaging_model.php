<?php

/**
 * File: ~/application/models/admin_panel/Staff_messaging_model.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Messaging model for staff
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */
class Staff_messaging_model extends CI_Model
{
    /**
     * Get user
     *
     * @param int $user_id
     * @return object User data
     */
    function get_user_data($user_id)
    {
        $this->db->where('id', $user_id);
        $data = $this->db->get('skearch_users');
        $output = array();
        foreach ($data->result() as $row) {
            $output['firstname'] = $row->firstname;
            $output['lastname'] = $row->lastname;
            $output['email'] = $row->email;
            //$output['profile_picture'] = $row->profile_picture;
        }
        return $output;
    }

    /**
     * Get staff
     *
     * @return object User data
     */
    function get_staff()
    {
        return $this->ion_auth->users(array(1, 2))->result();
    }


    /**
     * Get chat users
     *
     * @param int $user_id
     * @return object
     */
    function fetch_chat_user_data($user_id)
    {
        $this->db->where('chat_request_status', 'Accept');
        $this->db->where('(sender_id = "' . $user_id . '" OR receiver_id = "' . $user_id . '")');
        $this->db->order_by('chat_request_id', 'DESC');
        return $this->db->get('chat_request');
    }

    /**
     * Insert chat message
     *
     * @param string $data Message
     * @return void
     */
    function insert_chat_message($data)
    {
        $this->db->insert('chat_messages_staff', $data);
    }

    /**
     * Update message status whether it is read or not
     *
     * @param int $sender_id The one who sends the message
     * @param int $receiver_id The one who receives the message
     * @return void
     */
    function update_chat_message_status($sender_id, $receiver_id)
    {
        $data = array(
            'chat_messages_status'  => 'yes'
        );
        $this->db->where('sender_id', $receiver_id);
        $this->db->where('receiver_id', $sender_id);
        $this->db->where('chat_messages_status', 'no');
        $this->db->update('chat_messages_staff', $data);
    }

    /**
     * Get chat conversation
     *
     * @param int $sender_id The one who sends the message
     * @param int $receiver_id The one who receives the message
     * @return object
     */
    function fetch_chat_data($sender_id, $receiver_id)
    {
        $this->db->where('(sender_id = "' . $sender_id . '" OR sender_id = "' . $receiver_id . '")');
        $this->db->where('(receiver_id = "' . $receiver_id . '" OR receiver_id = "' . $sender_id . '")');
        $this->db->order_by('chat_messages_id', 'ASC');
        return $this->db->get('chat_messages_staff');
    }

    /**
     * Count # of unread messages
     *
     * @param int $sender_id The one who sends the message
     * @param int $receiver_id The one who receives the message
     * @return object
     */
    function count_chat_notification($sender_id, $receiver_id)
    {
        $this->db->where('sender_id', $sender_id);
        $this->db->where('receiver_id', $receiver_id);
        $this->db->where('chat_messages_status', 'no');
        $query = $this->db->get('chat_messages_staff');
        return $query->num_rows();
    }

    /**
     * Insert or update user timestamp
     *
     * @param int $user_id
     * @return void
     */
    function update_user_activity($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('login_data');

        if ($query->num_rows() > 0) {
            $data = array(
                'last_activity'  => date('Y-m-d H:i:s'),
                // 'is_type'   => $this->input->get('is_type')
            );

            $this->db->where('user_id', $user_id);
            $this->db->update('login_data', $data);
        } else {
            $data = array(
                'user_id' => $user_id,
                'last_activity'  => date('Y-m-d H:i:s'),
                // 'is_type'   => $this->input->get('is_type')
            );

            $this->db->insert('login_data', $data);
        }
    }

    /**
     * Get user's last updated timestamp
     *
     * @param int $user_id
     * @return void
     */
    function user_last_activity($user_id)
    {
        $this->db->select('last_activity');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('last_activity', 'DESC');
        $query = $this->db->get('login_data');

        return $query->row();
    }

    /**
     * Undocumented function
     *
     * @param [type] $sender_id
     * @param [type] $receiver_id
     * @param [type] $current_timestamp
     * @return void
     */
    function check_type_notification($sender_id, $receiver_id, $current_timestamp)
    {
        $this->db->where('receiver_user_id', $receiver_id);
        $this->db->where('user_id', $sender_id);
        $this->db->where('last_activity >', $current_timestamp);
        $this->db->order_by('login_data_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('login_data');
        foreach ($query->result() as $row) {
            return $row->is_type;
        }
    }
}
