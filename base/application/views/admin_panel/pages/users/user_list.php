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
						<?= $heading; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/users/create_user"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-user-plus"></i>
								<span>Add User</span>
							</span>
						</a>
					<li class="m-portlet__nav-item"></li>
					<li class="m-portlet__nav-item">
						<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
							<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
								<i class="la la-ellipsis-h m--font-brand"></i>
							</a>
							<div class="m-dropdown__wrapper">
								<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
								<div class="m-dropdown__inner">
									<div class="m-dropdown__body">
										<div class="m-dropdown__content">
											<ul class="m-nav">
												<li class="m-nav__section m-nav__section--first">
													<span class="m-nav__section-text">Quick Actions</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-share"></i>
														<span class="m-nav__link-text">Create Post</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-chat-1"></i>
														<span class="m-nav__link-text">Send Messages</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-multimedia-2"></i>
														<span class="m-nav__link-text">Upload File</span>
													</a>
												</li>
												<li class="m-nav__section">
													<span class="m-nav__section-text">Useful Links</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-info"></i>
														<span class="m-nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-lifebuoy"></i>
														<span class="m-nav__link-text">Support</span>
													</a>
												</li>
												<li class="m-nav__separator m-nav__separator--fit m--hide">
												</li>
												<li class="m-nav__item m--hide">
													<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
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

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Username</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Email Address</th>
						<th>Gender</th>
						<th>Status</th>
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
	function showUserDetails(user) {

		$("div.modal-body").html(

			"<p>UserID:</p> " + user + " \
	<p>This is a test.</p> \
	<p>This is a test.</p>"




		);
	}

	function deleteUser(id, username) {
		var result = confirm("Are you sure you want delete user: \"" + username + "\"?");
		if (result) {
			$.ajax({
				url: '<?= site_url('admin/users/delete_user/'); ?>' + id,
				type: 'DELETE',
				success: function(result) {
					location.reload();
				}
			});
		}
	}

	/*
		Reset user password
		- Email reset link to the user
	*/
	function resetUserPassword(id, username) {
		var result = confirm("Are you sure you want reset password for user: \"" + username + "\"?");
		if (result) {
			$.ajax({
				url: '<?= site_url('admin/users/reset_user_password/'); ?>' + id,
				type: 'GET',
				success: function(result) {
					toastr.success("A password reset link has been sent to the  user.", "Success");
				},
				error: function(error) {
					toastr.error("Unable to reset user password.", "Error");
				}
			});
		}
	}

	/* Disable/Enable user*/
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/users/toggle_user_activation/'); ?>' + id,
			type: 'GET',
			success: function(status) {
				if (status == 0) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Inactive";
					document.getElementById("tablerow" + row).setAttribute("role", "button") = "Inactive";
				} else if (status == 1) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Active";
					document.getElementById("tablerow" + row).setAttribute("role", "button") = "Inactive";
				}

			}
		});
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				ajax: "<?= site_url("admin/users/get_user_list/$group"); ?>",
				columns: [{
					data: "id"
				}, {
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

							return '<a onclick="showUserDetails(' + e['id'] + ')" data-toggle="modal" data-target="#m_modal_2" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-search-plus"></i></a>' +
								'<a onclick=resetUserPassword("' + e['id'] + '","' + e['username'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Reset Password"><i class="la la-key"></i></a>' +
								'<a href="<?= site_url() . "admin/users/edit_user/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=deleteUser("' + e['id'] + '","' + e['username'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>'
						}
					}, {
						targets: 7,
						render: function(a, t, e, n) {
							var s = {
								1: {
									title: "Pending",
									class: "m-badge--brand"
								},
								2: {
									title: "Delivered",
									class: " m-badge--metal"
								},
								3: {
									title: "Member",
									class: " m-badge--primary"
								},
								4: {
									title: "Success",
									class: " m-badge--success",
								},
								5: {
									title: "Info",
									class: " m-badge--info"
								},
								6: {
									title: "Danger",
									class: " m-badge--danger"
								},
								7: {
									title: "Warning",
									class: " m-badge--warning"
								}
							};
							return void 0 === s[a] ? a : '<span class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + "</span>"
						}
					},
					{
						targets: 6,
						render: function(a, t, e, n) {
							var s = {
								2: {
									title: "Pending",
									class: "m-badge--brand"
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
							return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + '</span>'
						}
					}
				]
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