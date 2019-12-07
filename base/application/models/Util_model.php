<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File:    ~/application/models/Category_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package        Skearch
 * @author        Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018
 * @version        2.0
 */
class Util_model extends CI_Model
{

    public function get_country_list()
    {

        $this->db->select('country_name');
        $this->db->from('data_countries');
        $query = $this->db->get();

        return $query->result();

    }

    public function get_state_list()
    {

        $this->db->select('statecode');
        $this->db->from('data_states');
        $query = $this->db->get();

        return $query->result();
    }

}
