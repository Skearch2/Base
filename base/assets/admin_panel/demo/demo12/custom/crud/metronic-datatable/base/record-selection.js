var DatatableRecordSelectionDemo = function() {
    var t = {
        data: {
            type: "remote",
            source: {
                read: {
                    url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/default.php"
                }
            },
            pageSize: 10,
            serverPaging: !0,
            serverFiltering: !0,
            serverSorting: !0
        },
        layout: {
            theme: "default",
            class: "",
            scroll: !0,
            height: 550,
            footer: !1
        },
        sortable: !0,
        pagination: !0,
        columns: [{
            field: "RecordID",
            title: "#",
            sortable: !1,
            width: 40,
            textAlign: "center",
            selector: {
                class: "m-checkbox--solid m-checkbox--brand"
            }
        }, {
            field: "ID",
            title: "ID",
            width: 40,
            template: "{{RecordID}}"
        }, {
            field: "ShipCountry",
            title: "Ship Country",
            width: 150,
            template: function(t) {
                return t.ShipCountry + " - " + t.ShipCity
            }
        }, {
            field: "ShipCity",
            title: "Ship City"
        }, {
            field: "Currency",
            title: "Currency",
            width: 100
        }, {
            field: "ShipDate",
            title: "Ship Date"
        }, {
            field: "Latitude",
            title: "Latitude"
        }, {
            field: "Status",
            title: "Status",
            template: function(t) {
                var e = {
                    1: {
                        title: "Pending",
                        class: "m-badge--brand"
                    },
                    2: {
                        title: "Delivered",
                        class: " m-badge--metal"
                    },
                    3: {
                        title: "Canceled",
                        class: " m-badge--primary"
                    },
                    4: {
                        title: "Success",
                        class: " m-badge--success"
                    },
                    5: {
                        title: "Info",
                        class: " m-badge--info"
                    },
                    6: {
                        title: "Danger",
                        class: " m-badge--danger"
                    },
                    7: {
                        title: "Warning",
                        class: " m-badge--warning"
                    }
                };
                return '<span class="m-badge ' + e[t.Status].class + ' m-badge--wide">' + e[t.Status].title + "</span>"
            }
        }, {
            field: "Type",
            title: "Type",
            template: function(t) {
                var e = {
                    1: {
                        title: "Online",
                        state: "danger"
                    },
                    2: {
                        title: "Retail",
                        state: "primary"
                    },
                    3: {
                        title: "Direct",
                        state: "accent"
                    }
                };
                return '<span class="m-badge m-badge--' + e[t.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + e[t.Type].state + '">' + e[t.Type].title + "</span>"
            }
        }, {
            field: "Actions",
            width: 110,
            title: "Actions",
            sortable: !1,
            overflow: "visible",
            template: function(t, e, a) {
                return '\t\t\t\t\t\t<div class="dropdown ' + (a.getPageSize() - e <= 4 ? "dropup" : "") + '">\t\t\t\t\t\t\t<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                <i class="la la-ellipsis-h"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
            }
        }]
    };
    return {
        init: function() {
            ! function() {
                t.search = {
                    input: $("#generalSearch")
                };
                var e = $("#local_record_selection").mDatatable(t);
                $("#m_form_status").on("change", function() {
                    e.search($(this).val().toLowerCase(), "Status")
                }), $("#m_form_type").on("change", function() {
                    e.search($(this).val().toLowerCase(), "Type")
                }), $("#m_form_status,#m_form_type").selectpicker(), e.on("m-datatable--on-check m-datatable--on-uncheck m-datatable--on-layout-updated", function(t) {
                    var a = e.rows(".m-datatable__row--active").nodes().length;
                    $("#m_datatable_selected_number").html(a), a > 0 ? $("#m_datatable_group_action_form").collapse("show") : $("#m_datatable_group_action_form").collapse("hide")
                }), $("#m_modal_fetch_id").on("show.bs.modal", function(t) {
                    for (var a = e.rows(".m-datatable__row--active").nodes().find('.m-checkbox--single > [type="checkbox"]').map(function(t, e) {
                            return $(e).val()
                        }), n = document.createDocumentFragment(), l = 0; l < a.length; l++) {
                        var i = document.createElement("li");
                        i.setAttribute("data-id", a[l]), i.innerHTML = "Selected record ID: " + a[l], n.appendChild(i)
                    }
                    $(t.target).find(".m_datatable_selected_ids").append(n)
                }).on("hide.bs.modal", function(t) {
                    $(t.target).find(".m_datatable_selected_ids").empty()
                })
            }(),
            function() {
                t.extensions = {
                    checkbox: {}
                }, t.search = {
                    input: $("#generalSearch1")
                };
                var e = $("#server_record_selection").mDatatable(t);
                $("#m_form_status1").on("change", function() {
                    e.search($(this).val().toLowerCase(), "Status")
                }), $("#m_form_type1").on("change", function() {
                    e.search($(this).val().toLowerCase(), "Type")
                }), $("#m_form_status1,#m_form_type1").selectpicker(), e.on("m-datatable--on-click-checkbox m-datatable--on-layout-updated", function(t) {
                    var a = e.checkbox().getSelectedId().length;
                    $("#m_datatable_selected_number1").html(a), a > 0 ? $("#m_datatable_group_action_form1").collapse("show") : $("#m_datatable_group_action_form1").collapse("hide")
                }), $("#m_modal_fetch_id_server").on("show.bs.modal", function(t) {
                    for (var a = e.checkbox().getSelectedId(), n = document.createDocumentFragment(), l = 0; l < a.length; l++) {
                        var i = document.createElement("li");
                        i.setAttribute("data-id", a[l]), i.innerHTML = "Selected record ID: " + a[l], n.appendChild(i)
                    }
                    $(t.target).find(".m_datatable_selected_ids").append(n)
                }).on("hide.bs.modal", function(t) {
                    $(t.target).find(".m_datatable_selected_ids").empty()
                })
            }()
        }
    }
}();
jQuery(document).ready(function() {
    DatatableRecordSelectionDemo.init()
});
