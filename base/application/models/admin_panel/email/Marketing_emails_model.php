<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/email/marketing_emails_model.php
 *
 * Model for marketing emails
 * 
 * @package       Skearch
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright     Copyright (c) 2022
 * @version       2.0
 */
class Marketing_emails_model extends CI_Model
{

  /**
   * Add emails to the database
   *
   * @param array $data array of emails
   * @return boolean]
   */
  public function add($data)
  {
    $this->db->insert_batch('marketing_emails', $data);

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Delete email
   *
   * @param int $id Email id
   * @return boolean
   */
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('marketing_emails');

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Get email(s) from the database
   *
   * @param int $id email id
   * @param int $is_subscribed if email is subscribed
   * @return object
   */
  public function get($id = null, $is_subscribed = null)
  {
    $this->db->select('id, email, is_subscribed');
    $this->db->from('marketing_emails');

    if ($id) {
      $this->db->where('id', $id);
      $query = $this->db->get();

      return $query->row();
    } else {
      if ($is_subscribed != null) {
        $this->db->where('is_subscribed', $is_subscribed);
      }
      $query = $this->db->get();

      return $query->result();
    }
  }

  /**
   * Update email
   *
   * @param array $id email id
   * @param array $data email data
   * @return boolean
   */
  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('marketing_emails', $data);

    if ($this->db->affected_rows()) {
      return true;
    } else {
      return false;
    }
  }
}
