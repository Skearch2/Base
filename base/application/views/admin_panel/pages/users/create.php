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
										<h3 class="m-form__section">Login Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="username" class="col-2 col-form-label">Username *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="username" value="<?= set_value('username') ?>">
										<span class="m-form__help">Username should not contain any space and be in range between 5 to 12.</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="email" class="col-2 col-form-label">Email *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="email" value="<?= set_value('email') ?>">
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Personal Details</h3>
									</div>
								</div>
								<?php if (in_array($group, array(1, 2, 3))) : ?>
									<div class="form-group m-form__group row">
										<label for="first_name" class="col-2 col-form-label">First Name *</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="firstname" value="<?= set_value('firstname') ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="last_name" class="col-2 col-form-label">Last Name *</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="lastname" value="<?= set_value('lastname') ?>">
										</div>
									</div>
								<?php endif ?>
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="gender">
											<option value="">Select</option>
											<option value="male" <?= set_select('gender', 'male') ?>>Male</option>
											<option value="female" <?= set_select('gender', 'female') ?>>Female</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="age_group">
											<option value="">Select</option>
											<option value="1-17" <?= set_select('age_group', '1-17') ?>>1-17</option>
											<option value="18-22" <?= set_select('age_group', '18-22') ?>>18-22</option>
											<option value="23-30" <?= set_select('age_group', '23-30') ?>>23-30</option>
											<option value="31-50" <?= set_select('age_group', '31-50') ?>>31-50</option>
											<option value="51+" <?= set_select('age_group', '51+') ?>>51+</option>
										</select>
									</div>
								</div>
								<?php if (in_array($group, array(1, 2, 3))) : ?>
									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">Contact Details</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="phone" class="col-2 col-form-label">Phone No.</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="phone" id="phone" value="<?= set_value('phone') ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="address1" class="col-2 col-form-label">Address Line 1</label>
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
										<label for="city" class="col-2 col-form-label">City</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="city" value="<?= set_value('city') ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="state" class="col-2 col-form-label">State/Province</label>
										<div class="col-7" id="field_state_other">
											<input class="form-control m-input" type="text" name="state_other" value="<?= set_value('state_other') ?>">
										</div>
										<div class="col-3" id="field_state_us">
											<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="state_us">
												<option value="" <?= set_select("state_us", "", TRUE) ?>>Select</option>
												<?php foreach ($states as $state) : ?>
													<option value="<?= $state->statecode; ?>" <?= set_select("state_us", $state->statecode) ?>><?= $state->statecode; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="country" class="col-2 col-form-label">Country</label>
										<div class="col-3">
											<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" id="country" name="country">
												<option value="" <?= set_select("country", "", TRUE) ?>>Select</option>
												<?php foreach ($countries as $country) : ?>
													<option value="<?= $country->country_name ?>" <?= set_select("country", $country->country_name) ?>><?= $country->country_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="zipcode" class="col-2 col-form-label">Zipcode/Postal Code</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode') ?>">
										</div>
									</div>
								<?php endif ?>
								<?php if (in_array($group, array(3))) : ?>
									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">Association</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="brand" class="col-2 col-form-label">Brand *</label>
										<div class="col-7">
											<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="brand">
												<option value="" <?= set_select("brand", "", TRUE) ?>>Select</option>
												<?php foreach ($brands as $brand) : ?>
													<option value="<?= $brand->id ?>" <?= set_select("brand", $brand->brand) ?> data-subtext="<?= $brand->organization; ?>"><?= $brand->brand; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="key-member" class="col-2 col-form-label">Key Member</label>
										<div class="col-7">
											<input type="hidden" name="key_member" value="0" <?= set_value('key_member', 0) == 0 ? 'checked' : "" ?>>
											<span class="m-switch m-switch--icon-check">
												<label>
													<input type="checkbox" name="key_member" value="1" <?= set_value('key_member', 0) == 1 ? 'checked' : "" ?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
								<?php endif ?>
								<?php if (in_array($group, array(1, 2))) : ?>
									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">Privileges</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="group" class="col-2 col-form-label">Group *</label>
										<div class="col-3">
											<select class="form-control m-bootstrap-select m_selectpicker" name="group">
												<option value="">Select</option>
												<option value="1" <?= set_select('group', 1) ?>>Admin</option>
												<option value="2" <?= set_select('group', 2) ?>>Editor</option>
											</select>
										</div>
									</div>
								<?php else : ?>
									<input type="hidden" name="group" value="<?= $group ?>">
								<?php endif ?>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					username: {
						required: 1,
						minlength: <?= $this->config->item('min_username_length', 'ion_auth') ?>,
						maxlength: <?= $this->config->item('max_username_length', 'ion_auth') ?>,
						nowhitespace: true
					},
					email: {
						required: 1,
						email: 1
					},
					firstname: {
						required: 1
					},
					lastname: {
						required: 1
					},
					gender: {
						required: 1
					},
					age_group: {
						required: 1
					},
					phone: {
						phoneUS: 1
					},
					brand: {
						required: 1
					},
					group: {
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

	$(document).ready(function() {

		FormControls.init();

		// Mask phone field to US number format
		$("#phone").inputmask("mask", {
			mask: "(999) 999-9999"
		});

		// hide option which has no value
		$('option[value=""]').hide().parent().selectpicker('refresh');

		// show US states dropdown for United States as country otherwise
		// input field for states/province otherwise
		if ($("#country").val().toLowerCase() == "united states") {
			// $('input[name="state_other"]').val('');
			$("#field_state_other").hide();
			$('input[name="state_other"]').prop('disabled', true);
			$("#field_state_us").show();
		} else if ($("#country").val() == '') {
			$("#field_state_other").hide();
			$("#field_state_us").hide();
		} else {
			$("#field_state_us").hide();
			$('input[name="state_us"]').prop('disabled', true);
			$("#field_state_other").show();
		}

		$("#country").change(function() {
			if ($(this).val().toLowerCase() == "united states") {
				$("#field_state_other").hide();
				$('input[name="state_other"]').prop('disabled', true);
				$("#field_state_us").show();
			} else {
				$("#field_state_us").hide();
				$('input[name="state_us"]').prop('disabled', true);
				$("#field_state_other").show();
			}
		});
	});
</script>

<!-- Sidemenu class -->
<script>
	$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	<?php if ($group == 1 || $group == 2) : ?>
		$("#submenu-users-staff").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group == 3) : ?>
		$("#submenu-users-brand_users").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group == 4) : ?>
		$("#submenu-users-premium").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group == 5) : ?>
		$("#submenu-users-regular").addClass("m-menu__item  m-menu__item--active");
	<?php endif ?>
</script>