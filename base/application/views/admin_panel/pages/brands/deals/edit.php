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
						<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form" role="form" method="POST">
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
										<h3 class="m-form__section">Deal Drop</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="brand" class="col-2 col-form-label">Brand *</label>
									<div class="col-7">
										<select class="form-control m-bootstrap-select m_selectpicker" name="brand">
											<option value="<?= $deal->brand_id ?>" selected data-subtext="<?= $deal->organization; ?>"><?= $deal->brand; ?></option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="title" class="col-2 col-form-label">Title *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="title" value="<?= set_value('title', $deal->title) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="title" class="col-2 col-form-label">Description *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description" value="<?= set_value('description', $deal->description) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Link *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="link" value="<?= set_value('link', $deal->link); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Ongoing</label>
									<div class="col-7">
										<input type="hidden" id="ongoing" name="override_duration" value="0" <?= set_value('is_active', $deal->override_duration) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" id="ongoing" name="override_duration" value="1" <?= set_value('is_active', $deal->override_duration) == 1 ? 'checked' : "" ?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label class="col-2 col-form-label">Start Date *</label>
									<div class="col-lg-4 col-md-9 col-sm-12">
										<div class="input-group date">
											<input type="text" class="form-control m-input" readonly placeholder="Select date and time" id="m_datetimepicker" name="start_date" value="<?= set_value('start_date', $deal->start_date); ?>">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-calendar-check-o"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Duration in day(s) *</label>
									<div class="col-7">
										<div class="m-ion-range-slider">
											<input type="hidden" name="duration" id="duration" value="<?= set_value('duration', $deal->duration) ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
											&emsp;
											<button type="button" class="btn btn-secondary m-btn m-btn--air m-btn--custom" onclick="window.history.back()">Cancel</button>
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
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					title: {
						required: 1
					},
					description: {
						required: 1
					},
					link: {
						required: 1,
						url: 1
					},
					start_date: {
						required: "#ongoing:unchecked",
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
				min: 1,
				max: 30
				// postfix: " days"
			});
		},
	};

	var BootstrapDatetimepicker = function() {
		var t;
		t = {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		};
		return {
			init: function() {
				$("#m_datetimepicker").datetimepicker({
					startDate: new Date(),
					showMeridian: 1,
					todayHighlight: 1,
					orientation: "bottom",
					templates: t,
					autoclose: 1,
					todayBtn: 1,
					pickerPosition: "top-left"
				})
			}
		}
	}();

	$(document).ready(function() {
		BootstrapDatetimepicker.init();
		FormControls.init();
		IONRangeSlider.init();
	});

	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-dealdrop").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>