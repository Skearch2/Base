<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2018
 * @version		2.0
 */
class Setchange extends MY_Controller {

	public function __construct() {
		parent::__construct();
    }

    /**
     *
     */
	public function changecss(){
		$css = $this->input->post('css');
		
		$this->session->set_userdata('css',$css);
	}

}
