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

<div class="modal fade" id="modal_send_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email to All</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="text" name="email-subject" class="form-control m-input" placeholder="Subject" value="<?= set_value('email-subject') ?>">
                        &emsp;
                        <textarea name="email-content" id="html-editor" size="50"><?= set_value('email-content'); ?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-email-send" onclick="sendEmail()">Send</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_emails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Emails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <textarea class="form-control" rows="10" id="emails" name="emails" style="overflow-y:scroll"></textarea>
                        <span class="m-form__help">Seperate emails by new line</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-emails-add" onclick="addEmails()">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="email" class="form-control-label">Email:</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-email-save" onclick="updateEmail()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <?= $title ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <button type="button" class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#modal_send_email">Send Email to All</button>
                    &emsp;
                    <button type="button" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#modal_add_emails">Add Emails</button>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <?php if ($this->session->flashdata('clear_success') === 1) : ?>
                <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        Email(s) has been added.
                    </div>
                </div>
            <?php elseif ($this->session->flashdata('clear_success') === 0) : ?>
                <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        Unable to add email(s).
                    </div>
                </div>
            <?php endif ?>

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
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

<script>
    // add emails
    function addEmails() {
        $.ajax({
            url: '<?= site_url('admin/email/marketing_emails/add'); ?>',
            type: 'GET',
            data: {
                emails: $("[name=emails]").val().trim()
            },
            beforeSend: function(xhr, options) {
                $("#btn-emails-add").attr("class", "btn m-btn btn-success m-loader m-loader--light m-loader--right").attr("disabled", "disabled");
                setTimeout(function() {
                    $.ajax($.extend(options, {
                        beforeSend: $.noop
                    }));
                }, 2000);
                return false;
            },
            success: function(data, status) {
                $("#modal_add_emails").modal('hide');
                $("#btn-emails-add").attr("class", "btn m-btn btn-primary");
                if (data == -1) {
                    toastr.warning("", "You have no permission.");
                } else if (data == 0) {
                    toastr.error("Unable to add emails or some emails were invalid.");
                } else {
                    $("[name=emails]").val("")
                    toastr.success("Emails added successfully.");
                    $('#m_table_1').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_add_emails").modal('hide');
                $("#btn-emails-add").attr("class", "btn m-btn btn-primary");
                toastr.error("Unable to process request.");
            },
            complete: function(xhr, status, error) {
                $("#btn-emails-add").attr("class", "btn m-btn btn-primary").removeAttr("disabled");
            }
        });
    }

    // send email to all in master list
    function sendEmail() {
        $.ajax({
            url: '<?= site_url('admin/email/marketing_emails/send'); ?>',
            type: 'POST',
            data: {
                "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>",
                "email-subject": $("[name=email-subject]").val().trim(),
                "email-content": $("[name=email-content]").val().trim()
            },
            beforeSend: function(xhr, options) {
                $("#btn-email-send").attr("class", "btn m-btn btn-success m-loader m-loader--light m-loader--right").attr("disabled", "disabled");
                setTimeout(function() {
                    $.ajax($.extend(options, {
                        beforeSend: $.noop
                    }));
                }, 2000);
                return false;
            },
            success: function(data, status) {
                $("#modal_send_email").modal('hide');
                $("#btn-emails-add").attr("class", "btn m-btn btn-primary");
                if (data == -1) {
                    toastr.warning("", "You have no permission.");
                } else if (data == 0) {
                    toastr.error("Unable to send email.");
                } else {
                    $("[name=emails]").val("")
                    toastr.success("Email sent successfully.");
                    $('#m_table_1').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_send_email").modal('hide');
                $("#btn-email-send").attr("class", "btn m-btn btn-primary");
                toastr.error("Unable to process request.");
            },
            complete: function(xhr, status, error) {
                $("#btn-email-send").attr("class", "btn m-btn btn-primary").removeAttr("disabled");
            }
        });
    }

    var email_id

    // edit email
    function editEmail(id, email) {
        email_id = id
        $('#email').val(email);
    }

    // update email
    function updateEmail() {
        $.ajax({
            url: '<?= site_url('admin/email/marketing_emails/update'); ?>',
            type: 'GET',
            data: {
                id: email_id,
                email: $("#email").val().trim()
            },
            beforeSend: function(xhr, options) {
                $("#btn-email-save").attr("class", "btn m-btn btn-success m-loader m-loader--light m-loader--right").attr("disabled", "disabled");
                setTimeout(function() {
                    $.ajax($.extend(options, {
                        beforeSend: $.noop
                    }));
                }, 2000);
                return false;
            },
            success: function(data, status) {
                $("#modal_edit_email").modal('hide');
                $("#btn-email-save").attr("class", "btn m-btn btn-primary");
                if (data == -1) {
                    toastr.warning("", "You have no permission.");
                } else if (data == 0) {
                    toastr.error("Unable to update email or email is invalid.");
                } else {
                    $("#email").val("")
                    toastr.success("Email updated successfully.");
                    $('#m_table_1').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_edit_email").modal('hide');
                $("#btn-emails-add").attr("class", "btn m-btn btn-primary");
                toastr.error("Unable to process request.");
            },
            complete: function(xhr, status, error) {
                $("#btn-email-save").attr("class", "btn m-btn btn-primary").removeAttr("disabled");
            }
        });
    }

    // delete email
    function deleteEmail(id, email) {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want delete this email: \"" + email + "\"?",
            type: "warning",
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Yes, delete it!",
            showCancelButton: true,
            timer: 5000
        }).then(function(e) {
            if (!e.value) return;
            $.ajax({
                url: '<?= site_url('admin/email/marketing_emails/delete/id/'); ?>' + id,
                type: 'DELETE',
                success: function(data, status) {
                    if (data == -1) {
                        swal("Not Allowed!", "You have no permission.", "warning")
                    } else {
                        swal("Success!", "The email has been deleted.", "success")
                        $("#" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error!", "Unable to delete the email.", "error")
                }
            });
        });
    }

    //Toggles email marketing subscription
    function toggle_subscription(id, row) {
        $.ajax({
            url: '<?= site_url('admin/email/marketing_emails/toggle/subscription/id/'); ?>' + id,
            type: 'GET',
            success: function(data, status) {
                if (data == 0) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "No";
                    toastr.success("", "Subscription updated.");
                } else if (data == 1) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Yes";
                    toastr.success("", "Subscription updated.");
                } else if (data == -1) {
                    toastr.warning("", "You have no permission.");
                }
            },
            error: function(xhr, status, error) {
                toastr.error("", "Unable to update status.");
            }
        });
    }

    var DatatablesDataSourceAjaxServer = {
        init: function() {
            $("#m_table_1").DataTable({
                responsive: !0,
                dom: '<"top"lfp>rt<"bottom"ip><"clear">',
                rowId: "id",
                searchDelay: 500,
                processing: !0,
                serverSide: !1,
                ajax: "<?= site_url('admin/email/marketing_emails/get') ?>",
                order: [
                    [0, 'desc']
                ],
                columns: [{
                    data: "email"
                }, {
                    data: "is_subscribed"
                }, {
                    data: "Actions"
                }],
                columnDefs: [{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        return '<button onclick=editEmail("' + e['id'] + '","' + e['email'] + '") data-toggle="modal" data-target="#modal_edit_email" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></button>' +
                            '<a onclick=deleteEmail("' + e['id'] + '","' + e['email'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
                    }
                }, {
                    targets: 1,
                    render: function(a, t, e, n) {
                        var s = {
                            1: {
                                title: "Yes",
                                class: " m-badge--success"
                            },
                            0: {
                                title: "No",
                                class: " m-badge--danger"
                            }
                        };
                        return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle_subscription(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
                    }
                }]
            })
        }
    }

    jQuery(document).ready(function() {
        DatatablesDataSourceAjaxServer.init()

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
    $("#submenu-marketing-email").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>