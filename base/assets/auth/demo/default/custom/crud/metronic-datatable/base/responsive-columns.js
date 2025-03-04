var DatatableResponsiveColumnsDemo= {
    init:function() {
        $(".m_datatable").mDatatable( {
            data: {
                type:"remote", source: {
                    read: {
                        url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/default.php"
                    }
                }
                , pageSize:10, serverPaging:!0, serverFiltering:!0, serverSorting:!0
            }
            , layout: {
                theme: "default", class: "", scroll: !1, footer: !1
            }
            , sortable:!0, pagination:!0, search: {
                input: $("#generalSearch")
            }
            , columns:[ {
                field:"RecordID", title:"#", sortable:!1, width:40, textAlign:"center", selector: {
                    class: "m-checkbox--solid m-checkbox--brand"
                }
            }
            , {
                field: "OrderID", title: "Order ID", filterable: !1, width: 150
            }
            , {
                field:"ShipCity", title:"Ship City", responsive: {
                    visible: "lg"
                }
            }
            , {
                field:"Website", title:"Website", width:200, responsive: {
                    visible: "lg"
                }
            }
            , {
                field:"Department", title:"Department", responsive: {
                    visible: "lg"
                }
            }
            , {
                field:"ShipDate", title:"Ship Date", responsive: {
                    visible: "lg"
                }
            }
            , {
                field:"Actions", width:110, title:"Actions", sortable:!1, overflow:"visible", template:function(t, e, i) {
                    return'\t\t\t\t\t\t<div class="dropdown '+(i.getPageSize()-e<=4?"dropup": "")+'">\t\t\t\t\t\t\t<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                <i class="la la-ellipsis-h"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
                }
            }
            ]
        }
        )
    }
}

;
jQuery(document).ready(function() {
    DatatableResponsiveColumnsDemo.init()
}

);
