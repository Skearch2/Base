<?php
//echo "<pre>"; print_r($country); die();
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
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
                  <?php if (validation_errors()): ?>
  									<div class="alert alert-danger" role="alert">
  										<?=validation_errors();?>
  									</div>
                  <?php endif;?>
								</div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">1. Login Details</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="username" data-toggle="m-popover" data-content="Username should be alphanumeric and range from 5 to 12." class="col-2 col-form-label">Username<font color="red"><sup>*</sup></font></label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="username" value="<?=$username;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="email" class="col-2 col-form-label">Email<font color="red"><sup>*</sup></font></label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="email" value="<?=$email;?>">
                  </div>
                </div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">2. Personal Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="first_name" class="col-2 col-form-label">First Name<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="first_name" value="<?=$first_name;?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="last_name" class="col-2 col-form-label">Last Name<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="last_name" value="<?=$last_name;?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address 1</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?=$address1;?>">
									</div>
								</div>
                <div class="form-group m-form__group row">
                  <label for="address2" class="col-2 col-form-label">Address 2</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="address2" value="<?=$address2;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="organization" class="col-2 col-form-label">Organization</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="organization" value="<?=$organization;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="city" class="col-2 col-form-label">City</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="city" value="<?=$city;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="state" class="col-2 col-form-label">State</label>
                    <div class="col-2">
                      <select class="form-control m-input" id="exampleSelect1" name="state">
												<option value="<?=$state;?>" selected><?=$state;?></option>
												<?php $user_state = $state;?>
												<?php foreach ($states as $state): ?>
													<?php if (!strcmp($user_state, $state->statecode)): ?>
														<?php continue;?>
													<?php endif;?>
													<option value="<?=$state->statecode;?>"><?=$state->statecode;?></option>
												<?php endforeach;?>
                      </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="country" class="col-2 col-form-label">Country</label>
                    <div class="col-3">
                      <select class="form-control m-input" id="exampleSelect1" name="country">
												<option value="<?=$country;?>" selected><?=$country;?></option>
												<?php $user_country = $country;?>
												<?php foreach ($countries as $country): ?>
													<?php if (!strcmp($user_country, $country->country_name)): ?>
														<?php continue;?>
													<?php endif;?>
													<option value="<?=$country->country_name;?>"><?=$country->country_name;?></option>
												<?php endforeach;?>
											</select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="zip" class="col-2 col-form-label">Zip</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="zip" value="<?=$zip;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="phone" class="col-2 col-form-label">Phone No.</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="phone" value="<?=$phone;?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender<font color="red"><sup>*</sup></font></label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="gender">
                        <option value="<?php echo ($this->input->post('gender') !== null) ? $this->input->post('gender') : $gender; ?>" selected hidden><?php echo ($this->input->post('gender') !== null) ? ucfirst($this->input->post('gender')) : ucfirst($gender); ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
									</div>
								 </div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group<font color="red"><sup>*</sup></font></label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="age_group">
												<option value="<?php echo ($this->input->post('age_group') !== null) ? $this->input->post('age_group') : $age_group; ?>" selected hidden><?php echo ($this->input->post('age_group') !== null) ? $this->input->post('age_group') : $age_group; ?></option>
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
										<h3 class="m-form__section">3. Additional Details</h3>
									</div>
								</div>
                <div class="form-group m-form__group row">
                  <label for="group" class="col-2 col-form-label">Group<font color="red"><sup>*</sup></font></label>
                    <div class="col-3">
                      <select class="form-control m-input" id="exampleSelect1" name="group">
												<option value="<?=$user_group->id;?>" selected><?=$user_group->name;?></option>
												<?php foreach ($users_groups as $group): ?>
													<?php if ($user_group->id == $group->id) {
    continue;
}
?>
													<option value="<?=$group->id;?>"><?=$group->name;?></option>
												<?php endforeach;?>
                      </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="active" class="col-2 col-form-label">Enabled</label>
									<div class="col-7">
                    <input type="hidden" name="active" value="0" <?php if ($active == 0) {
    echo "checked";
}
?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="active" value="1" <?php if ($active == 1) {
    echo "checked";
}
?>>
                            <span></span>
                        </label>
                    </span>
									</div>
                </div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
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
					<div class="tab-pane " id="m_user_profile_tab_2">
					</div>
					<div class="tab-pane " id="m_user_profile_tab_3">
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
$("#smenu_user").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>
