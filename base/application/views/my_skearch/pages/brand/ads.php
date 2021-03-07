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

		<div class="m-portlet__body">
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th width="30%">Description</th>
						<th width="50%">Media</th>
						<th>Duration</th>
						<th width="20%">Redirects to</th>
						<th>Total Clicks</th>
						<th>Total Impressions</th>
						<th>Status</th>
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

	// Show modal dialog to preview media
	function viewMedia(src, isVideo = 0) {
		if (isVideo == 1) {
			$('#videopreview').attr('src', 'https://media.skearch.com/data/' + src);
			$('#videomodal').modal('show');
		} else {
			$('#imagepreview').attr('src', 'https://media.skearch.com/data/' + src);
			$('#imagemodal').modal('show');
		}
	}

	<?php if (isset($viewas)) : ?>
		var url = "<?= site_url("admin/viewas/brand/id/{$brand_id}/show/ads/action/get"); ?>"
	<?php else : ?>
		var url = "<?= site_url("myskearch/brand/ads/action/get"); ?>"
	<?php endif ?>

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
					data: "description"
				}, {
					data: "media"
				}, {
					data: "duration"
				}, {
					data: "url"
				}, {
					data: "clicks"
				}, {
					data: "impression"
				}, {
					data: "is_active"
				}],
				columnDefs: [{
					targets: 0,
					orderable: !1
				}, {
					targets: 3,
					orderable: !1,
					render: function(a, t, e, n) {
						// check if the media is a video (only mp4 format)
						var isVideo = e['media'].substr(e['media'].length - 3) == 'mp4' ? 1 : 0;
						if (isVideo)
							return '<td><i title="View video" class="fas fa-video" style="cursor:pointer" onclick="viewMedia(\'' + e['media'] + '\',1)"></i></td>'
						else
							return '<td><img src="https://media.skearch.com/data/' + e['media'] + '" alt="No Media" style="display:block; max-width:200px; max-height:100px; cursor:pointer;" onclick="viewMedia(\'' + e['media'] + '\',0)"></td>'
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
					}
				}, {
					targets: 8,
					render: function(a, t, e, n) {
						var s = {
							1: {
								title: "Active",
								state: "accent"
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