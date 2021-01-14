<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/helpers/log_helper.php
 *
 * Helper file to log emails sent to users
 * 
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2021
 * @version        2.0
 */

/**
 * Log email sent to the user
 *
 * @param int $user_id
 * @param string $email_type
 * @param string $subject
 * @param string $body
 * @param array $attachments
 * @return void
 */
function log_email($user_id, $email_type, $subject, $body, $attachments = null)
{
    $CI = &get_instance();

    $CI->load->model('admin_panel/email/Log_model', 'Email_log_model');

    $CI->Email_log_model->create(array(
        'user_id' => $user_id,
        'type' => $email_type,
        'subject' => $subject,
        'body' => $body,
        'attachment' => null,                // TODO: attachments in json array
        'timestamp' => date('Y-m-d H:i:s')
    ));

    return $CI->db->affected_rows();
}
