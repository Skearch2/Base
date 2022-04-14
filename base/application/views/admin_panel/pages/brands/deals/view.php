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
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/brands/deals/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Create Deal Drop</span>
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
						The deal drop has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create deal drop.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The deal drop has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update deal drop.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Brand</th>
						<th>Title</th>
						<th>Description</th>
						<th>Start Date</th>
						<th>End Date</th>
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<style>
	[role=button] {
		cursor: pointer
	}
</style>

<!--begin::Page Scripts -->

<script>
	// Delete deal
	function deleteDeal(id, title) {
		var title = title.replace(/%20/g, ' ');
		swal({
			title: "Delete?",
			text: "Are you sure you want delete this deal drop: \"" + title + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/deals/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == 1) {
						swal("Success!", "The deal drop has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the deal drop.", "error")
				}
			});
		});
	}

	var datatable = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				dom: '<"top"lfp>rt<"bottom"ip><"clear">',
				rowId: "id",
				processing: !0,
				serverSide: !1,
				searching: !1,
				ajax: "<?= site_url("admin_panel/brands/deals/get"); ?>",
				columns: [{
					data: "id"
				}, {
					data: "brand"
				}, {
					data: "title"
				}, {
					data: "description"
				}, {
					data: "start_date"
				}, {
					data: "end_date"
				}, {
					data: "status"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						var title = e['title'].replace(/ /g, '%20');
						if (e['status'] == 'pending') {
							return '<a href="<?= site_url('admin/brands/deals/edit/id/') ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=deleteDeal("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						} else {
							return '<a onclick=deleteDeal("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						}
					}
				}, {
					targets: 0,
					orderable: !1
				}, {
					targets: 4,
					render: function(a, t, e, n) {
						return new Date(e['start_date']).toLocaleString();
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						return new Date(e['end_date']).toLocaleString();
					}
				}, {
					targets: 6,
					render: function(a, t, e, n) {
						var s = {
							"pending": {
								title: "Pending",
								state: "warning"
							},
							"running": {
								title: "Running",
								state: "success"
							},
							"completed": {
								title: "Completed",
								state: "danger"
							}
						};
						return void 0 === s[a] ? a : '<span class="m--font-bold m--font-' + s[a].state + '">' + s[a].title + "</span>"
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		datatable.init()
	});

	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-dealdrop").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>