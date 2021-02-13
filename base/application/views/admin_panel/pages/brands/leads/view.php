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
		<div class="m-portlet__body">

			<!-- Notifications -->
			<?php if ($this->session->flashdata('user_create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The brand user has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('user_create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the brand user.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('brand_create_success') === 0) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The brand has been created successfuly.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('brand_create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the brand.
					</div>
				</div>
			<?php endif ?>

			<!-- Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Brand Name</th>
						<th>Email Address</th>
						<th>Phone</th>
						<th>Date Requested</th>
						<th width=150>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
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
	// delete the entry
	function deleteEntry(id, brandname) {
		var brandname = brandname.replace(/%20/g, ' ');
		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the entry with brand: \"" + brandname + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brands/leads/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else if (data == 1) {
						swal("Success!", "The entry has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the entry.", "error")
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
				ajax: "<?= site_url("admin/brands/leads/get"); ?>",
				columns: [{
					data: "#"
				}, {
					data: "name"
				}, {
					data: "brandname"
				}, {
					data: "email"
				}, {
					data: "phone"
				}, {
					data: "date_created"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
						targets: -1,
						title: "Actions",
						orderable: !1,
						render: function(a, t, e, n) {
							var brandname = e['brandname'].replace(/ /g, '%20');
							return '<a href="<?= site_url() ?>admin/brands/leads/id/' + e['id'] + '/action/create/brand" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Create Brand"><i class="la la-building"></i></a>' +
								'<a href="<?= site_url() ?>admin/brands/leads/id/' + e['id'] + '/action/create/user" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Create Brand User"><i class="la la-user-plus"></i></a>' +
								'<a onclick=deleteEntry("' + e['id'] + '","' + brandname + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						}
					}, {
						targets: 5,
						render: function(a, t, e, n) {
							return new Date(e['date_created']).toLocaleString();
						}
					},
					{
						targets: 4,
						render: function(a, t, e, n) {
							// convert phone number to US format
							return e['phone'].replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
						}
					},
					{
						targets: 0,
						render: function(a, t, e, n) {
							return n['row'] + 1;
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
	$("#menu-sales").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#leads").addClass("m-menu__item  m-menu__item--active");
</script>