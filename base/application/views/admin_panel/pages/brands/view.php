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
						<a href="<?= site_url("admin/brand/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Add Brand</span>
							</span>
						</a>
				</ul>
			</div>
		</div>

		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Brand Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!--end::Modal-->

		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The brand has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the brand.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The brand information has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update brand information.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Brand ID</th>
						<th>Brand</th>
						<th>Organization</th>
						<th>Members</th>
						<th>Payments</th>
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

<script>
	// Deletes brand
	function deleteBrand(id, brand) {
		var brand = brand.replace(/%20/g, ' ');
		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the brand: \"" + brand + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/brand/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else {
						swal("Success!", "The brand has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the brand.", "error")
				}
			});
		});
	}

	//Shows brand details
	function showBrandDetails(id) {
		$.ajax({
			url: '<?= site_url('admin/brand/get/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				$("div.modal-body").html(
					"<p>Brand: " + data.brand + " </p>\
					<p>Organization: " + data.organization + " </p>\
					<p>Street Address: " + data.address1 + " </p>\
					<p>Apt/Unit/Suite: " + data.address2 + " </p>\
					<p>City: " + data.city + " </p>\
					<p>State: " + data.state + " </p>\
					<p>Country: " + data.country + " </p>\
					<p>Zipcode: " + data.zipcode + " </p>\
					<p>Members: " + data.members + " </p>\
					<p>Date Created: " + new Date((data.date_created)).toLocaleString() + " </p>\
					<p>Note: " + data.note + " </p>"
				)
			},
			error: function(xhr, status, error) {
				$("div.modal-body").html(
					"<div class='m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger' role='alert'>\
						<div class='m-alert__icon'>\
							<i class='la la-times'></i>\
						</div>\
						<div class='m-alert__text'>\
							<strong>Error!</strong> Unable to get brand details.\
						</div>\
					</div>"
				)
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
				ajax: "<?= site_url("admin/brands/get"); ?>",
				columns: [{
					data: "id"
				}, {
					data: "brand"
				}, {
					data: "organization"
				}, {
					data: "members"
				}, {
					data: "payments"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
						targets: -1,
						title: "Actions",
						orderable: !1,
						render: function(a, t, e, n) {
							var brand = e['brand'].replace(/ /g, '%20');
							return '<a onclick=showBrandDetails("' + e['id'] + '") data-toggle="modal" data-target="#m_modal_2" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View Details"><i class="la la-search-plus"></i></a>' +
								'<a href="<?= site_url() . "admin/viewas/brand/id/" ?>' + e['id'] + '" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View as Brand"><i class="la la-eye"></i></a>' +
								'<a href="<?= site_url() . "admin/brands/ads/brand/id/" ?>' + e['id'] + '/show/library" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View Ads"><i class="flaticon-web"></i></a>' +
								'<a href="<?= site_url() . "admin/brands/vault/brand/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View Media Vault"><i class="la la-bank"></i></a>' +
								'<a href="<?= site_url() . "admin/brand/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=deleteBrand("' + e['id'] + '","' + brand + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						}
					},
					{
						targets: 3,
						title: "Members",
						render: function(a, t, e, n) {
							if (e['members'] > 0) {
								return '<a href="<?= site_url() . "admin/brand/members/id/" ?>' + e['id'] + '"  title="View members">' + e['members'] + '</a>'
							} else {
								return '0'
							}
						}
					},
					{
						targets: 4,
						title: "Payments",
						render: function(a, t, e, n) {
							if (e['payments'] > 0) {
								return '<a href="<?= site_url() . "admin/brand/payments/id/" ?>' + e['id'] + '" title="View payments">' + e['payments'] + '</a>'
							} else {
								return 'None'
							}
						}
					}
				]
			})
		}
	}

	jQuery(document).ready(function() {
			DatatablesDataSourceAjaxServer.init()
		}

	);
</script>

<!-- Sidemenu class -->
<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-brands").addClass("m-menu__item  m-menu__item--active");
</script>