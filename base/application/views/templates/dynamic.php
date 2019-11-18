<!--
	File:     ~/application/views/templates/dynamic.php
	Author:   Fred McDonald - fred.mcdonald@live.com

	Displays page information retrieved from database.
	
	$page_data is set by Pages controller.
	
	table: pmd_pages
	field: hidden_title

-->
<?php

	$this->load->helper('url');
	$this->load->library('globals');

	echo $page_data;
?>

