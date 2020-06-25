<?php

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
                                <div class="m-form__group form-group row">
                                    <label for="action" class="col-4 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="email_custom" value="0" onclick="customSearch()" <?= set_value('email_custom', 0) == 0 ? 'checked' : "" ?>> All Users
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="email_custom" value="1" onclick="customSearch(true)" <?= set_value('email_custom') == 1 ? 'checked' : "" ?>> Custom Users
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row" id="custom" style=<?= $email_custom ? 'display:block' : 'display:none' ?>>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <input type="text" class="form-control m-input" id="search" name="email" placeholder="Search email by last name" value="<?= set_value('email') ?>">
                                    </div>
                                </div>
                                <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-1x"></div>
                                <div class=" form-group m-form__group row">
                                    <div class="col-lg-12 m-form__group-sub">
                                        <input type="text" name="subject" class="form-control m-input" placeholder="Subject" value="<?= set_value('subject') ?>">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <textarea name="content" id="html-editor" size="40"><?= set_value('content'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <input id="email-custom" name="email-custom" type="hidden" value="<?= $email_custom; ?>">
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
    // show custom email search
    function customSearch(value) {
        var searchBox = document.getElementById("custom");
        $("#email-custom").val(1);

        if (value) {
            searchBox.style.display = "block";
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
                        type: "slide", //normal|slide|fade
                        callback: function() {}
                    },

                    hideAnimation: {
                        type: "normal", //normal|slide|fade
                        callback: function() {}
                    }
                }
            };

            // initialize email search
            $("#search").easyAutocomplete(options);
        } else {
            searchBox.style.display = "none";
            $("#email-custom").val(0);
        }
    }

    // initialize html editor
    $(document).ready(function() {
        $('#html-editor').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['clear', ['clear']],
                ['fontsize', ['style', 'fontname', 'fontsize']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table', 'link', 'picture', 'video']],
                ['other', ['fullscreen', 'code', 'help']]
            ],
            height: 300
        });
    });
</script>

<script>
    $("#menu-email").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
    $("#submenu-email-members").addClass("m-menu__item  m-menu__item--active");
</script>