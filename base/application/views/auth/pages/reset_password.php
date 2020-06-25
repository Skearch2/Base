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
				<?= form_open('myskearch/auth/reset_password/' . $code, 'id="login_form"'); ?>
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= site_url() ?>">
							<div class="logo"></div>
						</a>
					</div>
					<div class="m-login__signin">
						<div class="m-login__head">
							<h3 class="m-login__title">Set new My Skearch password</h3>
							<div class="m-login__desc">
								<?php $this->load->view('auth/templates/notifications'); ?>
							</div>
						</div>
						<?= form_open('', array('class' => 'm-login__form m-form')) ?>
						<input type="hidden" id="skearch_id" name="skearch_id" value=<?= $skearch_id; ?>>
						<?php echo form_hidden($csrf); ?>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" id="password" name="password" type="password" placeholder="Password">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" id="password" name="password2" type="password" placeholder="Confirm Password">
						</div>
						<div class="m-login__form-action">
							<button id="login_submit" class="btn btn-outline-info m-btn m-btn--custom m-login__btn">Submit</button>
						</div>
						<?= form_close() ?>
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