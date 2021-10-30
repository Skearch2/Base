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
    <div class="progress m-progress--sm" style="height:2px">
        <div class="progress-bar m--bg-primary" id="progress" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">

                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div id="priority-loader" class="m-loader m-loader--brand" style="width: 30px; display:none"></div>
                    </li>
                    <li class="m-portlet__nav-item">
                        <button onclick="runLinkChecker()" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="btn_linkchecker">
                            Run Linkchecker
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th width="20%">Link</th>
                        <th>HTTP Status Code</th>
                        <th>Status Type</th>
                        <th>Last Checked</th>
                        <th>Field</th>
                        <th>Enabled</th>
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');
?>

<script>
    function runLinkChecker() {
        $.ajax({
            url: '<?= site_url('admin/linkchecker/run'); ?>',
            type: 'GET',
            async: true,
            beforeSend: function(data, status) {
                $("#btn_linkchecker").removeClass().addClass("btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air m-loader m-loader--light m-loader--left").prop("disabled", true);
            },
            success: function(data, status) {
                if (data == -1) {
                    toastr.warning("", "You have no permission.")
                } else if (data == 1) {
                    toastr.success("", "Scan completed.")
                    $("#btn_linkchecker").removeClass().addClass("btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air").prop("disabled", false);
                    $('#m_table_1').fadeOut("slow");
                    $('#m_table_1').DataTable().ajax.reload(null, false);
                    $('#m_table_1').fadeIn("fast");
                } else if (data == 0) {
                    toastr.error("", "Some error occured!.")
                    $("#btn_linkchecker").removeClass().addClass("btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air").prop("disabled", false);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status == 500) {
                    toastr.error("", "Unable to run linkchecker.")
                    $("#btn_linkchecker").removeClass().addClass("btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air").prop("disabled", false);
                }
            }
        });
    }

    /* Removes link from the link checker list */
    function removeFromList(id, link) {
        var link = link.replace(/%20/g, ' ');
        swal({
            title: "Are you sure?",
            text: "Are you sure you want remove the link: \"" + link + "\"?",
            type: "info",
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Remove",
            showCancelButton: true,
            timer: 5000
        }).then(function(e) {
            if (!e.value) return;
            $.ajax({
                url: '<?= site_url('admin/linkchecker/remove/id/'); ?>' + id,
                type: 'UPDATE',
                success: function(data, status) {
                    if (data == -1) {
                        swal("Not Allowed!", "You have no permission.", "warning")
                    } else {
                        swal("Success!", "The link has been removed.", "success")
                        $("#" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error!", "Unable to remove the link.", "error")
                }
            });
        });
    }

    /* Deletes a Link */
    function deleteLink(id, link) {
        var link = link.replace(/%20/g, ' ');

        swal({
            title: "Are you sure?",
            text: "Are you sure you want delete the link: \"" + link + "\"?",
            type: "warning",
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Delete",
            showCancelButton: true,
            timer: 5000
        }).then(function(e) {
            if (!e.value) return;
            $.ajax({
                url: '<?= site_url('admin/results/link/delete/id/'); ?>' + id,
                type: 'DELETE',
                success: function(data, status) {
                    if (data == -1) {
                        swal("Not Allowed!", "You have no permission.", "warning")
                    } else if (data == 1) {
                        swal("Success!", "The link has been deleted.", "success")
                        $("#" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error!", "Unable to delete the link.", "error")
                }
            });
        });
    }

    /* Disable/Enable link*/
    function toggle(id, row) {
        $.ajax({
            url: '<?= site_url('admin/results/link/toggle/id/'); ?>' + id,
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
                toastr.error("", "Unable to update the status.");
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
                ajax: "<?= site_url(); ?>admin/linkchecker/get/links",
                columns: [{
                    data: "title"
                }, {
                    data: "http_status_code"
                }, {
                    data: "code_defination"
                }, {
                    data: "last_status_check"
                }, {
                    data: "field"
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
                            return '<a href="<?= site_url() . "admin/results/link/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit link"><i class="la la-edit"></i></a>' +
                                '<a onclick=removeFromList("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Remove from list"><i style="color:RED" class="la la-remove"></i></a>' +
                                '<a onclick=deleteLink("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete link"><i style="color:RED" class="la la-trash"></i></a>'
                        }
                    },
                    {
                        targets: 0,
                        render: function(a, t, e, n) {
                            return '<a href="' + e.www + '" target="_blank" >' + e.title + '</a>';

                        }
                    },
                    {
                        targets: 2,
                        render: function(a, t, e, n) {
                            if (e['http_status_code'] == 0)
                                return "Bad link or request timeout";
                            else if (e['http_status_code'] < 200)
                                return "Informational";
                            else if (e['http_status_code'] < 300)
                                return "Success";
                            else if (e['http_status_code'] < 400)
                                return "Redirection";
                            else if (e['http_status_code'] < 500)
                                return "Client Error";
                            else if (e['http_status_code'] >= 500)
                                return "Server Error";
                            else
                                return "Unable to get status";
                        }
                    }, {
                        targets: 4,
                        render: function(a, t, e, n) {
                            url = "<?= site_url('browse') ?>/" + e.umbrella + "/" + e.field
                            return '<a href="' + url + '" target="_blank" >' + e.field + '</a>';

                        }
                    },
                    {
                        targets: 5,
                        render: function(a, t, e, n) {
                            var s = {
                                2: {
                                    title: "Pending",
                                    class: "m-badge--brand"
                                },
                                1: {

                                    title: "Active",
                                    class: " m-badge--success"
                                },
                                0: {
                                    title: "Off",
                                    class: " m-badge--danger"
                                }
                            };
                            return void 0 === s[a] ? a : '<span style="cursor: pointer;" id= tablerow' + n['row'] + ' onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + '</span>'
                        }
                    }
                ]
            })
        }
    }

    jQuery(document).ready(function() {
        DatatablesDataSourceAjaxServer.init();
    });

    $("#menu-linkchecker").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>
<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>