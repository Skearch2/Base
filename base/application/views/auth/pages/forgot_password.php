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
					<div class="m-login__forget-password">
						<div class="m-login__head">
							<h3 class="m-login__title">Forgot Password</h3>
						</div>
						<?= form_open('', array('class' => 'm-login__form m-form')) ?>
						<?php $this->load->view('auth/templates/notifications') ?>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Skearch ID" name="skearch_id" id="skearch_id" autocomplete="off">
						</div>
						<div class="m-login__form-action">
							<button id="m_login_forget_password_submit" class="btn btn-outline-info m-btn m-btn--custom m-login__btn">Submit</button>&nbsp;&nbsp;
							<a href="login">
								<button type=button id="m_login_forget_password_cancel" class="btn btn-outline-danger m-btn m-btn--custom m-login__btn">Cancel</button>
							</a>
						</div>
						<?= form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Contains global javascripts
	$this->load->view('auth/templates/js_global');
	// Close body and html
	$this->load->view('auth/templates/end_html');
	?>