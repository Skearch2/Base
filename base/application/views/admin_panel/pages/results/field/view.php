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
                        <?= $subTitle; ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="<?= site_url("admin/categories/create_subcategory"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-user-plus"></i>
                                <span>Add Item</span>
                            </span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item"></li>
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                <i class="la la-ellipsis-h m--font-brand"></i>
                            </a>
                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">Quick Actions</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                        <span class="m-nav__link-text">Create Post</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                        <span class="m-nav__link-text">Send Messages</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                        <span class="m-nav__link-text">Upload File</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__section">
                                                    <span class="m-nav__section-text">Useful Links</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-info"></i>
                                                        <span class="m-nav__link-text">FAQ</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                        <span class="m-nav__link-text">Support</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__separator m-nav__separator--fit m--hide">
                                                </li>
                                                <li class="m-nav__item m--hide">
                                                    <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Parent Umbrella</th>
                        <th>Adlinks</th>
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
                url: '<?= site_url('admin/categories/delete_subcategory/'); ?>' + id,
                type: 'DELETE',
                success: function(data, status) {
                    swal("Success!", "The field has been deleted.", "success")
                    $("#" + id).remove();
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
            url: '<?= site_url('admin/categories/toggle_subcategory/'); ?>' + id,
            type: 'GET',
            success: function(data, status) {
                if (data == 0) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Off";
                } else if (data == 1) {
                    document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
                    document.getElementById("tablerow" + row).innerHTML = "Active";
                }
                toastr.success("", "Status updated.");
            },
            error: function(xhr, status, error) {
                toastr.error("", "Unable to change the status.");
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
                processing: !0,
                serverSide: !1,
                ajax: "<?= site_url(); ?>/admin/categories/get_subcategory_list/<?= $categoryid; ?>/<?= $status; ?>",
                columns: [{
                    data: "title"
                }, {
                    data: "description_short"
                }, {
                    data: "parent_title"
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
                            return '<a href="<?= site_url() . "admin/categories/update_subcategory/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
                                '<a onclick=deleteField("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
                        }
                    },
                    {
                        targets: 3,
                        title: "Adlinks",
                        render: function(a, t, e, n) {
                            return e['totalResults'] + " " +
                                '<a href="<?= site_url() . "admin/categories/result_list/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-search-plus"></i></a>'

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
                            //return void 0===s[a]?a:'<span class="m-badge m-badge--'+s[a].state+' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-'+s[a].state+'">'+s[a].title+"</span>"
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
        DatatablesDataSourceAjaxServer.init()

    });

    $('#m_table_1 tbody').on('click', 'tablerow1', function() {
        $('#m_table_1').DataTable()
            .row($(this).parents('tr'))
            .remove()
            .draw();
    });
</script>

<!-- Sidemenu class -->
<script>
    $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
    $("#submenu-results-fields").addClass("m-menu__item  m-menu__item--active");
</script>