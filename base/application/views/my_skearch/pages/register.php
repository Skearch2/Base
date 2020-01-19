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
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background:linear-gradient(0deg,rgba(255, 255, 255, 0.5),rgba(255, 255, 255, 0.5)),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(<?= site_url(ASSETS); ?>/my_skearch/app/media/img/bg/bg-3.jpg); background-size:cover; background-attachment: fixed">
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
								<button id="m_signup_user" type="button" onclick="show_form_user()" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn <?= $is_regular ? 'active' : '' ?>">User</button>
								&nbsp;
								<button id="m_signup_brand" type="button" onclick="show_form_brand()" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn <?= !$is_regular ? 'active' : '' ?>">Brand</button>
							</div>
						</fieldset>
						<?= form_open(''); ?>
						<fieldset class="m-login__form m-form">
							<input id="is_regular_signup" name="is_regular_signup" type="hidden" value="<?= $is_regular; ?>">
							<div id="m-login__form m-form__user" style=<?= $is_regular ? 'display:block' : 'display:none' ?>>
								<div>Personal Details:</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="First Name" name="firstname" value="<?= set_value('firstname'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Last Name" name="lastname" value="<?= set_value('lastname'); ?>">
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
								<div>Login Details:</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Username" name="username" value="<?= set_value('username'); ?>">
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
											<input type="checkbox" name="agree" <?php echo ($this->input->post('agree')) ? "checked" : ""; ?>>I Agree to the <a href="https://www.skearch.io/tos" target="_blank" class="m-link m-link--focus"><b>terms of service</b></a> and <a href="https://www.skearch.io/privacy" target="_blank" class="m-link m-link--focus"><b>privacy policy</b></a>.
											<span></span>
										</label>
										<span class="m-form__help"></span>
									</div>
								</div>
							</div>
							<div id="m-login__form m-form__brand" style=<?= !$is_regular ? 'display:block' : 'display:none' ?>>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Name" name="name" value="<?= set_value('name'); ?>">
								</div>
								<div class="form-group m-form__group row">
									<input class="form-control m-input" placeholder="Brand Name" type="text" name="brandname" value="<?= set_value('brand'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Phone" name="phone" value="<?= set_value('phone'); ?>">
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

	<script>
		function show_form_user() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "block";
			formBrand.style.display = "none";

			$("#is_regular_signup").val(1);
			$('#m_signup_user').removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');
			$("#m_signup_brand").removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
		}

		function show_form_brand() {
			var formUser = document.getElementById("m-login__form m-form__user");
			var formBrand = document.getElementById("m-login__form m-form__brand");

			formUser.style.display = "none";
			formBrand.style.display = "block";

			$("#is_regular_signup").val(0);
			$('#m_signup_user').removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn');
			$("#m_signup_brand").removeClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn').addClass('btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn active');

		}
	</script>

	<?php

	// Close body and html (contains some javascripts links)
	$this->load->view('admin_panel/templates/close_html');

	?>