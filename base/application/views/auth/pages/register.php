<?php
// Set DocType and declare HTML protocol
$this->load->view('auth/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('auth/templates/head');
?>

<!-- begin::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-4" id="m_login">
			<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= site_url() ?>">
							<div class="logo"></div>
						</a>
					</div>
					<?php if ($this->session->flashdata('signup_success')) : ?>
						<div align="center" class="m-alert m-alert--outline alert-success">
							<?= $this->session->flashdata('success') ?>
						</div>
					<?php else : ?>
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign Up</h3>
							</div>
						</div>
						<?= form_open('', array('class' => 'm-login__form m-form m-form--fit', 'onsubmit' => 'unMaskFields()')) ?>
						<div class="form-group" id="btn_signup">
							<button id="btn_signup_user" type="button" onclick="showFormUser()" class="btn m-btn--square btn-secondary m-btn--wide <?= $is_regular ? 'active' : '' ?>">User</button>
							&nbsp;
							<button id="btn_signup_brand" type="button" onclick="showFormBrand()" class="btn m-btn--square btn-secondary  m-btn--wide <?= !$is_regular ? 'active' : '' ?>">Brand</button>
						</div>

						<?php $this->load->view('auth/templates/notifications'); ?>

						<input id="is_regular_signup" name="is_regular_signup" type="hidden" value="<?= $is_regular; ?>">
						<div id="m-login__form m-form__user" style=<?= $is_regular ? 'display:block' : 'display:none' ?>>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Skearch ID or username" name="skearch_id" value="<?= set_value('skearch_id'); ?>">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
							</div>
							<div class="form-group m-form__group">
								<select class="form-control m-bootstrap-select m-bootstrap-select--pill m_selectpicker" name="gender" title="Gender">
									<option value="male" <?= set_select('gender', 'male') ?>>Male</option>
									<option value="female" <?= set_select('gender', 'female') ?>>Female</option>
								</select>
							</div>
							<div class="form-group m-form__group">
								<select class="form-control m-bootstrap-select m-bootstrap-select--pill m_selectpicker" name="age_group" title="Age group">
									<option value="1-17" <?= set_select('age_group', '1-17') ?>>1-17</option>
									<option value="18-22" <?= set_select('age_group', '18-22') ?>>18-22</option>
									<option value="23-30" <?= set_select('age_group', '23-30') ?>>23-30</option>
									<option value="31-50" <?= set_select('age_group', '31-50') ?>>31-50</option>
									<option value="51+" <?= set_select('age_group', '51+') ?>>51+</option>
								</select>
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="password" placeholder="Password" name="password">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="password" placeholder="Confirm Password" name="password2">
							</div>
							<br>
						</div>
						<div id="m-login__form m-form__brand" style=<?= !$is_regular ? 'display:block' : 'display:none' ?>>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Name" name="name" value="<?= set_value('name'); ?>">
							</div>
							<div class="form-group m-form__group row">
								<input class="form-control m-input" type="text" placeholder="Brand Name" name="brandname" value="<?= set_value('brandname'); ?>">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="email" placeholder="Email" name="email_b" value="<?= set_value('email_b'); ?>">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Phone" name="phone" id="phone" value="<?= set_value('phone'); ?>">
							</div>
							<br>
						</div>
						<div class="input-group">
							<?= $captcha['image'] ?>
							<input class="form-control m-input" type="text" placeholder="Captcha code" name="captcha" id="captcha_code" maxlength="6">
							<div class="input-group-prepend"><span class="input-group-text" id="captcha-refresh" style="cursor:pointer" title="Refresh"><i class="flaticon-refresh"></i></span></div>
						</div>
						<div class="form-group m-form__group m-login__form-sub">
							<div class="col m--align-left" style="padding-top: 20px;">
								<label class="m-checkbox m-checkbox--secondary">
									<input type="checkbox" name="agree" <?= ($this->input->post('agree')) ? "checked" : ""; ?>>I Agree to the <a href="https://www.skearch.io/tos" target="_blank" class="m-link m-link--primary"><b>terms of service</b></a> and <a href="https://www.skearch.io/privacy" target="_blank" class="m-link m-link--primary"><b>privacy policy</b></a>.
									<span></span>
								</label>
								<span class="m-form__help"></span>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signup_submit" class="btn btn-outline-info m-btn m-btn--custom m-login__btn">Sign Up</button>&nbsp;&nbsp;
							<a href="login">
								<button type="button" id="m_login_signup_cancel" class="btn btn-outline-danger m-btn m-btn--custom m-login__btn">Cancel</button>
							</a>
						</div>
						<?= form_close() ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>

	<?php
	// Contains global javascripts
	$this->load->view('auth/templates/js_global');
	?>

	<!--begin::Page Scripts -->

	<script>
		// Show sign up form for regular user
		function showFormUser() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "block";
			formBrand.style.display = "none";

			$('#form_signup').trigger("reset");

			$("#is_regular_signup").val(1);
			$('#btn_signup_user').removeClass().addClass('btn m-btn--square btn-secondary m-btn--wide active');
			$("#btn_signup_brand").removeClass().addClass('btn m-btn--square btn-secondary m-btn--wide');
		}

		// Show sign up form for brand user
		function showFormBrand() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "none";
			formBrand.style.display = "block";

			$("#is_regular_signup").val(0);
			$('#btn_signup_user').removeClass().addClass('btn m-btn--square btn-secondary m-btn--wide');
			$("#btn_signup_brand").removeClass().addClass('btn m-btn--square btn-secondary m-btn--wide active');
		}

		// Mask phone field to US number format
		$(document).ready(function() {
			$("#phone").inputmask("mask", {
				mask: "(999) 999-9999"
			})
		});

		// unmask all input fields before sending
		function unMaskFields() {
			$("#phone").inputmask()
		}

		// refresh captcha
		$(document).on('click', '#captcha-refresh', function() {
			$.ajax({
				url: "<?= base_url(); ?>myskearch/auth/captcha/refresh",
				method: "GET",
				success: function(data) {
					$("#captcha_img").replaceWith(data);
					$("#captcha_code").val('');

				}
			})
		});
	</script>

	<!--end::Page Scripts -->

	<?php
	// Close body and html (contains some global javascripts)
	$this->load->view('auth/templates/end_html');
	?>