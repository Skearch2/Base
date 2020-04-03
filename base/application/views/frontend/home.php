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
<style>
    @media screen and (max-width: 415px) {
        .logo {
            width: 100%;
        }
    }
</style>

<section class="logo">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 logo-bar">
                <div class="logo-img"></div>
            </div>
        </div>
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

<section class="button-section">
    <div class="container">
        <a href="browse">
            <h1>Browse All<span>Fields</span></h1>
        </a>
        <?php foreach ($results as $results) : ?>
            <?php if ($results->result_id == 0) : ?>
                <button style="visibility: hidden;" class="btn btn-link"></button>
            <?php else : ?>
                <?php if ($results->is_result_umbrella != 1) : ?>
                    <a href="browse/<?= strtolower($results->umbrella) ?>/<?= strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
                <?php else : ?>
                    <a href="browse/<?= strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>

<?php

// Load default footer.
$this->load->view('frontend/templates/footer');

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>