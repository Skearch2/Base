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
						<a href="<?= site_url("admin/tos/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Add Latest TOS</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>


		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">TOS/PP</h5>
						<button type="button" cl ass="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
						The TOS/PP has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create TOS/PP.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Date Created</th>
						<th width=150>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->

<script>
	// view TOS/PP text
	function view(id) {
		$.ajax({
			url: '<?= site_url('admin/tos/get/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				$("div.modal-body").html(
					"<p>" + data.content + "</p>"
				)
			},
			error: function(xhr, status, error) {
				$("div.modal-body").html(
					"<div class='m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger' role='alert'>\
						<div class='m-alert__icon'>\
							<i class='la la-times'></i>\
						</div>\
						<div class='m-alert__text'>\
							<strong>Error!</strong> Unable to get TOS/PP text.\
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
				dom: '<"top"lp>rt<"bottom"ip><"clear">',
				rowId: "id",
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				ajax: "<?= site_url("admin/tos/get"); ?>",
				columns: [{
					data: "date_created"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						return '<a onclick=view("' + e['id'] + '") data-toggle="modal" data-target="#m_modal_4" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-eye"></i></a>'
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});

	$("#menu-news").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-news-tos").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>