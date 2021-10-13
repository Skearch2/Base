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
	<div class="row">
		<div class="col-xl-9 col-lg-8">
			<div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--unair">
				<div class="tab-content">
					<div class="tab-pane active" id="m_user_profile_tab_1">
						<form class="m-form m-form--fit m-form--label-align-right" id="m_form" role="form" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
							<div class="m-portlet__body">
								<?php if (validation_errors()) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-warning"></i>
											</div>
											<div class="m-alert__text">
												<?= validation_errors() ?>
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php endif ?>
								<div class="m-form__content">
									<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_msg">
										<div class="m-alert__icon">
											<i class="la la-warning"></i>
										</div>
										<div class="m-alert__text">
											There are some errors found in the form, please check and try submitting again!
										</div>
										<div class="m-alert__close">
											<button type="button" class="close" data-close="alert" aria-label="Close">
											</button>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Media</h3>
									</div>
								</div>
								<!-- <div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label"></label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="m-dropzone dropzone" id="m-dropzone-one" name="media">
											<div class="m-dropzone__msg dz-message needsclick">
												<h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
												<span class="m-dropzone__msg-desc">This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.</span>
											</div>
										</div>
									</div>
								</div> -->
								<div class="form-group m-form__group row">
									<label for="media-preview" class="col-2 col-form-label"></label>
									<div class="col-7">
										<?php $is_video = (substr($ad->media, -3) == "mp4") ? 1 : 0 ?>
										<?php if ($is_video) : ?>
											<video controls src="<?= site_url("base/media/$ad->media") ?>" style="display:block; width:auto; height:auto; max-width:600px; max-height:600px;">
												Unable to play video, incompatible browser.
											</video>
										<?php else : ?>
											<img src="<?= site_url("base/media/$ad->media") ?>" style="display:block; width:auto; height:auto; max-width:600px; max-height:600px;">
										<?php endif ?>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="media-upload" class="col-2 col-form-label"></label>
									<div class="col-7 custom-file">
										<input type="file" class="custom-file-input" id="customFile" name="media">
										<label class="custom-file-label" for="media">Replace Media</label>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Stats</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="brand" class="col-2 col-form-label"></label>
									<div class="m-section__content">
										<table class="table table-bordered m-table m-table--border-secondary">
											<thead>
												<tr>
													<th>Total Clicks</th>
													<th>Total Impressions</th>
													<th></th>

												</tr>
											</thead>
											<tbody>
												<tr>
													<td id="total-clicks"><?= $ad->clicks ?></td>
													<td id="total-impressions"><?= $ad->impressions ?></td>
													<td><button type="button" class="btn btn-danger btn-sm m-btn m-btn--custom" onclick="resetStats(<?= $ad->id ?>)">Reset</button></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Title *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="title" value="<?= set_value('title', $ad->title) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Link Reference *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="url" id="url" value="<?= set_value('url', $ad->url) ?>">
									</div>
									<label class="m-checkbox">
										No Link
										<div class="col-3">
											<input type="checkbox" name="has_no_url" id="no_url" value="1" <?= set_value('has_no_url', (empty($ad->url) ? 1 : 0)) == 1 ? 'checked' : "" ?>>
										</div>
									</label>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Duration *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="duration" value="<?= set_value('duration', $ad->duration) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Sponsored</label>
									<div class="col-7">
										<input type="hidden" name="has_sign" value="0" <?= set_value('has_sign', $ad->has_sign) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="has_sign" value="1" <?= set_value('has_sign', $ad->has_sign) == 1 ? 'checked' : "" ?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Enabled</label>
									<div class="col-7">
										<input type="hidden" name="is_active" value="0" <?= set_value('is_active', $ad->is_active) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="is_active" value="1" <?= set_value('is_active', $ad->is_active) == 1 ? 'checked' : "" ?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<!-- <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Banner</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Scope *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="scope" id="scope" onchange="listBanners(this.value)">
											<option value="">Select</option>
											<option value="global" <?= set_select('scope', 'global') ?>>Global</option>
											<option value="umbrella" <?= set_select('scope', 'umbrella') ?>>Umbrella</option>
											<option value="field" <?= set_select('scope', 'field') ?>>Field</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row" id="umbrella">
									<label for="example-text-input" class="col-2 col-form-label">Umbrella *</label>
									<div class="col-7">
										<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="umbrella">
											<option value="" <?= set_select('scope_id', '', TRUE) ?>>Select</option>
											<?php foreach ($umbrellas as $umbrella) : ?>
												<option value="<?= $umbrella->id ?>" <?= set_select("scope_id", $umbrella->id) ?>><?= $umbrella->title ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row" id="field">
									<label for="example-text-input" class="col-2 col-form-label">Field *</label>
									<div class="col-7">
										<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="field">
											<option value="" <?= set_select('scope_id', '', TRUE) ?>>Select</option>
											<?php foreach ($fields as $field) : ?>
												<option value="<?= $field->id ?>" <?= set_select("scope_id", $field->id) ?>><?= $field->title ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row" id="banner_div">
									<label for="age_group" class="col-2 col-form-label">Banner *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="banner" id="banner">
											<option value="">Select</option>
										</select>
									</div>
								</div> -->
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
										</div>
										<div class="col-3">
											<small>* Indicates required field</small>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
	// reset stats
	function resetStats(id) {
		swal({
			title: "Reset Stats",
			text: "Are you sure you want reset total clicks and impressions?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Reset",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url() ?>admin/ads/manager/ad/id/' + id + '/action/reset/activity',
				type: 'GET',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else if ((data == 0)) {
						swal("Error!", "Unable to reset stats.", "error")
					} else {
						$("#total-clicks").html('0')
						$("#total-impressions").html('0')
						swal("Success!", "The stats has been reset.", "success")
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}


	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					brand: {
						required: 1
					},
					title: {
						required: 1
					},
					url: {
						required: "#no_url:unchecked",
						url: 1
					},
					duration: {
						required: 1,
						digits: 1
					},
					scope: {
						required: 1
					},
					umbrella: {
						required: function() {
							return $("#scope").val() == "umbrella";
						}
					},
					field: {
						required: function() {
							return $("#scope").val() == "field";
						}
					},
					banner: {
						required: 1
					}
				},
				invalidHandler: function(e, r) {
					$("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
				},
				submitHandler: function(e) {
					form.submit();
				},
			});
		}
	};

	var IONRangeSlider = {
		init: function() {
			$("#duration").ionRangeSlider({
				min: 10,
				max: 180,
				from: 30
			});
		},
	};

	function listBanners(scope) {
		if (scope == "umbrella") {
			$("#umbrella").show();
			$("#field").hide();
			$("#banner").empty();
			$("#banner").append('<option value="">Select</option>');
			$("#banner").append('<option value="A">A</option>');
			$("#banner").append('<option value="U">U</option>');
			$("#banner_div").show();
		} else if (scope == "field") {
			$("#field").show();
			$("#umbrella").hide();
			$("#banner").empty();
			$("#banner").append('<option value="">Select</option>');
			$("#banner").append('<option value="A">A</option>');
			$("#banner").append('<option value="B">B</option>');
			$("#banner_div").show();
		} else {
			$("#umbrella").hide();
			$("#field").hide();
			$("#banner").empty();
			$("#banner").append('<option value="">Select</option>');
			$("#banner").append('<option value="A">A</option>');
			$("#banner").append('<option value="B">B</option>');
			$("#banner").append('<option value="U">U</option>');
			$("#banner").append('<option value="VA">VA</option>');
			$("#banner_div").show();
		}
		$('option[value=""]').hide().parent().selectpicker('refresh');
	}

	$(document).ready(function() {
		FormControls.init();
		IONRangeSlider.init();

		// var myDropzone = new Dropzone("#m-dropzone-one", {
		// 	method: 'GET',
		// 	url: '<?= site_url("admin/ads/manager/upload/media") ?>',
		// 	paramName: 'media',
		// 	clickable: true,
		// 	autoProcessQueue: true,
		// 	addRemoveLinks: true,
		// 	maxFiles: 1,
		// 	maxFilesize: <?= ($this->config->item('upload_file_size') / 1024) ?>, // in MBs
		// 	acceptedFiles: ".jpeg,.jpg,.png,.gif,.mp4"
		// });

		// myDropzone.on("sending", function(file, xhr, formData) {
		// 	var formData = new FormData();
		// 	// var media = $('#m-dropzone-one').prop('files')[0];   
		// 	formData.append('media', file)
		// });

		// myDropzone.on("error", function(file, xhr, formData) {
		// 	console.log("Error")
		// });

		// myDropzone.on("success", function(file, xhr, formData) {
		// 	console.log("Success")
		// });

		// disbale url input if no url checkbox is checked
		if ($('#no_url').is(':checked')) {
			$('#url').prop('disabled', true);
		}
		$('#no_url').change(function() {
			if ($(this).is(':checked') == true) {
				$('#url').prop('disabled', true);
			} else {
				$('#url').prop('disabled', false);
			}
		});

		// pre-populate https protocol in the url field
		$("#url").inputmask({
			regex: "https://.*"
		});

		// hide option which has no value
		$('option[value=""]').hide().parent().selectpicker('refresh');

		$("#umbrella").hide();
		$("#field").hide();
		$("#banner_div").hide();
	});

	Dropzone.autoDiscover = false;
</script>

<!-- Sidemenu class -->
<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-brands").addClass("m-menu__item  m-menu__item--active");
</script>