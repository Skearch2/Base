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

	<!--begin::Stats-->
	<div class="m-section">
		<span class="m-section__sub">
			Ad stats
		</span>
		<div class="m-section__content">
			<table class="table">
				<thead>
					<tr>
						<th>Media</th>
						<th>Total Clicks</th>
						<th>Total Impressions</th>
					</tr>
				</thead>
				<?php if (empty($stats)) : ?>
					<tbody>
						<tr>
							<td></td>
							<td>No Ads found</td>
							<td></td>
						</tr>
					</tbody>
				<?php else : ?>
					<?php foreach ($stats as $stat) : ?>
						<tbody>
							<tr>
								<?php
								// check if the media is a video (only mp4 format)
								$is_video = substr(strtolower($stat->media), -3) == 'mp4' ? 1 : 0;
								?>
								<?php if ($is_video) : ?>
									<td><i title="View video" class="fas fa-video" style="cursor:pointer" onclick="viewMedia('<?= $stat->media ?>')"></i></td>
								<?php else : ?>
									<td><img src="https://media.skearch.com/data/<?= $stat->media ?>" alt="No Media" style="display:block; max-width:200px; max-height:100px;"></td>
								<?php endif ?>
								<td><?= $stat->mediaclicks ?></td>
								<td><?= $stat->mediaimpressions ?></td>
							</tr>
						</tbody>
					<?php endforeach ?>
				<?php endif ?>
			</table>
		</div>
	</div>
	<!--end::Stats-->

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
<script>
	// Show modal dialog to preview media
	function viewMedia(src) {
		$('#videopreview').attr('src', 'https://media.skearch.com/data/' + src);
		$('#videomodal').modal('show');
	}

	// Stop the video when the modal dialog is closed
	$('body').on('hidden.bs.modal', '.modal', function() {
		$('video').trigger('pause');
	});
</script>

<?php
// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>