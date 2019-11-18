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
							<a href="#">
								<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS);?>/admin_panel/app/media/img/logos/logo.png">
							</a>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">Forgotten Password ?</h3>
								<div class="m-login__desc">Enter your Skearch ID to reset your password:</div>
							</div>
							<fieldset class="m-login__form m-form" method="post" action="">
								<?php $this->load->view('my_skearch/templates/notifications');?>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="My Skeach ID" name="myskearch_id" id="m_email" autocomplete="off">
								</div>
								<div class="m-login__form-action">
									<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">Request</button>&nbsp;&nbsp;
									<a href="login">
										<button type=button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
							  	</a>
								</div>
							</fieldset>
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
