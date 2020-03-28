<?php
// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

?>
<!-- begin::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?php site_url(ASSETS); ?>/admin_panel/app/media/img/bg/bg-3.jpg);">
			<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= site_url(); ?>">
							<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/logos/logo.png">
						</a>
					</div>
					<?= form_open('', 'id="login_form"') ?>
					<div class="m-login__signin">
						<div class="m-login__head">
							<h3 class="m-login__title">Login To Admin Panel</h3>
						</div>
						<fieldset class="m-login__form m-form" form='login_form' name='login_fields'>
							<?php if ($this->session->flashdata('no_access')) : ?>
								<div align="center" class="m-alert m-alert--outline alert-danger">
									You have no access to admin panel.
								</div>
							<?php endif; ?>
							<?php if ($this->session->flashdata('errors')) : ?>
								<div align="center" class="m-alert m-alert--outline alert-danger">
									<?= $this->session->flashdata('errors') ?>
								</div>
							<?php endif; ?>
							<?php if (validation_errors()) : ?>
								<div align="center" class="m-alert m-alert--outline alert-warning">
									<?= validation_errors(); ?>
								</div>
							<?php endif; ?>
							<?php if ($this->session->flashdata('logout')) : ?>
								<div align="center" class="m-alert m-alert--outline alert-success">
									You have successfully logged out.
								</div>
							<?php endif; ?>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Staff ID" id="id" name="id" value="<?= set_value('id'); ?>" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input m-login__form-input--last" id="password" name="password" type="password" placeholder="Password" name="password">
							</div>
							<div class="row m-login__form-sub">
								<div class="col m--align-left m-login__form-left">
									<label class="m-checkbox  m-checkbox--focus">
										<input type="checkbox" value=FALSE id='remember' name="remember"> Remember me
										<span></span>
									</label>
								</div>
								<div class="col m--align-right m-login__form-right">
									<a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password ?</a>
								</div>
							</div>
							<div class="m-login__form-action">
								<button id="login_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
							</div>
						</fieldset>
					</div>
					<div class="m-login__forget-password">
						<div class="m-login__head">
							<h3 class="m-login__title">Forgotten Password ?</h3>
							<div class="m-login__desc">Enter your email to reset your password:</div>
						</div>
						<fieldset class="m-login__form m-form" method="post" action="">
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
							</div>
							<div class="m-login__form-action">
								<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">Request</button>&nbsp;&nbsp;
								<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
							</div>
						</fieldset>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>

	<!--begin::Global Theme Bundle -->
	<script src="<?php site_url(ASSETS); ?>/admin_panel/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="<?php site_url(ASSETS); ?>/admin_panel/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Global Theme Bundle -->

	<!--begin::Page Scripts -->
	<script src="<?php site_url(ASSETS); ?>/admin_panel/snippets/custom/pages/user/login.js" type="text/javascript"></script>
	<!--end::Page Scripts -->

</body>

<!-- end::Body -->

</html>