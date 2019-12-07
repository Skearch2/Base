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
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background:linear-gradient(0deg,rgba(255, 255, 255, 0.5),rgba(255, 255, 255, 0.5)),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(/assets/my_skearch/app/media/img//bg/bg-3.jpg),url(<?= site_url(ASSETS);?>/my_skearch/app/media/img//bg/bg-3.jpg); background-size:cover; background-attachment: fixed">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<?=form_open('', 'id="login_form"');?>
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="<?=site_url();?>">
								<img style="width: 80%; height: 80%" src="<?= site_url(ASSETS);?>/admin_panel/app/media/img/logos/logo.png">
							</a>
						</div>
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign Up</h3>
								<div class="m-login__desc">Enter your details to create your account:</div>
							</div>
							<fieldset class="m-login__form m-form" method="post" action="">
								<?php $this->load->view('my_skearch/templates/notifications');?>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="First Name" name="first_name" value="<?=set_value('first_name');?>">
								</div>
								<div class="form-group m-form__group" style="">
									<input class="form-control m-input" type="text" placeholder="Last Name" name="last_name" value="<?=set_value('last_name');?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?=set_value('email');?>">
								</div>
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender</label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="gender" style="height:auto; width:auto">
												<option value="<?=set_value('gender');?>" selected disabled hidden><?php echo ((set_value('gender') !== "") ? ucfirst(set_value('gender')) : 'Select'); ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
									</div>
								 </div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group</label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="age_group" style="height:auto; width:auto">
												<option value="<?=set_value('age_group');?>" selected disabled hidden><?php echo ((set_value('age_group') !== "") ? set_value('age_group') : 'Select'); ?></option>
												<option value="1-17">1-17</option>
												<option value="18-22">18-22</option>
												<option value="23-30">23-30</option>
												<option value="31-50">31-50</option>
												<option value="51+">51+</option>
											</select>
									</div>
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Skearch ID" name="myskearch_id" value="<?=set_value('myskearch_id');?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Password" name="password">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password2">
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
								<div class="m-login__form-action">
									<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign Up</button>&nbsp;&nbsp;
									 <a href="login">
									 		<button type="button" id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
									 </a>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class='footer-link'>
					<a href="https://www.skearch.io/about">About</a>
					<a href="#">Advertisers & Brands</a>
					<a href="https://www.skearch.io/privacy">Privacy Policy</a>
					<a href="https://www.skearch.io/tos">Terms of Service</a>

						<!-- TODO: fix this with CSS! Links should be using UL
								replace break with padding-bottom -->
					<br/><br/>

					<p class='copy-right'>
						Copyright &copy; <?php echo date('Y'); ?> Skearch, LLC All rights reserved<br>
					</p> <!-- End: p class='copy-right' -->

				</div> <!-- End: div class='footer-link' -->

<?php

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>
