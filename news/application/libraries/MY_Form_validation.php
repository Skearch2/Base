<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

   public function is_unique($str, $field)
   {
     $hooskDB = $this->load->database('hoosk', TRUE);

      if (substr_count($field, '.')==3)
      {
         list($table,$field,$id_field,$id_val) = explode('.', $field);
         $query =  $hooskDB->limit(1)->where($field,$str)->where($id_field.' != ',$id_val)->get($table);
      } else {
         list($table, $field)=explode('.', $field);
         $query =  $hooskDB->db->limit(1)->get_where($table, array($field => $str));
      }

      return $query->num_rows() === 0;
    }

}
// END MY Form Validation Class

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
