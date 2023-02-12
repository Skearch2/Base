<?php

// Set DocType and declare HTML protocol
$this->load->view('frontend/templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('frontend/templates/head');

// Start body element
$this->load->view('frontend/templates/startbody');

// Load appropriate header (logged in, admin options, etc.)
$this->load->view('frontend/templates/header');

?>

<!-- Display All Umbrellas and its fields -->
<section class="field-main">
    <div class="container">
        <div class="row">
            <div class="main-box">
                <div class="box">
                    <h3>Terms of Service / Privacy Policy</h3>
                </div>
                <div class="border-box browse-inner tos-pp">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

// Load default footer.
$this->load->view('frontend/templates/footer');

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>