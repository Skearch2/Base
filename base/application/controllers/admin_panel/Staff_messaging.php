<?php

/**
 * File: ~/application/controller/admin_panel/Staff_messaging.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Private social messaging for skearch users
 *
 * Allows users to send messages to each other
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */

class Staff_messaging extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_id')) {
            redirect("myskearch/auth/login");
        }

        $this->load->model('admin_panel/staff_messaging_model', 'Staff_messaging');

        date_default_timezone_set("America/Chicago");
    }


    /**
     * Load chat user(s)
     *
     * @return void
     */
    function staff()
    {
        if ($this->input->get('action')) {
            $output = '';
            $data = $this->Staff_messaging->get_staff($this->session->userdata('user_id'));

            if (!empty($data)) {
                $output = array();
                foreach ($data as $i => $row) {
                    $output[$i] = array(
                        'receiver_id' => $row->id,
                        'firstname'  => $row->firstname,
                        'lastname'   => $row->lastname,
                        'group'   => $row->group_id,
                        //'profile_picture' => $userdata['profile_picture']
                    );
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }
    }

    /**
     * Get chat coversation
     *
     * @return void
     */
    function conversation()
    {
        if ($this->input->get('receiver_id')) {
            $receiver_id = $this->input->get('receiver_id');
            $sender_id = $this->session->userdata('user_id');
            if ($this->input->get('update_data') == 'yes') {
                $this->Staff_messaging->Update_chat_message_status($sender_id, $receiver_id);
            }
            $chat_data = $this->Staff_messaging->Fetch_chat_data($sender_id, $receiver_id);
            $output = '';
            if ($chat_data->num_rows() > 0) {
                $output = array();
                foreach ($chat_data->result() as $row) {
                    $message_direction = '';
                    if ($row->sender_id == $sender_id) {
                        $message_direction = 'right';
                    } else {
                        $message_direction = 'left';
                    }
                    $date = date('D M Y H:i', strtotime($row->chat_messages_datetime));
                    $output[] = array(
                        'chat_messages_text' => $row->chat_messages_text,
                        'chat_messages_datetime' => $date,
                        'message_direction'  => $message_direction
                    );
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }
    }

    /**
     * Send chat message
     *
     * @return void
     */
    function message()
    {
        if ($this->input->get('receiver_id')) {
            $data = array(
                'sender_id'  => $this->session->userdata('user_id'),
                'receiver_id' => $this->input->get('receiver_id'),
                'chat_messages_text' => $this->input->get('chat_message'),
                'chat_messages_status' => 'no',
                'chat_messages_datetime' => date('Y-m-d H:i:s')
            );

            $this->Staff_messaging->Insert_chat_message($data);
        }
    }

    /**
     * Notification such as # of unread messages, online/offline
     *
     * @return void
     */
    function notifications()
    {
        if ($this->input->get('user_id_array')) {
            $receiver_id = $this->session->userdata('user_id');

            $user_id_array = explode(",", substr($this->input->get('user_id_array'), 0, -1));

            $output = array();

            foreach ($user_id_array as $sender_id) {
                if ($sender_id != '') {
                    $status = "offline";
                    $data = $this->Staff_messaging->User_last_activity($sender_id);

                    if (!empty($data)) {

                        $last_activity = $data->last_activity;

                        // $is_type = '';

                        if ($last_activity != '') {

                            $current_timestamp = strtotime(date("Y-m-d H:i:s"));
                            $last_activity = strtotime($last_activity);

                            $diff = ($current_timestamp - $last_activity);

                            // status is 'online' if the time difference is >= 10 seconds
                            if ($diff <= 10) {
                                $status = 'online';
                                // $is_type = $this->Staff_messaging->Check_type_notification($sender_id, $receiver_id, $current_timestamp);
                            }
                        }
                    }

                    $output[] = array(
                        'user_id'  => $sender_id,
                        'total_notification' => $this->Staff_messaging->Count_chat_notification($sender_id, $receiver_id),
                        'status'  => $status
                        // 'is_type'  => $is_type
                    );
                }
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }
    }

    /**
     * Ping user activity timestamp
     *
     * @return void
     */
    function ping()
    {
        $this->Staff_messaging->Update_user_activity($this->session->userdata('user_id'));
    }
}
