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
						<?= $title ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<a onclick="clearLogs()" href="javascript:void(0)" class="btn btn-danger m-btn m-btn--icon m-btn--pill">
						<span>
							<i class="la la-trash"></i>
							<span>Clear logs</span>
						</span>
					</a>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('clear_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The logs has been cleared.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('clear_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to clear logs or no logs to delete.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Type</th>
						<th>Subject</th>
						<th>Date Sent</th>
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
	// promtp for clear email logs
	function clearLogs() {
		swal({
			title: "Clear Logs",
			text: "Are you sure you want to clear email logs of this user?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Clear All",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			window.location.replace("<?= site_url('admin/email/logs/clear/user/id/') . $user_id ?>");

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
				ajax: "<?= site_url('admin/email/logs/get/user/id/') . $user_id ?>",
				order: [
					[2, 'desc']
				],
				columns: [{
					data: "type"
				}, {
					data: "subject"
				}, {
					data: "date_sent"
				}],
				columnDefs: [{
					targets: 1,
					render: function(a, t, e, n) {
						return '<a href="<?= site_url() . "admin/email/log/view/id/" ?>' + e['id'] + '" title="View">' + e['subject'] + '</a>'
					}
				}, {
					targets: 0,
					render: function(a, t, e, n) {
						return e['type'].toLowerCase().replace(/\b[a-z]/g, function(letter) {
							return letter.toUpperCase();
						});
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});

	$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>