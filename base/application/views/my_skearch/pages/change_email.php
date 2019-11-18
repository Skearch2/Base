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
					<?=form_open('myskearch/auth/change_email/', 'id="login_form"');?>
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="#">
								<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS);?>/admin_panel/app/media/img/logos/logo.png">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Set new Skearch Email</h3>
							</div>
							<fieldset class="m-login__form m-form" form='login_form' name='login_fields'>
								<?php $this->load->view('my_skearch/templates/notifications');?>
								<input type="hidden" id="myskearch_id" name="myskearch_id" value=<?=$myskearch_id;?>>
								<?php echo form_hidden($csrf); ?>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" id="new_email" name="new_email" type="email" placeholder="New Email Address" value=<?=set_value('new_email');?>>
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" id="new_email2" name="new_email2" type="email" placeholder="Confirm Email Address" value=<?=set_value('new_email2');?>>
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" id="password" name="current_password" type="password" placeholder="My Skearch Password">
								</div>
								<div class="m-login__form-action">
									<button id="login_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Update</button>
									<a href="<?php site_url();?>/myskearch/profile">
									 		<button type="button" id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
									</a>
								</div>
							</fieldset>
						</div>
					</div>
					<?=form_close();?>
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
