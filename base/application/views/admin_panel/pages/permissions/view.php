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
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/permission/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Add Permission</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The permission has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update the permission.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Description</th>
						<th>Key</th>
						<th width=150>Actions</th>
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

<!--begin::Page Scripts -->

<script>
	// Deletes permission
	function deletePermission(id, description) {
		// escape characters
		description = description.replace(/%20/g, " ");

		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the permission: \"" + description + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/permission/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else {
						swal("Success!", "The permission has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the permission.", "error")
				}
			});
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
				rowId: "id",
				paging: 0,
				ajax: "<?= site_url("admin/permissions/get"); ?>",
				columns: [{
					data: "name"
				}, {
					data: "key"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						return '<a href="<?= site_url() . "admin/permission/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=deletePermission("' + e['id'] + '","' + escape(e['name']) + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});

	$("#menu-permissions").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>