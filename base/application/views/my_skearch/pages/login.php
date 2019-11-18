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
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background:linear-gradient(0deg,rgba(226, 248, 197, 0.500),rgba(226, 248, 197, 0.500)),url(<?= site_url(ASSETS);?>/my_skearch/app/media/img//bg/bg-3.jpg); background-size:cover;">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<?=form_open('', 'id="login_form"');?>
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="<?=site_url();?>">
								<img style="width: 80%; height: 80%" src="<?=site_url(ASSETS);?>/admin_panel/app/media/img/logos/logo.png">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Login To Skearch</h3>
							</div>
							<fieldset class="m-login__form m-form" form='login_form' name='login_fields'>
								<?php $this->load->view('my_skearch/templates/notifications');?>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="My Skearch ID" id="loginid" name="myskearch_id" value= "<?=set_value('myskearch_id');?>" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" id="password" name="password" type="password" placeholder="Password">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--focus">
											<input type="checkbox" value=FALSE id='remember' name="remember"> Remember me
											<span></span>
										</label>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="<?php site_url();?>/myskearch/auth/forgot_password" id="m_login_forget_password" class="m-link">Forgot Password ?</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="login_submit"class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
								</div>
							</fieldset>
						</div>
						<div class="m-login__account">
							<span class="m-login__account-msg">
								Don't have an account yet ?
							</span>&nbsp;&nbsp;
							<a href="signup" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--begin::Global Theme Bundle -->
		<script src="<?= site_url(ASSETS);?>/my_skearch/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS);?>/my_skearch/demo/demo8/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

<?php

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>
