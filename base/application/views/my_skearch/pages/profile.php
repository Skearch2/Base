<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header
$this->load->view('my_skearch/templates/header_menu');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>
<div class="m-content">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="m-portlet m-portlet--full-height m-portlet--rounded">
				<div class="m-portlet__body">
					<div class="m-card-profile">
						<div class="m-card-profile__title">
							<?= $this->session->userdata('group'); ?>
						</div>
						<div class="m-card-profile__pic">
							<div class="m-card-profile__pic-wrapper">
								<img src="<?= site_url(ASSETS); ?>/my_skearch/app/media/img/users/user-default.jpg" alt="" />
							</div>
						</div>
						<div class="m-card-profile__details">
							<span class="m-card-profile__name"><?= $this->session->userdata('username') ?></span>
							<a href="" class="m-card-profile__email m-link"><?= $this->session->userdata('email'); ?></a>
						</div>
					</div>
					<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
						<li class="m-nav__separator m-nav__separator--fit"></li>
						<li class="m-nav__section m--hide">
							<span class="m-nav__section-text">Section</span>
						</li>
						<li class="m-nav__item">
							<a href="<?= base_url("myskearch/profile"); ?>" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-profile-1"></i>
								<span class="m-nav__link-title">
									<span class="m-nav__link-wrap">
										<span class="m-nav__link-text">My Profile</span>
									</span>
								</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-share"></i>
								<span class="m-nav__link-text">Activity</span>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-chat-1"></i>
								<span class="m-nav__link-text">Messages</span>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-graphic-2"></i>
								<span class="m-nav__link-text">Sales</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-time-3"></i>
								<span class="m-nav__link-text">Events</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-lifebuoy"></i>
								<span class="m-nav__link-text">Support</span>
							</a>
						</li>
					</ul>
					<div class="m-portlet__body-separator"></div>
					<div class="m-widget1 m-widget1--paddingless">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Member Profit</h3>
									<span class="m-widget1__desc">Awerage Weekly Profit</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-brand">+$17,800</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Orders</h3>
									<span class="m-widget1__desc">Weekly Customer Orders</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-danger">+1,800</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Issue Reports</h3>
									<span class="m-widget1__desc">System bugs and issues</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-success">-27,49%</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-8">
			<div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--rounded">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link active" data-toggle="tab" href="#profile" role="tab">
									<i class="flaticon-share m--hide"></i>
									Profile
								</a>
							</li>
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link" data-toggle="tab" href="#brand" role="tab">
									Brand
								</a>
							</li>
						</ul>
					</div>
					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item m-portlet__nav-item--last">
								<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
									<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
										<i class="la la-gear"></i>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														<li class="m-nav__section m-nav__section--first">
															<span class="m-nav__section-text">Quick Actions</span>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-share"></i>
																<span class="m-nav__link-text">Upload Avatar</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-chat-1"></i>
																<span class="m-nav__link-text">Upload Images</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-multimedia-2"></i>
																<span class="m-nav__link-text">Upload File</span>
															</a>
														</li>
														<li class="m-nav__separator m-nav__separator--fit m--hide">
														</li>
														<li class="m-nav__item m--hide">
															<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="profile">
						<?= form_open('myskearch/profile/', 'id="m_form"'); ?>
						<fieldset class="m-form m-form--fit m-form--label-align-right">
							<div class="m-portlet__body">
								<?php if ($this->session->flashdata('success') === 1) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-check"></i>
											</div>
											<div class="m-alert__text">
												Your profile has been updated.
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php elseif ($this->session->flashdata('success') === 0) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-warning"></i>
											</div>
											<div class="m-alert__text">
												Unable to update your profile.
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php elseif (validation_errors()) : ?>
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
										<h3 class="m-form__section">1. Login Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="username" class="col-2 col-form-label">Username *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="username" value="<?= set_value('username', $this->session->userdata('username')) ?>">
										<span class="m-form__help">Username should not contain any space and be in range between 5 to 12.</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="password" class="col-2 col-form-label">Password</label>
									<div class="col-7">
										<a href="<?= base_url('myskearch/auth/change_password') ?>" class="m-link m--font-boldest">Change Password</a>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="email" class="col-2 col-form-label">Email</label>
									<div class="col-7">
										<a href="<?= base_url('myskearch/auth/change_email') ?>" class="m-link m--font-boldest">Change Email</a>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">2. Personal Details</h3>
									</div>
								</div>
								<?php if (in_array($group, array(1, 2, 3))) : ?>
									<div class="form-group m-form__group row">
										<label for="firstname" class="col-2 col-form-label">First Name</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="firstname" value="<?= set_value('firstname', $user->firstname) ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="lastname" class="col-2 col-form-label">Last Name</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="lastname" value="<?= set_value('lastname', $user->lastname) ?>">
										</div>
									</div>
								<?php elseif (in_array($group, array(4, 5))) : ?>
									<div class="form-group m-form__group row">
										<label for="name" class="col-2 col-form-label">Name</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="name" value="<?= set_value('name', $user->firstname) ?>">
										</div>
									</div>
								<?php endif ?>
								<!-- <div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="gender" disabled>
											<option value=""><?= $user->gender ?></option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group *</label>
									<div class="col-3">
										<select class="form-control m-bootstrap-select m_selectpicker" name="age_group" disabled>
											<option value=""><?= $user->age_group ?></option>
										</select>
									</div>
								</div> -->
								<?php if (in_array($group, array(1, 2, 3))) : ?>
									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">3. Contact Details</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="phone" class="col-2 col-form-label">Phone No.</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="phone" id="phone" value="<?= set_value('phone', $user->phone) ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="address1" class="col-2 col-form-label">Address Line 1</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="address1" value="<?= set_value('address1', $user->address1) ?>">
											<span class="m-form__help">Street address, P.O box, company name, c/o</span>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="address2" class="col-2 col-form-label">Address Line 2</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="address2" value="<?= set_value('address2', $user->address2) ?>">
											<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="city" class="col-2 col-form-label">City</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="city" value="<?= set_value('city', $user->city) ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="state" class="col-2 col-form-label">State/Province</label>
										<div class="col-7" id="field_state_other">
											<input class="form-control m-input" type="text" name="state_other" value="<?= set_value('state', $user->state) ?>">
										</div>
										<div class="col-3" id="field_state_us">
											<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="state_us">
												<option value="" <?= set_select("state_us", "", TRUE) ?>>Select</option>
												<?php foreach ($states as $state) : ?>
													<option value="<?= $state->statecode; ?>" <?= set_select("state_us", $state->statecode) ?> <?= (strcmp($user->state, $state->statecode) == 0) ? "selected" : "" ?>><?= $state->statecode; ?></option>
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
													<option value="<?= $country->country_name ?>" <?= set_select("country", $country->country_name) ?> <?= (strcmp($user->country, $country->country_name) == 0) ? "selected" : "" ?>><?= $country->country_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="zipcode" class="col-2 col-form-label">Zipcode</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode', $user->zipcode) ?>">
										</div>
									</div>
								<?php endif ?>
								<div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-2">
												</div>
												<div class="col-7">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>
												</div>
											</div>
										</div>
									</div>
						</fieldset>
						<?= form_close(); ?>
					</div>
					<div class="tab-pane" id="brand">
					</div>
				</div>
			</div>
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

