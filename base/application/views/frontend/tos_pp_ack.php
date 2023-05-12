<?php

// Set DocType and declare HTML protocol
$this->load->view('frontend/templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('frontend/templates/head');

// Start body element
$this->load->view('frontend/templates/startbody');

?>

<!-- Display All Umbrellas and its fields -->
<section class="field-main">
    <div class="container">
        <div class="row">
            <div class="main-box">
                <div class="box">
                    <h3>Updated Terms of Service / Privacy Policy</h3>
                </div>
                <div class="border-box browse-inner tos-pp">
                    In order to access MySkearch you need to accept our latest <b>terms of service</b> and <b>privacy policy</b> at the end of this page.
                </div>
                <div class="border-box browse-inner tos-pp">
                    <?= $content ?>
                </div>
                <?= form_open('myskearch/auth/tos/accept', array('id' => 'm_form', 'class' => 'm-login__form m-form m-form--fit')) ?>
                <div class="border-box browse-inner form-group m-form__group" style="display: flex;justify-content: center;">
                    <input type="hidden" id="tos_pp_accept_chk" name="tos_pp_accept_chk">
                    <button id="tos_pp_accept_btn" class="btn btn-primary m-btn m-btn--custom m-login__btn">Accept</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
</section>

<script>
    $(document).ready(function() {
        $("#tos_pp_accept_btn").click(function() {
            $("#tos_pp_accept_chk").val(true);
        });
    });
</script>

<?php

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>