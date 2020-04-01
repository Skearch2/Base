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
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login">
			<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= BASE_URL; ?>">
							<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/logos/logo.png">
						</a>
					</div>
					<div>
						<?php $this->load->view('my_skearch/templates/notifications'); ?>
					</div>
					<div class="m-login__signup">
						<div class="m-login__head">
							<h3 class="m-login__title">Sign Up</h3>
						</div>
						<fieldset class="m-login__form m-form">
							<div class="m-login__form-action">
								<div class="m-login__desc">Select the type of user registeration and fill the fields:</div>
								<button id="btn_signup_user" type="button" onclick="showFormUser()" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn <?= $is_regular ? 'active' : '' ?>">User</button>
								&nbsp;
								<button id="btn_signup_brand" type="button" onclick="showFormBrand()" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn <?= !$is_regular ? 'active' : '' ?>">Brand</button>
							</div>
						</fieldset>
						<?= form_open('', 'id="form_signup"'); ?>
						<fieldset class="m-login__form m-form">
							<input id="is_regular_signup" name="is_regular_signup" type="hidden" value="<?= $is_regular; ?>">
							<div id="m-login__form m-form__user" style=<?= $is_regular ? 'display:block' : 'display:none' ?>>
								<div>Personal Details:</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Name" name="name" value="<?= set_value('name'); ?>">
								</div>
								<div class="form-group m-form__group row">
									Gender
									<select class="form-control m-input" id="dropdown" name="gender" style="padding:0.9em;">
										<option value="" <?= set_select('gender', '', TRUE) ?>>Select</option>
										<option value="male" <?= set_select('gender', 'male') ?>>Male</option>
										<option value="female" <?= set_select('gender', 'female') ?>>Female</option>
									</select>
								</div>
								<div class="form-group m-form__group row">
									Age Group
									<select class="form-control m-input" id="dropdown" name="age_group" style="padding:0.9em;">
										<option value="" <?= set_select('age_group', '', TRUE) ?>>Select</option>
										<option value="1-17" <?= set_select('age_group', '1-17') ?>>1-17</option>
										<option value="18-22" <?= set_select('age_group', '18-22') ?>>18-22</option>
										<option value="23-30" <?= set_select('age_group', '23-30') ?>>23-30</option>
										<option value="31-50" <?= set_select('age_group', '31-50') ?>>31-50</option>
										<option value="51+" <?= set_select('age_group', '51+') ?>>51+</option>
									</select>
								</div>
								<div>Login Details:</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Skearch ID" name="skearch_id" value="<?= set_value('skearch_id'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Password" name="password">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Confirm Password" name="password2">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
								</div>
								<div class="row form-group m-form__group m-login__form-sub">
									<div class="col m--align-left">
										<label class="m-checkbox m-checkbox--focus">
											<input type="checkbox" name="agree" <?= ($this->input->post('agree')) ? "checked" : ""; ?>>I Agree to the <a href="https://www.skearch.io/tos" target="_blank" class="m-link m-link--focus"><b>terms of service</b></a> and <a href="https://www.skearch.io/privacy" target="_blank" class="m-link m-link--focus"><b>privacy policy</b></a>.
											<span></span>
										</label>
										<span class="m-form__help"></span>
									</div>
								</div>
							</div>
							<div id="m-login__form m-form__brand" style=<?= !$is_regular ? 'display:block' : 'display:none' ?>>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Name" name="name_b" value="<?= set_value('name_b'); ?>">
								</div>
								<div class="form-group m-form__group row">
									<input class="form-control m-input" type="text" placeholder="Brand Name" name="brandname" value="<?= set_value('brandname'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="email" placeholder="Email" name="email_b" value="<?= set_value('email_b'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" id="phone" type="text" placeholder="Phone" name="phone" value="<?= set_value('phone'); ?>">
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
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	</div>

	<!--begin::Page Scripts -->

	<script src="<?= site_url(ASSETS); ?>/my_skearch/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="<?= site_url(ASSETS); ?>/frontend/js/jquery.mask.js" type="text/javascript"></script>
	<script>
		// Mask phone field to US number format
		$(document).ready(function() {
			$('#phone').mask('(000) 000-0000');
		});

		// Show sign up form for regular user
		function showFormUser() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "block";
			formBrand.style.display = "none";

			$('#form_signup').trigger("reset");

			$("#is_regular_signup").val(1);
			$('#btn_signup_user').removeClass().addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');
			$("#btn_signup_brand").removeClass().addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
		}

		// Show sign up form for brand user
		function showFormBrand() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "none";
			formBrand.style.display = "block";

			$("#is_regular_signup").val(0);
			$('#btn_signup_user').removeClass().addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
			$("#btn_signup_brand").removeClass().addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');
		}

		function unMaskFields() {
			$('#phone').unmask();
		}
	</script>
	<!--end::Page Scripts -->



</body>

<!-- end::Body -->

</html>