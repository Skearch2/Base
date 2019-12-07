<?php

// Set DocType and declare HTML protocol
$this->load->view('templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('templates/head');

// Start body element
$this->load->view('templates/startbody');

// Load appropriate header (logged in, admin options, etc.)
$this->load->view('templates/header');

//Load message page (if notifications are found)
$this->load->view('templates/messagepane');

?>

<section>
    <div class="logo-home">
    <a href= "">

	<?php

	if($this->session->userdata('css')!='') {
		//echo $this->session->userdata('css');
		if($this->session->userdata('css')=="light") {
	?>
            <img src="<?=base_url(ASSETS) . "/style/images/fl.png";?>" alt="<?=$title;?>">
			<?php
		} else {
	?>
	<img src="<?=base_url(ASSETS) . "/style/images/dark-logo.jpg";?>" alt="<?=$title;?>" style="padding-top:5px;">
	<?php
		}
	} else {
	?>
	<img src="<?=base_url(ASSETS) . "/style/images/fl.png";?>" alt="<?=$title;?>">
	<?php } ?>
            </a>
    </div>

<div class="clearfix"></div>
    <div class="container">
        <div id="center" class="column mgtop clearfix" style='position:relative;'>
            <div class="home-browse">
                <div class="browse-field-auto">
                    <?php
echo anchor('browse', 'Browse All <span>Fields</span>', array('class' => 'anchorbrowse'));
?>

                    <div class="cat-bg home-catlist">
                    <ul class="category_list_home">

<!-- Get user top level categories -->
<?php foreach ($fields as $field): ?>
   <?php if($field->title == 'empty') echo "<li style='opacity: 0;'><a style='cursor: default' href='#'>Empty</a></li>"; else {?>

    <li <?php echo ($field->parent_title == null) ? "style='box-shadow: 0 0 100px 1px black inset; border-radius: 7px;'" : ""; ?>>
    <?php
if ($field->parent_title != null) {
echo anchor("browse/" . strtolower($field->parent_title) . "/" . strtolower($field->title), $field->title, array('title' => $field->title));
} else {
echo anchor("browse/" . strtolower($field->title), $field->title, array('title' => $field->title));
} ?>
       </li>
<?php } endforeach;?>
</ul>
                    </div>
                </div>
            </div>
            <div class="search-bar">
                <div class="search-box">
                    <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                        <input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
	                    <div class="relative">
		                    <button class="search-btn" border="0" onclick="searchBtn()" type="submit"/>
                        </div>
                        <div id="cover"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

// Load default footer.
$this->load->view('templates/footer');

// Close body and html elements.
$this->load->view('templates/closepage');

?>
