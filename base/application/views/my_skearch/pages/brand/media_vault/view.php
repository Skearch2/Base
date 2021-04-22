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

		<!-- bootstrap modal where the image will appear -->
		<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
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

		<div class="m-portlet__body" align="right">
			<a href="<?= site_url('myskearch/brand/vault/add/media') ?>" type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit Media</a>
		</div>

		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The media has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the media.
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
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Thumbnail</th>
						<th>Url</th>
						<th>Date Submitted</th>
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
	// Stop the video when the modal dialog is closed
	$('body').on('hidden.bs.modal', '.modal', function() {
		$('video').trigger('pause');
	});

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

	<?php if (isset($viewas)) : ?>
		var url = "<?= site_url("admin/viewas/brand/id/{$brand_id}/show/ads/action/get"); ?>"
	<?php else : ?>
		var url = "<?= site_url("myskearch/brand/vault/get"); ?>"
	<?php endif ?>

	// Deletes brand
	function deleteMedia(id, media) {
		var media = media.replace(/%20/g, ' ');
		swal({
			title: "Delete?",
			text: "Are you sure you want delete the media: \"" + media + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('myskearch/brand/vault/delete/media/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == 1) {
						swal("Success!", "The media has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the media.", "error")
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
					data: "media"
				}, {
					data: "url"
				}, {
					data: "date_submitted"
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
						var media = e['title'].replace(/ /g, '%20');
						<?php if ($is_primary_brand_user) : ?>
							return '<a href="<?= site_url('myskearch/brand/vault/edit/media/id/') ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=deleteMedia("' + e['id'] + '","' + media + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						<?php else : ?>
							return "-"
						<?php endif ?>
					}
				}, {
					targets: 0,
					orderable: !1
				}, {
					targets: 2,
					orderable: !1,
					render: function(a, t, e, n) {
						// check if the media is a video (only mp4 format)
						var isVideo = e['media'].substr(e['media'].length - 3) == 'mp4' ? 1 : 0;
						if (isVideo)
							return '<td><i title="View video" class="fas fa-video" style="cursor:pointer" onclick="view(\'<?= site_url("base/media/vault/brand_{$brand_id}/") ?>' + e['media'] + '\',1)"></i></td>'
						else
							return '<td><img src="<?= site_url("base/media/vault/brand_{$brand_id}/") ?>' + e['media'] + '" alt="No Media" style="display:block; max-width:200px; max-height:100px; cursor:pointer;" onclick="view(\'<?= site_url("base/media/vault/brand_{$brand_id}/") ?>/' + e['media'] + '\',0)"></td>'
					}
				}, {
					targets: 3,
					render: function(a, t, e, n) {
						return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
					}
				}, {
					targets: 4,
					render: function(a, t, e, n) {
						return new Date(e['date_submitted']).toLocaleDateString();
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						var s = {
							2: {
								title: "Live",
								state: "accent"
							},
							1: {
								title: "Pending",
								state: "warning"
							},
							0: {
								title: "Inactive",
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