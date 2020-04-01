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
<style>
    #progressInfo {
        width: 0%;
        height: 30px;
        background-color: #4CAF50;
        text-align: center;
        line-height: 30px;
        color: white;
    }
</style>

<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <?= $title; ?>
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <span style="margin:5px">Progress:</span>
                    <li style="width:100px" class="m-portlet__nav-item">
                        <span id="progressInfo">0%</span>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="#" onclick="runLinkChecker()" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>Run Linkchecker</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="20%">Title</th>
                        <th width="5%">HTTP Status</th>
                        <th>Status Defination</th>
                        <th width="15%">Last Checked</th>
                        <th width="5%">Enabled</th>
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
    $("#smenu_lcheck").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>

<script>
    function runLinkChecker() {
        $.ajax({
            url: '<?= site_url(); ?>admin/linkchecker/update_urls_status/',
            type: 'GET',
            success: function(result) {

            }
        });
    }

    /* Removes link from the link checker list */
    function removeFromList(id, link) {

        var link = link.replace(/%20/g, ' ');
        swal({
            title: "Are you sure?",
            text: "Are you sure you want remove the link: \"" + link + "\"?",
            type: "warning",
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Yes, remove it!",
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
            confirmButtonText: "Yes, delete it!",
            showCancelButton: true,
            timer: 5000
        }).then(function(e) {
            if (!e.value) return;
            $.ajax({
                url: '<?= site_url('admin/categories/delete_result_listing/'); ?>' + id,
                type: 'DELETE',
                success: function(data, status) {
                    if (data == -1) {
                        swal("Not Allowed!", "You have no permission.", "warning")
                    } else {
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
            url: '<?= site_url(); ?>admin/categories/toggle_result/' + id,
            type: 'GET',
            success: function(status) {
                if (status == 0) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Off";
                } else if (status == 1) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Active";
                }
                // if the user has no access to toggle link status
                else if (data == -1) {
                    toastr.warning("", "You have no permission.");
                }
            },
            error: function(xhr, status, error) {
                alert("Error toggle link status");
            }
        });
    }

    var DatatablesDataSourceAjaxServer = {
        init: function() {
            $("#m_table_1").DataTable({
                responsive: !0,
                dom: '<"top"lfp>rt<"bottom"ip><"clear">',
                rowId: "id",
                order: [
                    [1, 'asc']
                ],
                searchDelay: 500,
                lengthMenu: [
                    [50, 100, -1],
                    [50, 100, "ALL"]
                ],
                processing: 0,
                serverSide: !1,
                ajax: "<?= site_url(); ?>admin/linkchecker/get",
                columns: [{
                    data: "id"
                }, {
                    data: "title"
                }, {
                    data: "http_status_code"
                }, {
                    data: "code_defination"
                }, {
                    data: "last_status_check"
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
                            return '<a href="<?= site_url() . "admin/categories/update_result/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit link"><i class="la la-edit"></i></a>' +
                                '<a onclick=removeFromList("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Remove from list"><i style="color:RED" class="la la-remove"></i></a>' +
                                '<a onclick=deleteLink("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete link"><i style="color:RED" class="la la-trash"></i></a>'
                        }
                    },
                    {
                        targets: 1,
                        render: function(a, t, e, n) {
                            return '<a href="' + e.www + '" target="_blank" >' + e.title + '</a></a>';

                        }
                    },
                    {
                        targets: 3,
                        render: function(a, t, e, n) {
                            if (e['http_status_code'] == 0)
                                return "Bad link or request timeout";
                            else if (e['http_status_code'] < 200)
                                return "Informational response";
                            else if (e['http_status_code'] < 300)
                                return "Successful";
                            else if (e['http_status_code'] < 400)
                                return "Redirection";
                            else if (e['http_status_code'] < 500)
                                return "Client error";
                            else if (e['http_status_code'] >= 500)
                                return "Server error";
                            else
                                return "Unable to get status";

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

    ;
    jQuery(document).ready(function() {
            DatatablesDataSourceAjaxServer.init();
        }

    );
</script>

<script>
    $("#menu-linkchecker").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>