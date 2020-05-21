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
$this->load->view('my_skearch/templates/header');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-content">

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
				<?php foreach ($stats as $stat) : ?>
					<tbody>
						<tr>
							<td> <img src="https://media.skearch.com/data/<?= $stat->media ?>" alt="No Media" style="display:block; max-width:200px; max-height:100px;"></td>
							<td><?= $stat->mediaclicks ?></td>
							<td><?= $stat->mediaimpressions ?></td>
						</tr>
					</tbody>
				<?php endforeach ?>
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

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>