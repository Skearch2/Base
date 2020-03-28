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
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background:linear-gradient(0deg,rgba(226, 248, 197, 0.500),rgba(226, 248, 197, 0.500)),url(<?= site_url(ASSETS); ?>/my_skearch/app/media/img//bg/bg-3.jpg); background-size:cover;">
			<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
				<?= form_open('myskearch/auth/reset_password/' . $code, 'id="login_form"'); ?>
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= site_url() ?>">
							<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/logos/logo.png">
						</a>
					</div>
					<div class="m-login__signin">
						<div class="m-login__head">
							<h3 class="m-login__title">Set new My Skearch password</h3>
						</div>
						<fieldset class="m-login__form m-form" form='login_form' name='login_fields'>
							<?php $this->load->view('my_skearch/templates/notifications'); ?>
							<input type="hidden" id="skearch_id" name="skearch_id" value=<?= $skearch_id; ?>>
							<?php echo form_hidden($csrf); ?>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last" id="password" name="password" type="password" placeholder="Password">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last" id="password" name="password2" type="password" placeholder="Confirm Password">
							</div>
							<div class="m-login__form-action">
								<button id="login_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Submit</button>
							</div>
						</fieldset>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>

	<!--begin::Page Scripts -->
	<script src="<?= site_url(ASSETS); ?>/my_skearch/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<!--end::Page Scripts -->

</body>

<!-- end::Body -->

</html>