<?php
// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

?>
<!-- begin::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background:linear-gradient(0deg,rgba(255, 255, 255, 0.5),rgba(255, 255, 255, 0.5)),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(<?= site_url(ASSETS); ?>/my_skearch/app/media/img//bg/bg-3.jpg); background-size:cover; background-attachment: fixed">
			<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
				<?= form_open('', 'id="login_form"'); ?>
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= base_url(); ?>">
							<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/logos/logo.png">
						</a>
					</div>
					<div>
						<?php $this->load->view('my_skearch/templates/notifications'); ?>
					</div>
					<div class="m-login__signup">
						<div class="m-login__head">
							<h3 class="m-login__title">Sign Up</h3>
							<div class="m-login__desc">Select the type of user registeration and fill the fields:</div>
						</div>
						<fieldset class="m-login__form m-form">
							<div class="m-login__form-action">
								<button id="m_signup_regular_member" type="button" onclick="toggle_form_billing()" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active">Regular Member</button>
								&nbsp;
								<button id="m_signup_brand_member" type="button" onclick="toggle_form_billing('show')" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Brand Member</button>
							</div>
						</fieldset>
						<fieldset class="m-login__form m-form" method="post" action="">
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="First Name" name="first_name" value="<?= set_value('first_name'); ?>">
							</div>
							<div class="form-group m-form__group" style="">
								<input class="form-control m-input" type="text" placeholder="Last Name" name="last_name" value="<?= set_value('last_name'); ?>">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
							</div>
							<div class="form-group m-form__group row">
								<select class="form-control m-input" id="dropdown" name="gender" style="padding:0.9em;">
									<option value="<?= set_value('gender'); ?>" selected disabled hidden><?php echo ((set_value('gender') !== "") ? ucfirst(set_value('gender')) : 'Gender'); ?></option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
							<div class="form-group m-form__group row">
								<select class="form-control m-input" id="dropdown" name="age_group" style="padding:0.9em;">
									<option value="<?= set_value('age_group'); ?>" selected disabled hidden><?php echo ((set_value('age_group') !== "") ? set_value('age_group') : 'Age Group'); ?></option>
									<option value="1-17">1-17</option>
									<option value="18-22">18-22</option>
									<option value="23-30">23-30</option>
									<option value="31-50">31-50</option>
									<option value="51+">51+</option>
								</select>
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Skearch ID" name="myskearch_id" value="<?= set_value('myskearch_id'); ?>">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="password" placeholder="Password" name="password">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password2">
							</div>
							<div id="form_billing" style="display:none">
								<hr>
								<div id="m-login__form m-form__billing">
									<label class="col-6 col-form-label">Billing Information</label>
									<input id="is_brandmember" name="is_brandmember" type="hidden" value="0">
									<div class="form-group m-form__group row">
										<input class="form-control m-input" placeholder="Organization" type="text" name="organization" value="<?= $this->session->userdata('organization'); ?>">
									</div>
									<div class="form-group m-form__group row">
										<input class="form-control m-input" placeholder="Address Line 1" type="text" name="address1" value="<?= $this->session->userdata('address1'); ?>">
										<span class="m-form__help">Street address, P.O box, company name, c/o</span>
									</div>
									<div class="form-group m-form__group row">
										<input class="form-control m-input" placeholder="Address Line 2" type="text" name="address2" value="<?= $this->session->userdata('address2'); ?>">
										<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
									</div>
									<div class="form-group m-form__group row">
										<input class="form-control m-input" placeholder="City" type="text" name="city" value="<?= $this->session->userdata('city'); ?>">
									</div>
									<div class="form-group m-form__group row">
										<select class="form-control m-input" id="dropdown" name="state" style="padding:0.9em;">
											<option value="<?php echo ((set_value('state') !== "") ? set_value('state') : ((($this->session->userdata('state')) ? $this->session->userdata('state') : ''))); ?>" selected disabled hidden><?php echo ((set_value('state') !== "") ? set_value('state') : ((($this->session->userdata('state')) ? $this->session->userdata('state') : 'State'))); ?></option>
											<?php foreach ($states as $state) : ?>
												<option value="<?= $state->statecode; ?>"><?= $state->statecode; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group m-form__group row">
										<select class="form-control m-input" id="dropdown" name="country" style="padding:0.9em;">
											<option value="<?php echo ((set_value('country') !== "") ? set_value('country') : ((($this->session->userdata('country')) ? $this->session->userdata('country') : ''))); ?>" selected disabled hidden><?php echo ((set_value('country') !== "") ? set_value('country') : ((($this->session->userdata('country')) ? $this->session->userdata('country') : 'Country'))); ?></option>
											<?php foreach ($countries as $country) : ?>
												<option value="<?= $country->country_name; ?>"><?= $country->country_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group m-form__group row">
										<input class="form-control m-input" placeholder="Zipcode" type="text" name="zip" value="<?= $this->session->userdata('zip'); ?>">
									</div>
								</div>
							</div>
							<div class="row form-group m-form__group m-login__form-sub">
								<div class="col m--align-left">
									<label class="m-checkbox m-checkbox--focus">
										<input type="checkbox" name="agree" <?php echo ($this->input->post('agree')) ? "checked" : ""; ?>>I Agree to the <a href="https://www.skearch.io/tos" target="_blank" class="m-link m-link--focus"><b>terms of service</b></a> and <a href="https://www.skearch.io/privacy" target="_blank" class="m-link m-link--focus"><b>privacy policy</b></a>.
										<span></span>
									</label>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="m-login__form-action">
								<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign Up</button>&nbsp;&nbsp;
								<a href="login">
									<button type="button" id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
								</a>
							</div>
					</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
	</div>

	<script>
		function toggle_form_billing(option) {
			var section = document.getElementById("form_billing");
			if (option === "show") {
				section.style.display = "block";
				$("#is_brandmember").val(1);
				$('#m_signup_regular_member').removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
				$("#m_signup_brand_member").removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');

			} else {
				section.style.display = "none";
				$("#is_brandmember").val(0);
				$('#m_signup_brand_member').removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
				$("#m_signup_regular_member").removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');
			}
		}
	</script>

	<?php

	// Close body and html (contains some javascripts links)
	$this->load->view('admin_panel/templates/close_html');

	?>