<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/email/Log_model.php
 *
 * This model provides ability to view and update email tempaltes
 * @package       Skearch
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright     Copyright (c) 2019
 * @version       2.0
 */
class Log_model extends CI_Model
{

  /**
   * Creates an email log
   *
   * @param array $data Array contains: log type, user email, timestamp
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
   * Clear all email logs
   *
   * @return void
   */
  public function delete()
  {
    $this->db->empty_table('skearch_email_logs');

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Get all email logs
   *  
   * @return object
   */
  public function get()
  {
    $this->db->select('type, skearch_users.email, DATE_FORMAT(timestamp, "%m-%d-%Y") as date_sent');
    $this->db->join('skearch_users', 'skearch_users.id = skearch_email_logs.user_id', 'left');
    $this->db->from('skearch_email_logs');

    $query = $this->db->get();

    return $query->result();
  }
}
