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
	<div class="m-portlet m-portlet--responsive-mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="fa fa-shopping-bag m--font-brand"></i>
					</span>
					<h3 class="m-portlet__head-text m--font-brand">
						Brand: <?= ucwords("$brand->brand") ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The ad has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the ad.
					</div>
				</div>
			<?php endif ?>

			<!-- bootstrap modal where the image will appear -->
			<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>
						<div class="modal-body">
							<img id="imagepreview" style="display:block; max-width:600px; max-height:600px;">
						</div>
					</div>
				</div>
			</div>

			<!-- bootstrap modal where the video will appear -->
			<div class="modal fade" id="videomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>
						<div class="modal-body">
							<video controls autoplay id="videopreview">
								Unable to play video, incompatible browser.
							</video>
						</div>
					</div>
				</div>
			</div>

			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Link</th>
						<th>Thumbnail</th>
						<th>Note</th>
						<th>Date Submitted</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->

<script>
	// Show modal dialog to preview ads
	function view(src, isVideo = 0) {
		if (isVideo == 1) {
			$('#videopreview').attr('src', src);
			$('#videomodal').modal('show');
		} else {
			$('#imagepreview').attr('src', src);
			$('#imagemodal').modal('show');
		}
	}

	// Approve keywords
	function approveMedia(id, media) {
		var media = media.replace(/%20/g, ' ');

		swal({
			title: "Approval Needed",
			text: "Choose approval status for the media: \"" + media + "\"?",
			type: "info",
			confirmButtonClass: "btn btn-success",
			confirmButtonText: "Approve",
			showCancelButton: true,
			cancelButtonClass: "btn btn-danger",
			cancelButtonText: "Reject",
			timer: 5000
		}).then(function(e) {
			var status
			if (e.value) {
				status = 2
			} else if (e.dismiss == 'cancel') {
				status = 0
			} else {
				return
			}
			$.ajax({
				url: '<?= site_url('admin/brands/vault/update/status/media/id/'); ?>' + id,
				type: 'GET',
				data: {
					status: status
				},
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to change status.", "error")
					} else {
						swal("Success!", "The status has been changed.", "success")
						$('#m_table').DataTable().ajax.reload(null, false);
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	var datatable = {
		init: function() {
			$("#m_table").DataTable({
				responsive: !0,
				dom: '<"top"lfp>rt<"bottom"ip><"clear">',
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				ajax: '<?= site_url("admin/brands/vault/get/brand/id/$brand->id"); ?>',
				columns: [{
					data: "id"
				}, {
					data: "title"
				}, {
					data: "url"
				}, {
					data: "media"
				}, {
					data: "note"
				}, {
					data: "date_submitted"
				}, {
					data: "status"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					orderable: !1,
					render: function(a, t, e, n) {
						var title = e['title'].replace(/ /g, '%20');
						return '<a href="<?= site_url("admin/brands/vault/brand/id/$brand->id/media/id/") ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Create Ad"><i class="la la-plus"></i></a>'
					}
				}, {
					targets: 2,
					render: function(a, t, e, n) {
						return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
					}
				}, {
					targets: 3,
					render: function(a, t, e, n) {
						// check if the media is a video (only mp4 format)
						var isVideo = e['media'].substr(e['media'].length - 3) == 'mp4' ? 1 : 0;
						if (isVideo)
							return '<td><i title="View" class="fas fa-video" style="cursor:pointer" onclick="view(\'<?= site_url("base/media/vault/brand_$brand->id/") ?>' + e['media'] + '\',1)"></i></td>'
						else
							return '<td><img src="<?= site_url("base/media/vault/brand_$brand->id/") ?>' + e['media'] + '" title="View" alt="No Media" style="display:block; max-width:200px; max-height:100px; cursor:pointer;" onclick="view(\'<?= site_url("base/media/vault/brand_$brand->id/") ?>' + e['media'] + '\',0)"></td>'
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						return new Date(e['date_submitted']).toLocaleString();
					}
				}, {
					targets: 6,
					render: function(a, t, e, n) {
						var s = {
							2: {
								title: "Accepted",
								class: "m--font-bold m--font-success"
							},
							1: {
								title: "Approval Needed",
								class: "m-badge--warning"
							},
							0: {
								title: "Rejected",
								class: "m--font-bold m--font-danger"
							}
						};
						if (e['status'] == 1) {
							var media = e['title'].replace(/ /g, '%20');
							return '<span id= tablerow' + n['row'] + ' title="Approval Needed" onclick=approveMedia("' + e['id'] + '","' + media + '") class="m-badge ' + s[1].class + ' m-badge--wide" style="cursor:pointer">' + s[1].title + '</span>'
						} else {
							return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="' + s[a].title + '" class="' + s[a].class + '">' + s[a].title + '</span>'
						}
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		datatable.init();
	});

	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-brands").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>