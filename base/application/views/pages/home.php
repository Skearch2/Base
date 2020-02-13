<?php

// Set DocType and declare HTML protocol
$this->load->view('templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('templates/head');

// Start body element
$this->load->view('templates/startbody');

// Load navigation panel (sign up, login, admin options, etc.)
$this->load->view('templates/nav');

?>

<section>
    <div class="logo-home">
        <img src="<?= base_url(ASSETS) . "/style/images/fl.png"; ?>" alt="<?= $title; ?>">
    </div>
    <div class="clearfix"></div>
    <div class="container">
        <div id="center" class="column mgtop clearfix" style='position:relative;'>
            <div class="home-browse">
                <div class="browse-field-auto">
                    <?= anchor('browse', 'Browse All <span>Fields</span>', array('class' => 'anchorbrowse'))  ?>
                    <div class="cat-bg home-catlist">
                        <ul class="category_list_home">
                            <?php foreach ($fields as $field) : ?>
                                <?php if ($field->title == 'empty') : ?>
                                    <li style='opacity: 0;'><a style='cursor: default' href='#'>Empty</a></li>
                                <?php else : ?>
                                    <li <?= ($field->parent_title == null) ? "style='box-shadow: 0 0 100px 1px black inset; border-radius: 7px;'" : ""; ?>>
                                        <?php if ($field->parent_title != null) {
                                            echo anchor("browse/" . strtolower($field->parent_title) . "/" . strtolower($field->title), $field->title, array('title' => $field->title));
                                        } else {
                                            echo anchor("browse/" . strtolower($field->title), $field->title, array('title' => $field->title));
                                        } ?>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 search-box">
                <div class="search-bar">
                    <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                        <input type="text" size="64" class="google-input" placeholder="Enter Keywords...">
                        <button class="search-btn" border="0" onclick="searchBtn()" type="submit"></button>
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