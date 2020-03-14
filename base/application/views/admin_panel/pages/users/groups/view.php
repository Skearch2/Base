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
						User Groups
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/users/group/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-users"></i>
								<span>Add Group</span>
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
		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The group has been created or updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create or update the group.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Group ID</th>
						<th>Group Name</th>
						<th>Group Description</th>
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
	// Deletes group
	function deleteGroup(id, groupName) {
		// escape characters
		groupName = groupName.replace(/%20/g, " ");

		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete user group: \"" + groupName + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/users/group/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					swal("Success!", "The group has been deleted.", "success")
					$("#" + id).remove();
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the group.", "error")
				}
			});
		});
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				rowId: "id",
				ajax: "<?= site_url('admin/users/groups/get'); ?>",
				columns: [{
					data: "id"
				}, {
					data: "name"
				}, {
					data: "description"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						return '<a href="<?= site_url() . "admin/users/group/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=deleteGroup("' + e['id'] + '","' + escape(e['name']) + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
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
	$("#submenu-users-groups").addClass("m-menu__item  m-menu__item--active");
</script>