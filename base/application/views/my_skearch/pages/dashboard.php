<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header and menu
$this->load->view('my_skearch/templates/header');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-content">
	Dashboard content goes here
</div>

<!--	Button - Set Skearch as homepage -->
<div class='home-footer-btn'>
	<?=anchor('', '&nbsp', array('class' => 'btn-footer-skear'));?>
	<br>
        <?=anchor('set-skearch-default', '»Set Skearch as my default search engine', array('title' => 'Set Skearch as Default Search Engine', 'class' => 'set-skearch'));?>
</div>
<!--	End: Button - Set Skearch as homepage -->


<?php

// End page body
$this->load->view('my_skearch/templates/end_pagebody');

// Load footer
$this->load->view('my_skearch/templates/footer');

// End page section
$this->load->view('my_skearch/templates/end_page');

// Load quick sidebar
$this->load->view('my_skearch/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('my_skearch/templates/scrolltop');

// Close body and html (contains some javascripts links)
$this->load->view('my_skearch/templates/close_html');

?>
