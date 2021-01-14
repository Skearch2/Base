<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/email/Log_model.php
 *
 * This model log emails sent to users
 * 
 * @package       Skearch
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright     Copyright (c) 2021
 * @version       2.0
 */
class Log_model extends CI_Model
{

  /**
   * Create an email log
   *
   * @param array $data data[user id, email type, subject, body, attachment, timestamp]
   * @return void
   */
  public function create($data)
  {
    $this->db->insert('skearch_email_logs', $data);

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Delete all email logs assocaited to the user
   *
   * @return void
   */
  public function delete($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->delete('skearch_email_logs');

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Get all emails sent to the user
   *
   * @param int $user_id User ID
   * @return object
   */
  public function get($user_id)
  {
    $this->db->select('id, type, subject, body, attachment as attachments, DATE_FORMAT(timestamp, "%m-%d-%Y") as date_sent');
    $this->db->from('skearch_email_logs');
    $this->db->where('user_id', $user_id);

    $query = $this->db->get();

    return $query->result();
  }

  /**
   * Get email snapshot
   *
   * @param int $user_id User ID
   * @return object
   */
  public function get_email($id)
  {
    $this->db->select('id, type, subject, body, attachment as attachments, DATE_FORMAT(timestamp, "%m-%d-%Y") as date_sent');
    $this->db->from('skearch_email_logs');
    $this->db->where('id', $id);

    $query = $this->db->get();

    if ($query->num_rows()) {
      return $query->row();
    } else {
      return false;
    }
  }
}
