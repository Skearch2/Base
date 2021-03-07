<?php
// Set DocType and declare HTML protocol
$this->load->view('auth/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('auth/templates/head');
?>

<!-- begin::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

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
					<div class="m-login__signin">
						<div class="m-login__head">
							<h3 class="m-login__title">Login to Skearch</h3>
						</div>
						<?= form_open('', array('id' => 'm_form', 'class' => 'm-login__form m-form')) ?>
						<?php $this->load->view('auth/templates/notifications') ?>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Skearch ID" name="skearch_id" value="<?= set_value('skearch_id') ?>" autocomplete="off">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" name="password" type="password" placeholder="Password">
						</div>
						<div class="row m-login__form-sub">
							<div class="col m--align-left m-login__form-left">
								<label class="m-checkbox  m-checkbox--focus">
									<input type="checkbox" name="remember"> Remember me
									<span></span>
								</label>
							</div>
							<div class="col m--align-right m-login__form-right">
								<a href="<?= base_url('myskearch/auth/forgot_password') ?>" id="m_login_forget_password" class="m-link">Forgot Password ?</a>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signin_submit" class="btn btn-outline-info m-btn m-login__btn m-login__btn--primary">Sign In</button>
						</div>
						<?= form_close() ?>
					</div>
					<div class="m-login__account">
						<span class="m-login__account-msg">
							Don't have an account yet ?
						</span>&nbsp;&nbsp;
						<a href="signup" id="m_login_signup" class="m-link m-link--dark m-login__account-link">Sign Up</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Contains global javascripts
	$this->load->view('auth/templates/js_global');
	?>

	<script>
		$(document).ready(function() {
			FormControls.init();
		});

		var FormControls = {
			init: function() {
				$("#m_form").validate({
					rules: {
						skearch_id: {
							required: 1
						},
						password: {
							required: 1
						}
					},
					invalidHandler: function(e, r) {},
					submitHandler: function(e) {
						form.submit();
					},
				});
			}
		};
	</script>

	<?php
	// Close body and html
	$this->load->view('auth/templates/end_html');
	?>