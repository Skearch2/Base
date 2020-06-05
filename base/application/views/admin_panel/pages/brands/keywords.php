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
		</div>

		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Keyword</th>
						<th>URL</th>
						<th>Brand</th>
						<th>Status</th>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>
<style>
	[role=button] {
		cursor: pointer
	}
</style>

<script>
	// Approve keywords
	function approveKeyword(id, keyword) {
		var keyword = keyword.replace(/%20/g, ' ');

		swal({
			title: "Are you sure?",
			text: "Are you sure you want approve the keyword: \"" + keyword + "\"?",
			type: "info",
			confirmButtonClass: "btn btn-success",
			confirmButtonText: "Approve",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/keywords/approve/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to approve keyword.", "error")
					} else {
						swal("Success!", "The keyword has been approved.", "success")
						$('#m_table_1').DataTable().ajax.reload(null, false);
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	// Delete keywords
	function deleteKeyword(id, keyword) {
		var keyword = keyword.replace(/%20/g, ' ');

		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the keyword: \"" + keyword + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/keywords/delete/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to delete keyword.", "error")
					} else {
						swal("Success!", "The keyword has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	//Toggles keywords status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/brands/keywords/toggle/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Inactive";
					toastr.success("", "Status updated.");
				} else if (data == 1) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Active";
					toastr.success("", "Status updated.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to process request.");
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
				ajax: "<?= site_url("admin/brands/keywords/get"); ?>",
				columns: [{
					data: "keywords"
				}, {
					data: "url"
				}, {
					data: "brand"
				}, {
					data: "active"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
						targets: -1,
						title: "Actions",
						orderable: !1,
						render: function(a, t, e, n) {
							var keywords = e['keywords'].replace(/ /g, '%20');
							return '<a onclick=deleteKeyword("' + e['id'] + '","' + keywords + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						}
					}, {
						targets: 3,
						render: function(a, t, e, n) {
							var s = {
								2: {
									title: "Pending Approval",
									class: "m-badge--warning"
								},
								1: {
									title: "Active",
									class: "m-badge--success"
								},
								0: {
									title: "Inactive",
									class: "m-badge--danger"
								}
							};
							if (e['approved'] == 0) {
								var keywords = e['keywords'].replace(/ /g, '%20');
								return '<span id= tablerow' + n['row'] + ' title="Approve" onclick=approveKeyword("' + e['id'] + '","' + keywords + '") class="m-badge ' + s[2].class + ' m-badge--wide" style="cursor:pointer">' + s[2].title + '</span>'
							} else {
								return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
							}
						}
					},
					{
						targets: 1,
						render: function(a, t, e, n) {
							return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
						}
					}
				]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});
</script>


<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-keywords").addClass("m-menu__item  m-menu__item--active");
</script>