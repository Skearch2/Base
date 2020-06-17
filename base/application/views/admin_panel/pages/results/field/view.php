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
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <?= $heading ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="<?= site_url("admin/results/field/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>Add Field</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <?php if ($this->session->flashdata('update_success') === 1) : ?>
                <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        The field has been updated.
                    </div>
                </div>
            <?php elseif ($this->session->flashdata('update_success') === 0) : ?>
                <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        Unable to update the field.
                    </div>
                </div>
            <?php endif ?>

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Umbrella</th>
                        <th>Links</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Actions</th>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
    function deleteField(id, field) {
        var field = field.replace(/%20/g, ' ');

        swal({
            title: "Are you sure?",
            text: "Are you sure you want delete the field: \"" + field + "\"?",
            type: "warning",
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Yes, delete it!",
            showCancelButton: true,
            timer: 5000
        }).then(function(e) {
            if (!e.value) return;
            $.ajax({
                url: '<?= site_url('admin/results/field/delete/id/'); ?>' + id,
                type: 'DELETE',
                success: function(data, status) {
                    if (data == -1) {
                        swal("Not Allowed!", "You have no permission.", "warning")
                    } else {
                        swal("Success!", "The field has been deleted.", "success")
                        $("#" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error!", "Unable to delete the field.", "error")
                }
            });
        });
    }


    // Toggle field active status
    function toggle(id, row) {
        $.ajax({
            url: '<?= site_url('admin/results/field/toggle/id/'); ?>' + id,
            type: 'GET',
            success: function(data, status) {
                if (data == 0) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Off";
                    toastr.success("", "Status updated.");
                } else if (data == 1) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Active";
                    toastr.success("", "Status updated.");
                } else if (data == -1) {
                    toastr.warning("", "You have no permission.");
                }
            },
            error: function(xhr, status, error) {
                toastr.error("", "Unable to change the status.");
            }
        });
    }

    var DatatablesDataSourceAjaxServer = {
        init: function(url) {
            $("#m_table_1").DataTable({
                responsive: !0,
                dom: '<"top"lfp>rt<"bottom"ip><"clear">',
                rowId: "id",
                searchDelay: 500,
                processing: !0,
                serverSide: !1,
                ajax: url,
                columns: [{
                    data: "title"
                }, {
                    data: "description_short"
                }, {
                    data: "umbrella"
                }, {
                    data: "Adlinks"
                }, {
                    data: "featured"
                }, {
                    data: "enabled"
                }, {
                    data: "Actions"
                }],

                columnDefs: [{
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function(a, t, e, n) {
                            var title = e['title'].replace(/ /g, '%20');
                            var row = (n.row).toString().slice(-1);
                            return '<a href="<?= site_url() . "admin/results/field/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
                                '<a onclick=deleteField("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
                        }
                    },
                    {
                        targets: 3,
                        render: function(a, t, e, n) {
                            return '<a href="<?= site_url() . "admin/results/links/field/id/" ?>' + e['id'] + '" title="View">' + e['totalResults'] + '</a>'

                        }
                    }, {
                        targets: 4,
                        render: function(a, t, e, n) {
                            var s = {
                                0: {
                                    title: "No",
                                    state: "danger"
                                },
                                1: {
                                    title: "Yes",
                                    state: "accent"
                                }
                            };
                            return void 0 === s[a] ? a : '<span class="m--font-bold m--font-' + s[a].state + '">' + s[a].title + "</span>"
                        }
                    },
                    {
                        targets: 5,
                        render: function(a, t, e, n) {
                            var s = {
                                1: {
                                    title: "Active",
                                    class: " m-badge--success"
                                },
                                0: {
                                    title: "Off",
                                    class: " m-badge--danger"
                                }
                            };
                            return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
                        }
                    }
                ]
            })
        }
    }

    ;
    jQuery(document).ready(function() {
        var url

        <?php if (isset($umbrella_id)) : ?>
            url = "<?= site_url(); ?>admin/results/fields/get/umbrella/id/<?= $umbrella_id; ?>"
        <?php elseif (isset($status)) : ?>
            url = "<?= site_url(); ?>admin/results/fields/get/status/<?= $status; ?>"
        <?php endif ?>

        DatatablesDataSourceAjaxServer.init(url)

    });
</script>

<!-- Sidemenu class -->
<script>
    $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
    $("#submenu-results-fields").addClass("m-menu__item  m-menu__item--active");
</script>