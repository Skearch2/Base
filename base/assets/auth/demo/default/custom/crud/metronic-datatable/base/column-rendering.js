var DatatableColumnRenderingDemo= {
    init:function() {
        var t;
        t=$(".m_datatable").mDatatable( {
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
                input: $("#generalSearch"), delay: 400
            }
            , rows: {
                callback:function(t, e, a) {}
            }
            , columns:[ {
                field:"RecordID", title:"#", sortable:!1, width:40, textAlign:"center", selector: {
                    class: "m-checkbox--solid m-checkbox--brand"
                }
            }
            , {
                width:200, field:"CompanyAgent", title:"Agent", template:function(t) {
                    var e=mUtil.getRandomInt(1, 14);
                    if(e>8)output='<div class="m-card-user m-card-user--sm">\t\t\t\t\t\t\t\t<div class="m-card-user__pic">\t\t\t\t\t\t\t\t\t<img src="https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/assets/app/media/img/users/100_'+e+'.jpg" class="m--img-rounded m--marginless" alt="photo">\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t<div class="m-card-user__details">\t\t\t\t\t\t\t\t\t<span class="m-card-user__name">'+t.CompanyAgent+'</span>\t\t\t\t\t\t\t\t\t<a href="" class="m-card-user__email m-link">'+t.CompanyName+"</a>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>";
                    else {
                        var a=mUtil.getRandomInt(0, 7);
                        output='<div class="m-card-user m-card-user--sm">\t\t\t\t\t\t\t\t<div class="m-card-user__pic">\t\t\t\t\t\t\t\t\t<div class="m-card-user__no-photo m--bg-fill-'+["success", "brand", "danger", "accent", "warning", "metal", "primary", "info"][a]+'"><span>'+t.CompanyAgent.substring(0, 1)+'</span></div>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t<div class="m-card-user__details">\t\t\t\t\t\t\t\t\t<span class="m-card-user__name">'+t.CompanyAgent+'</span>\t\t\t\t\t\t\t\t\t<a href="" class="m-card-user__email m-link">'+t.CompanyName+"</a>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>"
                    }
                    return output
                }
            }
            , {
                field:"ShipCountry", title:"Ship Country", width:150, template:function(t) {
                    return t.ShipCountry+" - "+t.ShipCity
                }
            }
            , {
                field: "ShipAddress", title: "Ship Address", width: 200
            }
            , {
                field:"CompanyEmail", title:"Email", width:150, template:function(t) {
                    return'<a class="m-link" href="mailto:'+t.CompanyEmail+'">'+t.CompanyEmail+"</a>"
                }
            }
            , {
                field:"Status", title:"Status", template:function(t) {
                    var e= {
                        1: {
                            title: "Pending", class: "m-badge--brand"
                        }
                        , 2: {
                            title: "Delivered", class: " m-badge--metal"
                        }
                        , 3: {
                            title: "Canceled", class: " m-badge--primary"
                        }
                        , 4: {
                            title: "Success", class: " m-badge--success"
                        }
                        , 5: {
                            title: "Info", class: " m-badge--info"
                        }
                        , 6: {
                            title: "Danger", class: " m-badge--danger"
                        }
                        , 7: {
                            title: "Warning", class: " m-badge--warning"
                        }
                    }
                    ;
                    return'<span class="m-badge '+e[t.Status].class+' m-badge--wide">'+e[t.Status].title+"</span>"
                }
            }
            , {
                field:"Type", title:"Type", template:function(t) {
                    var e= {
                        1: {
                            title: "Online", state: "danger"
                        }
                        , 2: {
                            title: "Retail", state: "primary"
                        }
                        , 3: {
                            title: "Direct", state: "accent"
                        }
                    }
                    ;
                    return'<span class="m-badge m-badge--'+e[t.Type].state+' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-'+e[t.Type].state+'">'+e[t.Type].title+"</span>"
                }
            }
            , {
                field:"Actions", width:110, title:"Actions", sortable:!1, overflow:"visible", template:function(t, e, a) {
                    return'\t\t\t\t\t\t<div class="dropdown '+(a.getPageSize()-e<=4?"dropup": "")+'">\t\t\t\t\t\t\t<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                <i class="la la-ellipsis-h"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
                }
            }
            ]
        }
        ),
        $("#m_form_status").on("change", function() {
            t.search($(this).val(), "Status")
        }
        ),
        $("#m_form_type").on("change", function() {
            t.search($(this).val(), "Type")
        }
        ),
        $("#m_form_status, #m_form_type").selectpicker()
    }
}

;
jQuery(document).ready(function() {
    DatatableColumnRenderingDemo.init()
}

);
