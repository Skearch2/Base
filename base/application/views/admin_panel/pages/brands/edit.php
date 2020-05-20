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
										<h3 class="m-form__section">Brand Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="brand" class="col-2 col-form-label">Brand<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="brand" value="<?= set_value('brand', $brand); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="organization" class="col-2 col-form-label">Organization<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="organization" value="<?= set_value('organization', $organization); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address Line 1<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?= set_value('address1', $address1); ?>">
										<span class="m-form__help">Street address, P.O box, company name, c/o</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address2" class="col-2 col-form-label">Address Line 2<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address2" value="<?= set_value('address2', $address2); ?>">
										<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="city" class="col-2 col-form-label">City<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="city" value="<?= set_value('city', $city); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="state" class="col-2 col-form-label">State<font color="red"><sup>*</sup></font></label>
									<div class="col-2">
										<select class="form-control m-input" id="exampleSelect1" name="state">
											<?php foreach ($states as $s) : ?>
												<option value="<?= $s->statecode; ?>" <?= set_select("state", $s->statecode) ?> <?= (strcmp($state, $s->statecode) == 0) ? "selected" : "" ?>><?= $s->statecode; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="country" class="col-2 col-form-label">Country<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="country">
											<?php foreach ($countries as $c) : ?>
												<option value="<?= $c->country_name ?>" <?= set_select("country", $c->country_name) ?> <?= (strcmp($country, $c->country_name) == 0) ? "selected" : "" ?>><?= $c->country_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="zipcode" class="col-2 col-form-label">Zipcode<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode', $zipcode); ?>">
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
	$("#menu-users").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	<?php if ($group->id == 1 || $group->id == 2) : ?>
		$("#submenu-users-staff").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 3) : ?>
		$("#submenu-users-brand_users").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 4) : ?>
		$("#submenu-users-premium").addClass("m-menu__item  m-menu__item--active");
	<?php elseif ($group->id == 5) : ?>
		$("#submenu-users-registered").addClass("m-menu__item  m-menu__item--active");
	<?php endif ?>
</script>