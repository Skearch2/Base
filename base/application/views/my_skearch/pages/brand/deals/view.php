<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header and menu
if (isset($viewas)) {
	$this->load->view('my_skearch/templates/viewas/header_menu');
} else {
	$this->load->view('my_skearch/templates/header_menu');
}

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>
<div class="m-content">
	<div class="m-portlet m-portlet--mobile">

		<div class="m-portlet__body" align="right">
			<a href="<?= site_url('myskearch/brand/deals/create') ?>" type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom">Create</a>
		</div>

		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The deal has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the deal.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The deal details has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update deal details.
					</div>
				</div>
			<?php endif ?>
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>ID</th>
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
</div>

<?php

// End page body
$this->load->view('my_skearch/templates/end_pagebody');

// Load footer
$this->load->view('my_skearch/templates/footer');

// End page section
$this->load->view('my_skearch/templates/end_page');

// Load quick sidebar
$this->load->view('my_skearch/templates/quick_sidebar');

// Load global JS files
$this->load->view('my_skearch/templates/js_global');
?>

<!-- Page Scripts -->
<script src="<?= site_url(ASSETS); ?>/my_skearch/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script>
	<?php if (isset($viewas)) : ?>
		var url = "<?= site_url("admin/viewas/brand/id/{$brand_id}/show/deals/action/get"); ?>"
	<?php else : ?>
		var url = "<?= site_url("myskearch/brand/deals/get"); ?>"
	<?php endif ?>

	// Delete deal
	function deleteDeal(id, title) {
		var title = title.replace(/%20/g, ' ');
		swal({
			title: "Delete?",
			text: "Are you sure you want delete this deal: \"" + title + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('myskearch/brand/deals/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == 1) {
						swal("Success!", "The deal has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the deal.", "error")
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
				ajax: url,
				columns: [{
					data: "id"
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
						<?php if ($is_primary_brand_user) : ?>
							return '<a href="<?= site_url('myskearch/brand/deals/edit/id/') ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=deleteDeal("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						<?php else : ?>
							return "-"
						<?php endif ?>
					}
				}, {
					targets: 0,
					orderable: !1
				}, {
					targets: 3,
					render: function(a, t, e, n) {
						return new Date(e['start_date']).toLocaleString();
					}
				}, {
					targets: 4,
					render: function(a, t, e, n) {
						return new Date(e['end_date']).toLocaleString();
					}
				}, {
					targets: 5,
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

	$(document).ready(function() {
		datatable.init()
	});
</script>

<?php
// Close body and html
$this->load->view('my_skearch/templates/close_html');
?>