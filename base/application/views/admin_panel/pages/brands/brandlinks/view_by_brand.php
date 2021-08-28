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
						Brand: <?= $brand->brand ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/brands/brandlinks/create/brand_id/$brand->id"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Add BrandLink</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The BrandLink has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the BrandLink.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The BrandLink has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update BrandLink.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Keyword</th>
						<th>URL</th>
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
	function approveBrandlink(id, keyword) {
		var keyword = keyword.replace(/%20/g, ' ');

		swal({
			title: "Are you sure?",
			text: "Are you sure you want approve the BrandLink keyword: \"" + keyword + "\"?",
			type: "info",
			confirmButtonClass: "btn btn-success",
			confirmButtonText: "Approve",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/brandlinks/approve/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to approve BrandLink keyword.", "error")
					} else {
						swal("Success!", "The BrandLink keyword has been approved and set to active.", "success")
						$('#m_table_1').DataTable().ajax.reload(null, false);
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	// Delete Brandlink
	function deleteBrandlink(id, keyword) {
		var keyword = keyword.replace(/%20/g, ' ');

		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the BrandLink keyword: \"" + keyword + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/brandlinks/delete/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to delete BrandLink keyword.", "error")
					} else {
						swal("Success!", "The BrandLink keyword has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	//Toggles brandlink status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/brands/brandlinks/toggle/status/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Inactive";
					toastr.success("", "Status set to Inactive.");
				} else if (data == 1) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Active";
					toastr.success("", "Status set to Active.");
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
				ajax: "<?= site_url("admin/brands/brandlinks/get/brand_id/$brand->id"); ?>",
				columns: [{
					data: "#"
				}, {
					data: "keyword"
				}, {
					data: "url"
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
						var keyword = e['keyword'].replace(/ /g, '%20');
						return '<a href="<?= site_url() . "admin/brands/brandlinks/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=deleteBrandlink("' + e['id'] + '","' + keyword + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
					}
				}, {
					targets: 0,
					title: "#",
					render: function(a, t, e, n) {
						return n['row'] + 1;
					}
				}, {
					targets: 2,
					render: function(a, t, e, n) {
						return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
					}
				}, {
					targets: 3,
					render: function(a, t, e, n) {
						var s = {
							2: {
								title: "Approval Needed",
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
							var keyword = e['keyword'].replace(/ /g, '%20');
							return '<span id= tablerow' + n['row'] + ' title="Approve" onclick=approveBrandlink("' + e['id'] + '","' + keyword + '") class="m-badge ' + s[2].class + ' m-badge--wide" style="cursor:pointer">' + s[2].title + '</span>'
						} else {
							return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
						}
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});
</script>


<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-brands").addClass("m-menu__item  m-menu__item--active");
</script>