<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File:	~/application/views/templates/messagepane.php
 *
 * @package		Skearch
 * @author		Fred McDonald
 * @email		fred.mcdonald@live.com
 * @copyright	Copyright (c) 2017
 * @since		Version 2.0.0
 * @description Display site messages, errors, notifications
 * 		If there is a site message, this inserts a section element
 * 		between the page header and the content div
 */ 

/*
	$msg = $this->session->flashdata('message');

	if ($msg) {
		echo "<p>".$msg."</p>";
	}
*/

   $session_data = $this->session;
   $maintenance = $this->config->item('maintenance');

?>

   <section id='messagepane'>

    <?php if ($maintenance) : ?> 
        <p><span id='maintenance'>Maintenance Mode is On</span></p>
    <?php endif; ?> 
    
   </section>   
<!--        
        echo "<p>";
            echo "Full session var data: <br>";
//            print_r($this->session);
//            print_r($session_data);
*/        echo "</p>";
        
/*
        echo "<p>";
            echo "<strong>Freemium Test</strong><br>";
            echo "Session Date: ".($this->session->session_date)."<br>";
            echo "Remaining time (seconds): <mark>".($this->session->remaining)."</mark>";
        echo "</p>";
-->
		
  
