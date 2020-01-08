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
						<?= $title; ?>
					</h3>
				</div>
			</div>
			
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<span id="progressinfo">10%</span>
					</li>
					<li class="m-portlet__nav-item">
						<a href="#" onclick="loadframe();" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
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
						<th width="5%" >HTTP Status</th>
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

/* Delete Adlink */
function deleteAdlink(id, title) {
  var title = title.replace(/%20/g, ' ');
  var result = confirm("Are you sure you want delete listing \"" + title + "\"?");
  if(result) {
  $.ajax({
    url: '<?= site_url(); ?>/admin/categories/delete_result_listing/' + id,
    type: 'DELETE',
    success: function(result) {
        $("#" + id).fadeOut("slow");
		//$('#m_table_1').DataTable().ajax.reload(null, false);
    }
    });
  }
}

/* Disable/Enable adlink*/
function toggle(id, row) {
	$.ajax({
    url: '<?= site_url(); ?>/admin/categories/toggle_result/' + id,
    type: 'GET',
    success: function(status) {
			if (status == 0) {
      	        document.getElementById("tablerow"+row).className = "m-badge m-badge--danger m-badge--wide";
				document.getElementById("tablerow"+row).innerHTML = "Off";
			}
			else {
				document.getElementById("tablerow"+row).className = "m-badge m-badge--success m-badge--wide";
				document.getElementById("tablerow"+row).innerHTML = "Active";
			}
    },
		error: function(err) {
        alert("Error toggle Ad-link");
      }
    });
}

var DatatablesDataSourceAjaxServer= {
    init:function() {
        $("#m_table_1").DataTable({
            responsive:!0, dom:'<"top"lfp>rt<"bottom"ip><"clear">', rowId: "id", order: [[ 1, 'asc' ]], searchDelay:500, lengthMenu:[[50,100,-1],[50,100,"ALL"]], processing:0, serverSide:!1, ajax:"<?= site_url(); ?>/admin/linkchecker/get_bad_urls", columns:[{
				data: "id"
            }
            , {
                data: "title"
            }
            , {
                data: "http_status_code"
            }
            , {
                data: "code_defination"
            }
            , {
                data: "last_status_check"
            }
            , {
                data: "enabled"
            }
						, {
                data: "Actions"
            }
            ], columnDefs:[
                    {
                        targets:-1, title:"Actions", orderable:!1, render:function(a, t, e, n) {
                            var title = e['title'].replace(/ /g, '%20');
                            var row = (n.row).toString().slice(-1);
                            return '<a href="<?php echo site_url()."admin/categories/update_result/"?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>'
                            +     '<a onclick=deleteAdlink("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
                        }
                    },
                    {
						targets:1, render:function(a, t, e, n) {
								return '<a href="'+ e.www + '" target="_blank" >' + e.title + '</a></a>';

						}
					},
                    {
						targets:3, render:function(a, t, e, n) {
							if(e['http_status_code'] == 0)
								return "Bad link or request timeout";
							else if(e['http_status_code'] < 200)
								return "Informational response";
							else if(e['http_status_code'] < 300)
								return "Successful";
							else if(e['http_status_code'] < 400)
								return "Redirection";
							else if(e['http_status_code'] < 500)
								return "Client error";
							else if(e['http_status_code'] >= 500)
								return "Server error";
							else
								return "Unable to get status";

						}
					},
                    {
                        targets:5, render:function(a, t, e, n) {
                            var s= {
                                2: {
                                        title: "Pending", class: "m-badge--brand"
                                }
                                , 1: {

                                        title: "Active", class: " m-badge--success"
                                }
                                , 0: {
                                        title: "Off", class: " m-badge--danger"
                                }
                            };
                            return void 0===s[a]?a:'<span style="cursor: pointer;" id= tablerow' + n['row'] +' onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge '+s[a].class+' m-badge--wide">'+s[a].title+'</span>'
                        }
                    }
                ]
            }
        )
    }
}

;
jQuery(document).ready(function() {
    DatatablesDataSourceAjaxServer.init();
}

);
</script>
