<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/email/Invite_log_model.php
 *
 * This model logs invite emails
 * 
 * @package       Skearch
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright     Copyright (c) 2021
 * @version       2.0
 */
class Invite_log_model extends CI_Model
{

  /**
   * Create an invite email log
   *
   * @param array $data array of emails
   * @return boolean]
   */
  public function create($data)
  {
    $this->db->insert_batch('email_invite_logs', $data);

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
  public function get()
  {
    $this->db->select('id, email, subject, DATE_FORMAT(timestamp, "%m-%d-%Y %r") as date_sent');
    $this->db->from('email_invite_logs');

    $query = $this->db->get();

    return $query->result();
  }

  /**
   * Get email snapshot
   *
   * @param int $email_id email ID
   * @return object
   */
  public function get_email($id)
  {
    $this->db->select('id, subject, body, attachment as attachments, DATE_FORMAT(timestamp, "%m-%d-%Y %r") as date_sent');
    $this->db->from('email_invite_logs');
    $this->db->where('id', $id);

    $query = $this->db->get();

    if ($query->num_rows()) {
      return $query->row();
    } else {
      return false;
    }
  }
}
