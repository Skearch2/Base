<?php

//echo "<pre>"; print_r($users_groups); die();
// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

// Start body element
$this->load->view('admin_panel/templates/start_body');

// Start page section
$this->load->view('admin_panel/templates/start_page');

// Load header
$this->load->view('admin_panel/templates/header');

// Start page body
$this->load->view('admin_panel/templates/start_pagebody');

// Load sidemenu
$this->load->view('admin_panel/templates/sidemenu');

// Start inner body in a page body
$this->load->view('admin_panel/templates/start_innerbody');

// Load subheader in inner body
$this->load->view('admin_panel/templates/subheader');

?>
<!-- CSS file -->
<link rel="stylesheet" href="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/easy-autocomplete.min.css">

<div class="m-content">
    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--unair">
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST" action="" onsubmit="$('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom m-loader m-loader--light m-loader--right')">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10 m--show">
                                    <?php if (validation_errors()) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            <?= validation_errors(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($this->session->flashdata('email_sent_success')) : ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            <?= $this->session->flashdata('email_sent_success'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($this->session->flashdata('email_sent_failed')) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            <?= $this->session->flashdata('email_sent_failed'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-9 m-form__group-sub">
                                        <input type="text" class="form-control m-input" id="search" name="email" placeholder="Search email by last name" value="<?= set_value('email') ?>">
                                    </div>
                                </div>
                                <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                <div class=" form-group m-form__group row">
                                    <div class="col-lg-9 m-form__group-sub">
                                        <input type="text" name="subject" class="form-control m-input" placeholder="Subject" value="<?= set_value('subject') ?>">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <textarea name="content" id="html-editor" size="40"><?= set_value('content'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <button type="submit" id="btn-submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

// End page body
$this->load->view('admin_panel/templates/end_pagebody');

// Load footer
$this->load->view('admin_panel/templates/footer');

// End page section
$this->load->view('admin_panel/templates/end_page');

// Load quick sidebar
$this->load->view('admin_panel/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('admin_panel/templates/scrolltop');

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
    // settings for email search
    var options = {

        url: function(phrase) {
            return "<?= site_url(); ?>admin/users/get/lastname/" + phrase
        },

        getValue: "lastname",

        template: {
            type: "custom",
            method: function(value, item) {
                return item.firstname + " " + value + " - <i>" + item.email + "</i>";
            }
        },

        list: {
            match: {
                enabled: true
            },

            sort: {
                enabled: true
            },

            onSelectItemEvent: function() {
                var value = $("#search").getSelectedItemData().email;

                $("#search").val(value).trigger("change");
            },

            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 400,
                callback: function() {}
            },

            hideAnimation: {
                type: "fade", //normal|slide|fade
                time: 400,
                callback: function() {}
            }
        },

        theme: "bootstrap"
    };

    // initialize email search
    $("#search").easyAutocomplete(options);

    // initialize html editor
    $(document).ready(function() {
        $('#html-editor').summernote({
            height: 300
        });
    });
</script>

<script>
    $("#menu-email").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>