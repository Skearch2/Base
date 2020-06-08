<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/admin_panel/email/Template_model.php
 *
 * This model provides ability to view and update email tempaltes
 * @package       Skearch
 * @author        Iftikhar Ejaz <iftikhar@skearch.com>
 * @copyright     Copyright (c) 2019
 * @version       2.0
 */
class Template_model extends CI_Model
{

  public function get_template($template_name)
  {
    $this->db->select('subject, body');
    $this->db->from('skearch_email_templates');
    $this->db->where('template', $template_name);
    $query = $this->db->get();

    return $query->row();
  }

  public function update_template($template_name)
  {
    $data = array(
      'subject' => $this->input->post('subject'),
      'body'    => $this->input->post('body')
    );
    $this->db->set($data);
    $this->db->where('template', $template_name);

    if ($this->db->update('skearch_email_templates')) {
      return true;
    } else {
      return false;
    }
  }
}
