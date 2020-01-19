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
						<th>ID</th>
						<th>Name</th>
						<th>Brand Name</th>
						<th>Email Address</th>
						<th>Phone</th>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>
<style>
	[role=button] {
		cursor: pointer
	}
</style>
<script>
	function deleteEntry(id) {
		var result = confirm("Are you sure you want delete this entry?");
		if (result) {
			$.ajax({
				url: "<?= site_url("admin/brands/brandleads/delete/"); ?>" + id,
				type: 'DELETE',
				success: function(result) {
					location.reload();
				},
				error: function(xhr, status, error) {
					console.log("Unable to delete entry!");
				}
			});
		}
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				ajax: "<?= site_url("admin/brands/brandleads/get"); ?>",
				columns: [{
					data: "id"
				}, {
					data: "name"
				}, {
					data: "brandname"
				}, {
					data: "email"
				}, {
					data: "phone"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						return '<a onclick=deleteEntry("' + e['id'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>'
					}
				}]
			})
		}
	}

	;
	jQuery(document).ready(function() {
			DatatablesDataSourceAjaxServer.init()
		}

	);
</script>


<script>
	$("#smenu_user").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>