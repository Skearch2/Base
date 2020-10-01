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
						<a href="<?= site_url("admin/user/create/group/id/{$group}"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-user-plus"></i>
								<span>Add User</span>
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
						<h5 class="modal-title" id="exampleModalLongTitle">User Details</h5>
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
						The user has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the user.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The user information has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update user information.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('permission_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The user permissions has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('permission_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update user permissions.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Username</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Email Address</th>
						<th>Gender</th>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
	//Shows user details
	function showUserDetails(id) {
		$.ajax({
			url: '<?= site_url('admin/user/get/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				$("div.modal-body").html(
					"<p>Username: " + data.username + " </p>\
					<p>Email Address: " + data.email + " </p>\
					<p>Name: " + data.firstname + " </p>\
					<p>Gender: " + data.gender + " </p>\
					<p>Age group: " + data.age_group + " </p>\
					<p>Phone: " + data.phone + " </p>\
					<p>Street Address: " + data.address1 + " </p>\
					<p>Apt/Unit/Suite: " + data.address2 + " </p>\
					<p>City: " + data.city + " </p>\
					<p>State: " + data.state + " </p>\
					<p>Country: " + data.country + " </p>\
					<p>Zipcode: " + data.zipcode + " </p>\
					<p>Date Created: " + new Date((data.created_on * 1000)).toLocaleString() + " </p>"
				)
			},
			error: function(xhr, status, error) {
				$("div.modal-body").html(
					"<div class='m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger' role='alert'>\
						<div class='m-alert__icon'>\
							<i class='la la-times'></i>\
						</div>\
						<div class='m-alert__text'>\
							<strong>Error!</strong> Unable to get user details.\
						</div>\
					</div>"
				)
			}
		});
	}

	// Deletes user
	function deleteUser(id, username) {
		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the user: \"" + username + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/user/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else {
						swal("Success!", "The user has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the user.", "error")
				}
			});
		});
	}


	// Resets user password
	function reset(id, username) {
		swal({
			title: "Are you sure?",
			text: "Are you sure you want reset password for the user: \"" + username + "\"?",
			type: "info",
			confirmButtonClass: "btn btn-info",
			confirmButtonText: "Yes, reset it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/user/reset/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else if (data == 0) {
						swal("Error!", "Unable to reset user password.", "error")
					} else {
						swal("Success!", "A password reset link has been sent to the user.", "success")
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to reset user password.", "error")
				}
			});
		});
	}

	//Toggles user active status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/user/toggle/id/'); ?>' + id,
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
					// if the user has no access to toggle user status
				} else if (data == -1) {
					toastr.warning("", "You have no permission.");
				}
				// if the user status being toggled is in admin group
				else if (data == -2) {
					toastr.warning("", "Admin status cannot be changed.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to change the status.");
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
				ajax: "<?= site_url("admin/users/get/group/id/$group"); ?>",
				columns: [{
					data: "username"
				}, {
					data: "lastname"
				}, {
					data: "firstname"
				}, {
					data: "email"
				}, {
					data: "gender"
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
						return '<a onclick=showUserDetails("' + e['id'] + '") data-toggle="modal" data-target="#m_modal_2" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-search-plus"></i></a>' +
							'<a onclick=reset("' + e['id'] + '","' + e['username'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Reset Password"><i class="la la-gear"></i></a>' +
							'<a href="<?= site_url() . "admin/user/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=deleteUser("' + e['id'] + '","' + e['username'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						var s = {
							2: {
								title: "Pending Activation",
								class: "m-badge--warning"
							},
							1: {
								title: "Active",
								class: "m-badge--success"
							},
							0: {
								title: "Inactive",
								class: " m-badge--danger"
							}
						};
						if (e['activation_selector'] !== null) return '<span id= tablerow' + n['row'] + ' class="m-badge ' + s[2].class + ' m-badge--wide">' + s[2].title + '</span>'
						else return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
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

<!-- Sidemenu class -->
<script>
	$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-users-brand_users").addClass("m-menu__item  m-menu__item--active");
</script>