// Load scrolltop button
$this->load->view('my_skearch/templates/scrolltop');

// Load global JS files
$this->load->view('my_skearch/templates/js_global');

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
					phone: {
						phoneUS: 1
					},
				},
				invalidHandler: function(e, r) {
					$("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
				},
				submitHandler: function(e) {
					$("#phone").unmask();
					form.submit();
				},
			});
		}
	};

	$(document).ready(function() {

		FormControls.init();

		// hide option which has no value
		$('option[value=""]').hide().parent().selectpicker('refresh');

		// Mask phone field to US number format
		$("#phone").inputmask("mask", {
			mask: "(999) 999-9999"
		});

		// show US states dropdown for United States as country otherwise
		// input field for states/province otherwise
		if ($("#country").val().toLowerCase() == "united states") {
			$('input[name="state_other"]').prop('disabled', true);
			$("#field_state_other").hide();
			$("#field_state_us").show();
		} else if ($("#country").val() == '') {
			$("#field_state_other").hide();
			$("#field_state_us").hide();
		} else {
			$('input[name="state_us"]').prop('disabled', true);
			$("#field_state_us").hide();
		}

		//TODO: on change state should disable the other one so it wont conflict which one to choose

		$("#country").change(function() {
			if ($(this).val().toLowerCase() == "united states") {
				$("#field_state_other").hide();
				$('input[name="state_other"]').prop('disabled', true);
				$("#field_state_us").show();
				$('input[name="state_us"]').prop('disabled', false);
			} else {
				$("#field_state_us").hide();
				$('input[name="state_us"]').prop('disabled', true);
				$("#field_state_other").show();
				$('input[name="state_other"]').prop('disabled', false);
			}
		});
	});
</script>

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>