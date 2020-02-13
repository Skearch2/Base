<?php

// Set DocType and declare HTML protocol
$this->load->view('templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('templates/head');

// Start body element
$this->load->view('templates/startbody');

// Load appropriate header (logged in, admin options, etc.)
$this->load->view('templates/header');

?>

<section>
    <div class="logo-home">
      <a href= "<?= site_url(); ?>">
            <img src="<?=site_url() . "assets/style/images/fl.png";?>" alt="<?=$title;?>">
      </a>
    </div>

    <div class="clearfix"></div>
    <div class="container">
        <div id="center" class="column mgtop clearfix" style='position:relative;'>
          <div>
            <a href="http://www.skearch.io/brand">
             <button type="button">Learn more</button>
           </a>
          </div>
            <div class="search-bar">
                <div class="search-box">
                <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                            <input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
                            <div class="relative">
                                <button class="search-btn" border="0" onclick="searchBtn()" type="submit">
                            </div>
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
