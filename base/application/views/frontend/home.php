<?php

// Set DocType and declare HTML protocol
$this->load->view('frontend/templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('frontend/templates/head');

// Start body element
$this->load->view('frontend/templates/startbody');

// Load nav bar (logged in, admin options, etc.)
$this->load->view('frontend/templates/nav');

?>
<section class="logo">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 logo-bar">
                <img src="<?= base_url(ASSETS) ?>/frontend/images/home-logo.png" class="logo light-logo" alt="" />
                <img src="<?= base_url(ASSETS) ?>/frontend/images/dark-logo.png" class="logo dark-logo" alt="" style="display:none" />
            </div>
        </div>
    </div>
</section>

<section class="button-section">
    <div class="container">
        <a href="browse">
            <h1>Browse All<span>Fields</span></h1>
        </a>
        <?php foreach ($fields as $field) : ?>
            <?php if ($field->title == 'empty') : ?>
                <button style="visibility: hidden;" class="btn btn-link disabled"></button>
            <?php else : ?>
                <?php if ($field->parent_title != null) : ?>
                    <a href="browse/<?= strtolower($field->parent_title) ?>/<?= strtolower($field->title) ?>" class="btn btn-link" role="button"><?= $field->parent_title ?></a>
                <?php else : ?>
                    <a href="browse/<?= strtolower($field->title) ?>" class="btn btn-link" role="button"><?= $field->title ?></a>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>

<section class="search-box search-bot">
    <div class="container">
        <div class="search-bar">
            <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
                <button class="search-btn" border="0"></button>
            </form>
        </div>
</section>

<?php

// Load default footer.
$this->load->view('frontend/templates/footer');

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>