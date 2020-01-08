<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/models/Category_model.php
 *
 * This model fetch data based on category and its subcategory.
 * It also provides category listing.
 * @package		Skearch
 * @author		Zaawar Ejaz <zaawar@yahoo.com>
 * @copyright	Copyright (c) 2019
 * @version		2.0
 */
class Linkcheck_model_admin extends CI_Model {

    /*
     * Returns urls of all adlinks.
     */

    public function get_urls() {

        $query = $this->db->select('id, www');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->where('enabled', 1);
        $query = $this->db->get();
        return $query->result();


        // $data = array(
        //     'date' => date("Y-m-d H:i:s")
        // );
        //   $this->db->insert('test', $data);

    }

    public function get_bad_urls() {

        $query = $this->db->select('id, title, enabled, http_status_code, last_status_check, www');
        $query = $this->db->from('skearch_listings');
        $query = $this->db->where('http_status_code <', 200);
        $query = $this->db->or_where('http_status_code >=', 400);
        $query = $this->db->get();
        return $query->result();

    }

    public function update_http_status($id, $code) {
        $data = array(
            'http_status_code' => $code,
            'last_status_check ' => date("Y-m-d H:i:s")
        );

        $this->db->where('id', $id);
        $this->db->update('skearch_listings', $data);

    }


}
