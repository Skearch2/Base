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
                        <form class="m-form m-form--fit m-form--label-align-right" role="form" id="m_form" method="POST" action="" onsubmit="$('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom m-loader m-loader--light m-loader--right')">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <div class="m-portlet__body">
                                <?php if ($this->session->flashdata('success') === 1) : ?>
                                    <div class="m-form__content">
                                        <div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
                                            <div class="m-alert__icon">
                                                <i class="la la-check-circle"></i>
                                            </div>
                                            <div class="m-alert__text">
                                                The email message has been sent successfully.
                                            </div>
                                            <div class="m-alert__close">
                                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($this->session->flashdata('success') === 0) : ?>
                                    <div class="m-form__content">
                                        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
                                            <div class="m-alert__icon">
                                                <i class="la la-times-circle"></i>
                                            </div>
                                            <div class="m-alert__text">
                                                Unable to sent the email message.
                                            </div>
                                            <div class="m-alert__close">
                                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif (validation_errors()) : ?>
                                    <div class="m-form__content">
                                        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
                                            <div class="m-alert__icon">
                                                <i class="la la-warning"></i>
                                            </div>
                                            <div class="m-alert__text">
                                                <?= validation_errors() ?>
                                            </div>
                                            <div class="m-alert__close">
                                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="m-form__content">
                                    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_msg">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            There are some errors found in the form, please check and try submitting again!
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" data-close="alert" aria-label="Close">
                                            </button>
                                        </div>
                                    </div>
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
                                                <input type="radio" name="email_custom" value="1" onclick="customSearch(true)" <?= set_value('email_custom') == 1 ? 'checked' : "" ?>> Custom User
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row" id="custom" style=<?= $email_custom ? 'display:block' : 'display:none' ?>>
                                    <div class="col-lg-12 m-form__group-sub">
                                        <input type="text" class="form-control m-input" id="search" name="email" placeholder="Search email by last name" value="<?= set_value('email') ?>">
                                        <input type="hidden" id="user-id" name="user_id" value="<?= set_value('user_id') ?>">
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>

<script>
    var FormControls = {
        init: function() {
            $("#m_form").validate({
                rules: {
                    subject: {
                        required: 1
                    },
                    content: {
                        required: 1
                    }
                },
                invalidHandler: function(e, r) {
                    $("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
                    $('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom');
                },
                submitHandler: function(e) {
                    form.submit();
                },
            });
        }
    };

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
                        var id = $("#search").getSelectedItemData().id

                        $("#search").val(value).trigger("change");
                        $("#user-id").val(id);
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
        FormControls.init();

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

    $("#menu-email").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
    $("#submenu-email-members").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>