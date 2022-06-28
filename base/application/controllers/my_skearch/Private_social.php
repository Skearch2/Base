<?php

/**
 * File: ~/application/controller/my_skearch/Private_social.php
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

class Private_social extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('user_id')) {
            redirect("myskearch/auth/login");
        }

        $this->load->model('my_skearch/private_social_model', 'Private_social');

        date_default_timezone_set("America/Chicago");
    }


    /**
     * Load chat user(s)
     *
     * @return void
     */
    function chats()
    {
        if ($this->input->get('action')) {
            $sender_id = $this->session->userdata('user_id');
            $receiver_id = '';
            $output = '';
            $data = $this->Private_social->Fetch_chat_user_data($sender_id);
            if ($data->num_rows() > 0) {
                $output = array();
                foreach ($data->result() as $i => $row) {
                    if ($row->sender_id == $sender_id) {
                        $receiver_id = $row->receiver_id;
                    } else {
                        $receiver_id = $row->sender_id;
                    }
                    $userdata = $this->Private_social->Get_user_data($receiver_id);
                    $output[$i] = array(
                        'receiver_id'  => $receiver_id,
                        'firstname'  => $userdata['firstname'],
                        'lastname'   => $userdata['lastname'],
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
                $this->Private_social->Update_chat_message_status($sender_id, $receiver_id);
            }
            $chat_data = $this->Private_social->Fetch_chat_data($sender_id, $receiver_id);
            if ($chat_data->num_rows() > 0) {
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
     * View page for private social
     *
     * @return void
     */
    function index()
    {
        $data['section'] = 'private social';
        $data['page'] = 'private social';

        $data['title'] = ucwords("MySkearch | private social");

        $this->load->view('my_skearch/pages/private_social', $data);
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

            $this->Private_social->Insert_chat_message($data);
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
                    $last_activity = $this->Private_social->User_last_activity($sender_id)->last_activity;

                    // $is_type = '';

                    if ($last_activity != '') {

                        $current_timestamp = strtotime(date("Y-m-d H:i:s"));
                        $last_activity = strtotime($last_activity);

                        $diff = ($current_timestamp - $last_activity);

                        // status is 'online' if the time difference is >= 10 seconds
                        if ($diff <= 10) {
                            $status = 'online';
                            // $is_type = $this->Private_social->Check_type_notification($sender_id, $receiver_id, $current_timestamp);
                        }
                    }

                    $output[] = array(
                        'user_id'  => $sender_id,
                        'total_notification' => $this->Private_social->Count_chat_notification($sender_id, $receiver_id),
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
        $this->Private_social->Update_user_activity($this->session->userdata('user_id'));
    }

    /**
     * Actions for message request
     *
     * @return void
     */
    function request()
    {
        // send message request
        if ($this->input->get('send_userid')) {

            $sender_id  = $this->input->get('send_userid');
            $receiver_id = $this->input->get('receiver_userid');
            $chat_request_status = "Pending";

            $this->Private_social->Insert_chat_request($sender_id, $receiver_id, $chat_request_status);
        }

        // accepts message request
        if ($this->input->get('chat_request_id')) {
            $update_data = array(
                'chat_request_status' => 'Accept'
            );
            $this->Private_social->Update_chat_request($this->input->get('chat_request_id'), $update_data);
        }
    }

    /**
     * Check message request notifications
     *
     * @return void
     */
    function requests()
    {
        if ($this->input->get('action')) {
            $data = $this->Private_social->Fetch_notification_data($this->session->userdata('user_id'));
            $output = array();
            if ($data->num_rows() > 0) {
                foreach ($data->result() as $row) {
                    $userdata = $this->Private_social->Get_user_data($row->sender_id);

                    $output[] = array(
                        'user_id'  => $row->sender_id,
                        'first_name' => $userdata['firstname'],
                        'last_name'  => $userdata['lastname'],
                        //'profile_picture' => $userdata['profile_picture'],
                        'chat_request_id' => $row->chat_request_id
                    );
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
        }
    }

    /**
     * Search for a user
     *
     * @return void
     */
    function users()
    {
        if ($this->input->get('search_query')) {
            $data = $this->Private_social->search_user_data($this->session->userdata('user_id'), $this->input->get('search_query'));
            $output = array();
            if ($data->num_rows() > 0) {
                foreach ($data->result() as $row) {
                    $request_status = $this->Private_social->Check_request_status($this->session->userdata('user_id'), $row->id);
                    $is_request_send = 'yes';
                    if ($request_status == '') {
                        $is_request_send = 'no';
                    } else {
                        if ($request_status == 'Pending') {
                            $is_request_send = 'yes';
                        }
                    }
                    if ($request_status != 'Accept') {
                        $output[] = array(
                            'user_id'  => $row->id,
                            'first_name' => $row->firstname,
                            'last_name'  => $row->lastname,
                            // 'profile_picture' => $row->profile_picture,
                            'is_request_send' => $is_request_send
                        );
                    }
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));;
        }
    }
}
