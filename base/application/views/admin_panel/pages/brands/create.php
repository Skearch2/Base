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
										<h3 class="m-form__section">Brand Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="brand" class="col-2 col-form-label">Brand *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="brand" value="<?= set_value('brand'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="organization" class="col-2 col-form-label">Organization *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="organization" value="<?= set_value('organization') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address Line 1 *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?= set_value('address1') ?>">
										<span class="m-form__help">Street address, P.O box, company name, c/o</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address2" class="col-2 col-form-label">Address Line 2</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address2" value="<?= set_value('address2') ?>">
										<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="city" class="col-2 col-form-label">City *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="city" value="<?= set_value('city') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="state" class="col-2 col-form-label">State *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="state">
											<option value="" <?= set_select("state", "", TRUE) ?>>Select</option>
											<?php foreach ($states as $state) : ?>
												<option value="<?= $state->statecode; ?>" <?= set_select("state", $state->statecode) ?>><?= $state->statecode; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="country" class="col-2 col-form-label">Country *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="country">
											<option value="United States" selected>United States</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="zipcode" class="col-2 col-form-label">Zipcode *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="note" class="col-2 col-form-label">Note</label>
									<div class="col-lg-7 col-md-9 col-sm-12">
										<textarea class="form-control" name="note" id="note" rows="5"><?= set_value('note') ?></textarea>
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
	var Autosize = {
		init: function() {
			var t;
			t = $("#note"), autosize(t), autosize.update(t)
		}
	};

	var FormControls = {
		init: function() {
			$("#m_form").validate({
				onfocusout: true,
				rules: {
					brand: {
						required: 1
					},
					organization: {
						required: 1
					},
					address1: {
						required: 1
					},
					city: {
						required: 1
					},
					state: {
						required: 1
					},
					country: {
						required: 1
					},
					zipcode: {
						required: 1,
						number: true,
						minlength: 5
					},
					note: {
						maxlength: 5000
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

	$(document).ready(function() {

		FormControls.init()
		Autosize.init()

		// hide option which has no value
		$('option[value=""]').hide().parent().selectpicker('refresh');
	});

	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>