<?php

// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

// Start body element
$this->load->view('admin_panel/templates/start_body');

// Start page section
$this->load->view('admin_panel/templates/start_page');

// Load header
$this->load->view('admin_panel/templates/header');

// Start page body
$this->load->view('admin_panel/templates/start_pagebody');

// Load sidemenu
$this->load->view('admin_panel/templates/sidemenu');

// Start inner body in a page body
$this->load->view('admin_panel/templates/start_innerbody');

// Load subheader in inner body
$this->load->view('admin_panel/templates/subheader');

?>

<div class="m-content">
	<div class="row">
		<div class="col-xl-9 col-lg-8">
			<div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--unair">
				<div class="tab-content">
					<div class="tab-pane active" id="m_user_profile_tab_1">
						<form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
							<input type="hidden" name="id" value="<?= $id; ?>">
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
									<?php if (validation_errors()) : ?>
										<div class="alert alert-danger" role="alert">
											<?= validation_errors(); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">1. Login Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="username" data-toggle="m-popover" data-content="Username should be alphanumeric and range from 5 to 12." class="col-2 col-form-label m-label"><mark>Username</mark>
										<font color="red"><sup>*</sup></font>
									</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="username" value="<?= set_value('username', $username); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="email" class="col-2 col-form-label">Email<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="email" value="<?= set_value('email', $email); ?>">
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">2. Personal Details</h3>
									</div>
								</div>
								<?php if (in_array($group->id, array(1, 2, 3))) : ?>
									<div class="form-group m-form__group row">
										<label for="first_name" class="col-2 col-form-label">First Name<font color="red"><sup>*</sup></font></label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="firstname" value="<?= set_value('firstname', $firstname); ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="last_name" class="col-2 col-form-label">Last Name<font color="red"><sup>*</sup></font></label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="lastname" value="<?= set_value('lastname', $lastname); ?>">
										</div>
									</div>
								<?php elseif (in_array($group->id, array(4, 5))) : ?>
									<div class="form-group m-form__group row">
										<label for="first_name" class="col-2 col-form-label">Name<font color="red"><sup>*</sup></font></label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="name" value="<?= set_value('name', $name) ?>">
										</div>
									</div>
								<?php endif ?>
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="gender">
											<option value="male" <?= set_select('gender', 'male') ?> <?= (strcmp($gender, "male") == 0) ? "selected" : "" ?>>Male</option>
											<option value="female" <?= set_select('gender', 'female') ?> <?= (strcmp($gender, "female") == 0) ? "selected" : "" ?>>Female</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="age_group">
											<option value="1-17" <?= set_select('age_group', '1-17') ?> <?= (strcmp($age_group, "1-17") == 0) ? "selected" : "" ?>>1-17</option>
											<option value="18-22" <?= set_select('age_group', '18-22') ?> <?= (strcmp($age_group, "18-22") == 0) ? "selected" : "" ?>>18-22</option>
											<option value="23-30" <?= set_select('age_group', '23-30') ?> <?= (strcmp($age_group, "23-30") == 0) ? "selected" : "" ?>>23-30</option>
											<option value="31-50" <?= set_select('age_group', '31-50') ?> <?= (strcmp($age_group, "31-50") == 0) ? "selected" : "" ?>>31-50</option>
											<option value="51+" <?= set_select('age_group', '51+') ?> <?= (strcmp($age_group, "50+") == 0) ? "selected" : "" ?>>51+</option>
										</select>
									</div>
								</div>
								<?php if (in_array($group->id, array(1, 2, 3))) : ?>
									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
									<div class="form-group m-form__group row">
										<div class="col-10 ml-auto">
											<h3 class="m-form__section">3. Organizational Details</h3>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="organization" class="col-2 col-form-label">Organization</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="organization" value="<?= set_value('organization', $organization); ?>">
										</div>
									</div>
									<?php if (in_array($group->id, array(3))) : ?>
										<div class="form-group m-form__group row">
											<label for="brand" class="col-2 col-form-label">Brand</label>
											<div class="col-7">
												<input class="form-control m-input" type="text" name="brand" value="<?= set_value('brand', $brand); ?>">
											</div>
										</div>
									<?php endif ?>
									<div class="form-group m-form__group row">
										<label for="phone" class="col-2 col-form-label">Phone No.</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="phone" value="<?= set_value('phone', $phone); ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="address1" class="col-2 col-form-label">Address Line 1</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="address1" value="<?= set_value('address1', $address1); ?>">
											<span class="m-form__help">Street address, P.O box, company name, c/o</span>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="address2" class="col-2 col-form-label">Address Line 2</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="address2" value="<?= set_value('address2', $address2); ?>">
											<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="city" class="col-2 col-form-label">City</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="city" value="<?= set_value('city', $city); ?>">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="state" class="col-2 col-form-label">State</label>
										<div class="col-2">
											<select class="form-control m-input" id="exampleSelect1" name="state">
												<?php foreach ($states as $s) : ?>
													<option value="<?= $s->statecode; ?>" <?= set_select("state", $s->statecode) ?> <?= (strcmp($state, $s->statecode) == 0) ? "selected" : "" ?>><?= $s->statecode; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="country" class="col-2 col-form-label">Country</label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="country">
												<?php foreach ($countries as $c) : ?>
													<option value="<?= $c->country_name ?>" <?= set_select("country", $c->country_name) ?> <?= (strcmp($country, $c->country_name) == 0) ? "selected" : "" ?>><?= $c->country_name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label for="zipcode" class="col-2 col-form-label">Zipcode</label>
										<div class="col-7">
											<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode', $zipcode); ?>">
										</div>
									</div>
								<?php endif ?>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">4. Privileges</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="group" class="col-2 col-form-label">Group<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="group">
											<?php foreach ($groups as $grp) : ?>
												<option value="<?= $grp->id ?>" <?= set_select("group", $grp->id) ?> <?= ($group->id == $grp->id) ? "selected" : "" ?>><?= $grp->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="active" class="col-2 col-form-label">Enabled</label>
									<div class="col-7">
										<input type="hidden" name="active" value="0" <?= set_value('active', $active) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="active" value="1" <?= set_value('active', $active) == 1 ? 'checked' : "" ?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>&nbsp;&nbsp;
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

// End page body
$this->load->view('admin_panel/templates/end_pagebody');

// Load footer
$this->load->view('admin_panel/templates/footer');

// End page section
$this->load->view('admin_panel/templates/end_page');

// Load quick sidebar
$this->load->view('admin_panel/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('admin_panel/templates/scrolltop');

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<!-- Sidemenu class -->
<script>
	<?php if ($group->id == 1 || $group->id == 2) : ?>
		$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
		$("#submenu-users-staff").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 3) : ?>
		$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
		$("#submenu-brands-members").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 4) : ?>
		$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
		$("#submenu-users-premium").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 5) : ?>
		$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
		$("#submenu-users-registered").addClass("m-menu__item  m-menu__item--active");
	<?php endif ?>
</script>