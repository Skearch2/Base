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
										<h3 class="m-form__section">Login Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="username" data-toggle="m-popover" data-content="Username should be alphanumeric and range from 5 to 12." class="col-2 col-form-label m-label"><mark>Username</mark>
										<font color="red"><sup>*</sup></font>
									</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="username" value="<?= set_value('username'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="password" data-toggle="m-popover" data-content="Password should be alphanumeric and range from 8 to 15." class="col-2 col-form-label"><mark>Password</mark>
										<font color="red"><sup>*</sup></font>
									</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="password" value="">
										<span class="m-form__help">Note: Password is Visible</span>
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
										<h3 class="m-form__section">Personal Details</h3>
									</div>
								</div>
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
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="gender">
											<option value="" <?= set_select('gender', '', TRUE) ?>>Select</option>
											<option value="male" <?= set_select('gender', 'male') ?>>Male</option>
											<option value="female" <?= set_select('gender', 'female') ?>>Female</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group<font color="red"><sup>*</sup></font></label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="age_group">
											<option value="" <?= set_select('age_group', '', TRUE) ?>>Select</option>
											<option value="1-17" <?= set_select('age_group', '1-17') ?>>1-17</option>
											<option value="18-22" <?= set_select('age_group', '18-22') ?>>18-22</option>
											<option value="23-30" <?= set_select('age_group', '23-30') ?>>23-30</option>
											<option value="31-50" <?= set_select('age_group', '31-50') ?>>31-50</option>
											<option value="51+" <?= set_select('age_group', '51+') ?>>51+</option>
										</select>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Contact Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="phone" class="col-2 col-form-label">Phone No.</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="phone" value="<?= set_value('phone', $phone); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address Line 1</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?= set_value('address1'); ?>">
										<span class="m-form__help">Street address, P.O box, company name, c/o</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address2" class="col-2 col-form-label">Address Line 2</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address2" value="<?= set_value('address2'); ?>">
										<span class="m-form__help">Apartment, suite, unit, buidling, floor, etc</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="city" class="col-2 col-form-label">City</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="city" value="<?= set_value('city'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="state" class="col-2 col-form-label">State</label>
									<div class="col-2">
										<select class="form-control m-input" id="exampleSelect1" name="state">
											<option value="" <?= set_select("state", "", TRUE) ?>>Select</option>
											<?php foreach ($states as $state) : ?>
												<option value="<?= $state->statecode; ?>" <?= set_select("state", $state->statecode) ?>><?= $state->statecode; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="country" class="col-2 col-form-label">Country</label>
									<div class="col-3">
										<select class="form-control m-input" id="exampleSelect1" name="country">
											<option value="" <?= set_select("country", "", TRUE) ?>>Select</option>
											<?php foreach ($countries as $country) : ?>
												<option value="<?= $country->country_name ?>" <?= set_select("country", $country->country_name) ?>><?= $country->country_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="zipcode" class="col-2 col-form-label">Zipcode</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="zipcode" value="<?= set_value('zipcode'); ?>">
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Association</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="brand" class="col-2 col-form-label">Brand<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input type="text" class="form-control m-input" id="brand-search" name="brand" placeholder="Search" value="<?= set_value('brand') ?>">
										<input type="hidden" id="brand-id" name="brand_id" value="<?= set_value('brand_id') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="key-member" class="col-2 col-form-label">Key Member<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input type="hidden" name="key_member" value="0" <?= set_value('key_member', 0) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="key_member" value="1" <?= set_value('key_member', 0) == 1 ? 'checked' : "" ?>>
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
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Create</button>
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

<script>
	// settings for brand search
	var options = {

		url: function(phrase) {
			return "<?= site_url(); ?>admin/brands/search/" + phrase
		},

		getValue: "brand",

		template: {
			type: "description",
			fields: {
				description: "organization"
			}
		},

		list: {
			match: {
				enabled: true
			},

			sort: {
				enabled: true
			},

			onSelectItemEvent: function() {
				var brand = $("#brand-search").getSelectedItemData().brand;
				var id = $("#brand-search").getSelectedItemData().id;

				$("#brand-search").val(brand).trigger("change");
				$("#brand-id").val(id);
			},

			showAnimation: {
				type: "slide", //normal|slide|fade
				callback: function() {}
			},

			hideAnimation: {
				type: "normal", //normal|slide|fade
				callback: function() {}
			}
		}
	};

	// initialize brand search
	$("#brand-search").easyAutocomplete(options);
</script>

<!-- Sidemenu class -->
<script>
	$("#menu-sales").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#leads").addClass("m-menu__item  m-menu__item--active");
</script>