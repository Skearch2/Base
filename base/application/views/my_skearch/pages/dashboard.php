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
	<div class="row">
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--bordered">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Brand Deals Right Now!
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget4 demo">
						<div class="m-scrollable toutiao demo1" data-scrollable="true" data-height="380" data-mobile-height="300">
							<?php if (!empty($brand_deals_feed)) : ?>
								<ui class="clearfix">
									<?php foreach ($brand_deals_feed as $deal) : ?>
										<li>
											<div class="m-widget4__item">
												<div class="m-widget4__img m-widget4__img--logo" style="text-align:center;font-weight: bold">
													<img alt="<?= $deal->brand ?>">
												</div>
												<div class="m-widget4__info">
													<a class="m-widget4__title" href="<?= $deal->link ?>" target="_blank">
														<?= $deal->title ?>
													</a><br>
													<span class="m-widget4__sub">
														<?= $deal->description ?>
													</span>
												</div>
												<?php if (
													$this->ion_auth->in_group($this->config->item('regular', 'ion_auth')) || $this->ion_auth->in_group($this->config->item('premium', 'ion_auth'))
												) : ?>
													<div class="m-widget4__ext">
														<?php if ($deal->is_user_opted_in) : ?>
															<span class="m-badge m-badge--success m-badge--wide">Opted</span>
														<?php else : ?>
															<a id="btn-opt-in-deal" onclick="optInDeal(<?= $deal->id ?>, '<?= $deal->title ?>', <?= $this->session->userdata('user_id') ?>, this)" class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Opt In</a>
														<?php endif ?>
													</div>
												<?php endif ?>
											</div>
										</li>
									<?php endforeach ?>
								</ui>
							<?php else : ?>
								<div class="m-widget7">
									<div class="m-widget7__desc">
										There are no new deals available right now!
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-8">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Recent Fields Visited
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body" id="recent_history">
					<?php if ($fields_history) : ?>
						<div class="m-scrollable" data-scrollable="true" data-height="380" data-mobile-height="300">
							<div class="m-list-timeline">
								<div class="m-list-timeline__items">
									<div class="m-list-timeline__item">
										<span class="m-list-timeline__badge"></span>
										<span class="m-list-timeline__text">
											<h5>Field</h5>
										</span>
										<span class="m-list-timeline__text">
											<h5>Last Visited</h5>
										</span>
										<span class="m-list-timeline__text">
											<h5>Times Visited</h5>
										</span>
									</div>
									<?php foreach ($fields_history as $field) : ?>
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge"></span>
											<span class="m-list-timeline__text"><a href="browse/<?= strtolower($field->umbrella) ?>/<?= strtolower($field->title) ?>"><?= $field->title ?></a></span>
											<span class="m-list-timeline__text"><?= $field->time_elapsed ?></span>
											<span class="m-list-timeline__text"><?= $field->recurrence ?></span>
										</div>
									<?php endforeach ?>
								</div>
								<br><button type="button" class="btn btn-danger btn-sm float-right" onclick="clearHistory()">Clear History</button><br>
							</div>
						</div>
					<?php else : ?>
						<i>No recent history</i>
					<?php endif ?>
				</div>

			</div>
		</div>
	</div>

	<div class="demo">

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
<script src="<?= site_url(ASSETS); ?>/js/jquery-vertical-loop.js" type="text/javascript"></script>
<script>
	// Opt in for the deal
	function optInDeal(id, title, userID, element) {
		swal({
			title: title,
			text: "Are you sure to opt in?",
			type: "info",
			confirmButtonClass: "btn btn-success",
			confirmButtonText: "Opt In",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url() ?>' + 'myskearch/dashboard/deals/id/' + id + '/action/opt-in',
				type: 'GET',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to opt-in for the deal.", "warning")
					} else {
						$(element).attr("disabled", "disabled").prop("onclick", null).off("click").text("Opted In");
						swal("Success!", "You have been opted in for this deal.", "success")
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

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

	$('.demo1').verticalLoop({
		delay: 2000,
		order: 'asc'
	});

	setTimeout(function() {
		//$('.demo1').verticalLoop('autoPause');
	}, 10 * 1000);


	var verticalLoop = new VerticalLoop('.demo2', {
		delay: 2000,
		order: 'desc',
		oninitend: function(res) {
			console.log(res);
		}
	});
</script>
<!--end::Page Scripts -->

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>