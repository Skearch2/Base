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
$this->load->view('my_skearch/templates/header_menu');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-content">

	<div class="m-portlet m-portlet--full-height m-portlet--fit  m-portlet--rounded">
		<div class="m-portlet__body">
			<div class="form-group m-form__group row">
				<label for="search-engine" class="col-2 col-form-label">Deafult Search Engine</label>
				<div class="col-3">
					<select class="form-control m-input" id="search_engine" name="search_engine" onchange=update_settings()>
						<option value="duckduckgo" <?= ($search_engine === 'duckduckgo') ? 'selected' : '' ?>>DuckDuckGo</option>
						<option value="startpage" <?= ($search_engine === 'startpage') ? 'selected' : '' ?>>Startpage</option>
						<option value="google" <?= ($search_engine === 'google') ? 'selected' : '' ?>>Google</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="m-section">
		<h3 class="m-section__heading">
			Recent Fields Visited
		</h3>
		<div class="m-section__content">
			<div class="m-demo">
				<div class="m-demo__preview" id="recent_history">
					<?php if ($fields_history) : ?>
						<div class="m-list-timeline">
							<div class="m-list-timeline__items">
								<?php foreach ($fields_history as $field) : ?>
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge"></span>
										<span class="m-list-timeline__text"><a href="browse/<?= strtolower($field->umbrella) ?>/<?= strtolower($field->title) ?>"><?= $field->title ?></a></span>
										<span class="m-list-timeline__time"><?= ($field->recurrence > 1) ? "$field->recurrence times" : "$field->recurrence time" ?></span>
										<span class="m-list-timeline__time"><?= $field->timestamp ?></span>
									</div>
								<?php endforeach ?>
							</div>
							<br><button type="button" class="btn btn-danger btn-sm float-right" onclick="clearHistory()">Clear History</button><br>
						</div>
					<?php else : ?>
						<i>No recent history</i>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<!--	Button - Set Skearch as homepage -->
	<div class='home-footer-btn'>
		<a href="#" class="btn-footer-skear"></a> <br>
		<a href="#" title="Set Skearch as Default Search Engine" class="set-skearch">»Set Skearch as my default search engine</a>
	</div>
	<!--	End: Button - Set Skearch as homepage -->
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

// Load scrolltop button
$this->load->view('my_skearch/templates/scrolltop');

// Load global JS files
$this->load->view('my_skearch/templates/js_global');

?>

<!-- Page Scripts -->
<script>
	//Toggles user active status
	function clearHistory() {
		$.ajax({
			url: '<?= site_url('myskearch/dashboard/history/clear'); ?>',
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					toastr.error("", "Unable to clear hisory.");
				} else if (data == 1) {
					$("#recent_history").html("<i>History cleared<i>");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to process request.");
			}
		});
	}

	function update_settings() {
		// var csrf_name = '<?= $this->security->get_csrf_token_name() ?>';
		// var csrf_hash = '<?= $this->security->get_csrf_hash() ?>';

		$.ajax({
			url: '<?= site_url(); ?>myskearch/dashboard/settings/update',
			type: 'GET',
			// dataType: 'json',
			data: {
				// csrf_name: csrf_hash,
				search_engine: $('#search_engine').val()
			},
			success: function(data, status) {
				if (data == 1)
					toastr.success("", "Settings updated.");
				else
					toastr.error("", "Unable to update settings.");
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to process request.");
			}
		});
	}
</script>
<!--end::Page Scripts -->

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>