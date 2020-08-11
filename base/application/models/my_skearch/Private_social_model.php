<?php

/**
 * File: ~/application/models/my_skearch/Private_social_model.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Private social messaging moodel
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */
class Private_social_model extends CI_Model
{
    /**
     * Search user
     *
     * @param int $user_id
     * @param string $username
     * @return object
     */
    function search_user_data($user_id, $username)
    {
        $this->db->where('id !=', $user_id);
        $this->db->where('username', $username);

        return $this->db->get('skearch_users');
    }

    /**
     * Check for message requests
     *
     * @param int $sender_id The one who sends the request
     * @param int $receiver_id The one who receives the request
     * @return object
     */
    function check_request_status($sender_id, $receiver_id)
    {
        $this->db->where('(sender_id = "' . $sender_id . '" OR sender_id = "' . $receiver_id . '")');
        $this->db->where('(receiver_id = "' . $receiver_id . '" OR receiver_id = "' . $sender_id . '")');
        $this->db->order_by('chat_request_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('chat_request');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->chat_request_status;
            }
        }
    }

    /**
     * Insert message request
     *
     * @param int $sender_id The one who sends the request
     * @param int $receiver_id The one who receives the request
     * @param string $chat_request_status Accept|Reject|Pending
     * @return void
     */
    function insert_chat_request($sender_id, $receiver_id, $chat_request_status)
    {
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'chat_request_status' => $chat_request_status
        );
        $this->db->insert('chat_request', $data);
    }

    /**
     * Get message requests
     *
     * @param int $receiver_id The one who receives the request
     * @return object
     */
    function fetch_notification_data($receiver_id)
    {
        $this->db->where('receiver_id', $receiver_id);
        $this->db->where('chat_request_status', 'Pending');
        return $this->db->get('chat_request');
    }

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
     * Update chat request such as accept or reject
     *
     * @param int $chat_request_id Request id
     * @param string $data Accept | Reject
     * @return void
     */
    function update_chat_request($chat_request_id, $data)
    {
        $this->db->where('chat_request_id', $chat_request_id);
        $this->db->update('chat_request', $data);
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
        $this->db->insert('chat_messages', $data);
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
        $this->db->update('chat_messages', $data);
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
        return $this->db->get('chat_messages');
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
        $query = $this->db->get('chat_messages');
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
