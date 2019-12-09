<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header
$this->load->view('my_skearch/templates/header');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>
<div class="m-content">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="m-portlet m-portlet--full-height m-portlet--rounded">
				<div class="m-portlet__body">
					<div class="m-card-profile">
						<div class="m-card-profile__title">
							<?= $user_group->description; ?>
						</div>
						<div class="m-card-profile__pic">
							<div class="m-card-profile__pic-wrapper">
								<img src="<?= site_url(ASSETS); ?>/my_skearch/app/media/img/users/user-default.jpg" alt="" />
							</div>
						</div>
						<div class="m-card-profile__details">
							<span class="m-card-profile__name"><?= $this->session->userdata('first_name') . " " . $this->session->userdata('last_name') ?></span>
							<a href="" class="m-card-profile__email m-link"><?= $this->session->userdata('email'); ?></a>
						</div>
					</div>
					<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
						<li class="m-nav__separator m-nav__separator--fit"></li>
						<li class="m-nav__section m--hide">
							<span class="m-nav__section-text">Section</span>
						</li>
						<li class="m-nav__item">
							<a href="<?= base_url("myskearch/profile"); ?>" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-profile-1"></i>
								<span class="m-nav__link-title">
									<span class="m-nav__link-wrap">
										<span class="m-nav__link-text">My Profile</span>
									</span>
								</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-share"></i>
								<span class="m-nav__link-text">Activity</span>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-chat-1"></i>
								<span class="m-nav__link-text">Messages</span>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-graphic-2"></i>
								<span class="m-nav__link-text">Sales</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-time-3"></i>
								<span class="m-nav__link-text">Events</span>
							</a>
						</li>
						<li class="m-nav__item">
							<a href="header/profile&amp;demo=default.html" class="m-nav__link">
								<i class="m-nav__link-icon flaticon-lifebuoy"></i>
								<span class="m-nav__link-text">Support</span>
							</a>
						</li>
					</ul>
					<div class="m-portlet__body-separator"></div>
					<div class="m-widget1 m-widget1--paddingless">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Member Profit</h3>
									<span class="m-widget1__desc">Awerage Weekly Profit</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-brand">+$17,800</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Orders</h3>
									<span class="m-widget1__desc">Weekly Customer Orders</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-danger">+1,800</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Issue Reports</h3>
									<span class="m-widget1__desc">System bugs and issues</span>
								</div>
								<div class="col m--align-right">
									<span class="m-widget1__number m--font-success">-27,49%</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-8">
			<div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--rounded">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
									<i class="flaticon-share m--hide"></i>
									Profile
								</a>
							</li>
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
									Settings
								</a>
							</li>
						</ul>
					</div>
					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item m-portlet__nav-item--last">
								<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
									<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
										<i class="la la-gear"></i>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														<li class="m-nav__section m-nav__section--first">
															<span class="m-nav__section-text">Quick Actions</span>
														</li>
														<li class="m-nav__item">
															<a href="auth/change_password" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-share"></i>
																<span class="m-nav__link-text">Change Password</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="auth/change_email" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-chat-1"></i>
																<span class="m-nav__link-text">Change Email Address</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-multimedia-2"></i>
																<span class="m-nav__link-text">Upload File</span>
															</a>
														</li>
														<li class="m-nav__separator m-nav__separator--fit m--hide">
														</li>
														<li class="m-nav__item m--hide">
															<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="m_user_profile_tab_1">
						<?= form_open('myskearch/profile/' . $myskearch_id, 'id="login_form"'); ?>
						<fieldset class="m-form m-form--fit m-form--label-align-right">
							<input type="hidden" id="myskearch_id" name="myskearch_id" value=<?= $myskearch_id; ?>>
							<?php echo form_hidden($csrf); ?>
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10">
									<?php $this->load->view('my_skearch/templates/notifications'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">1. Personal Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="first_name" class="col-2 col-form-label">First Name</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="first_name" value="<?= $this->session->userdata('first_name'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="last_name" class="col-2 col-form-label">Last Name</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="last_name" value="<?= $this->session->userdata('last_name'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="organization" class="col-2 col-form-label">Organization</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="organization" value="<?= $this->session->userdata('organization'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="phone" class="col-2 col-form-label">Phone No.</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="phone" value="<?= $this->session->userdata('phone'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender</label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="gender">
											<option value="<?php echo (!empty($this->input->post('gender'))) ? $this->input->post('gender') : $this->session->userdata('gender'); ?>" selected hidden><?php echo (!empty($this->input->post('gender'))) ? ucfirst($this->input->post('gender')) : ucfirst($this->session->userdata('gender')); ?></option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group</label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="age_group">
											<option value="<?php echo (!empty($this->input->post('age_group'))) ? $this->input->post('age_group') : $this->session->userdata('age_group'); ?>" selected hidden><?php echo (!empty($this->input->post('age_group'))) ? $this->input->post('age_group') : $this->session->userdata('age_group'); ?></option>
											<option value="1-17">1-17</option>
											<option value="18-22">18-22</option>
											<option value="23-30">23-30</option>
											<option value="31-50">31-50</option>
											<option value="51+">51+</option>
										</select>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">2. Address</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address Line 1</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?= $this->session->userdata('address1'); ?>">
										<span class="m-form__help">Street address, P.O box, company name, c/o</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address2" class="col-2 col-form-label">Address Line 2</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address2" value="<?= $this->session->userdata('address2'); ?>">
										<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="city" class="col-2 col-form-label">City</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="city" value="<?= $this->session->userdata('city'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="state" class="col-2 col-form-label">State</label>
									<div class="col-2">
										<select class="form-control m-input" id="exampleSelect1" name="state">
											<option value="<?php echo ((set_value('state') !== "") ? set_value('state') : ((($this->session->userdata('state')) ? $this->session->userdata('state') : ''))); ?>" selected disabled hidden><?php echo ((set_value('state') !== "") ? set_value('state') : ((($this->session->userdata('state')) ? $this->session->userdata('state') : 'Select'))); ?></option>
											<?php foreach ($states as $state) : ?>
												<option value="<?= $state->statecode; ?>"><?= $state->statecode; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="country" class="col-2 col-form-label">Country</label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="country">
											<option value="<?php echo ((set_value('country') !== "") ? set_value('country') : ((($this->session->userdata('country')) ? $this->session->userdata('country') : ''))); ?>" selected disabled hidden><?php echo ((set_value('country') !== "") ? set_value('country') : ((($this->session->userdata('country')) ? $this->session->userdata('country') : 'Select'))); ?></option>
											<?php foreach ($countries as $country) : ?>
												<option value="<?= $country->country_name; ?>"><?= $country->country_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="zipc" class="col-2 col-form-label">Zipcode</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="zip" value="<?= $this->session->userdata('zip'); ?>">
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" name="update_profile" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<?= form_close(); ?>
					</div>
					<div class="tab-pane" id="m_user_profile_tab_2">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php

// End page body
$this->load->view('my_skearch/templates/end_pagebody');

// Load footer
$this->load->view('my_skearch/templates/footer');

// End page section
$this->load->view('my_skearch/templates/end_page');

// Load quick sidebar
$this->load->view('my_skearch/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('my_skearch/templates/scrolltop');

// Close body and html (contains some javascripts links)
$this->load->view('my_skearch/templates/close_html');

?>