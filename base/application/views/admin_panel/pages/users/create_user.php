<?php

//echo "<pre>"; print_r($users_groups); die();
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
                                        <div class="alert-icon">
                                            <p class="flaticon-danger"> Error:</p>
                                            <?=validation_errors();?>
                                        </div>
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
                    <input class="form-control m-input" type="text" name="username" value="<?=set_value('username');?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="password" data-toggle="m-popover" data-content="Password should be alphanumeric and range from 8 to 15." class="col-2 col-form-label">Password<font color="red"><sup>*</sup></font></label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="password" value="">
                    <span class="m-form__help">Note: Password is Visible</span>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="email" class="col-2 col-form-label">Email<font color="red"><sup>*</sup></font></label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="email" value="<?=set_value('email');?>">
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
										<input class="form-control m-input" type="text" name="first_name" value="<?=set_value('first_name');?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="last_name" class="col-2 col-form-label">Last Name<font color="red"><sup>*</sup></font></label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="last_name" value="<?=set_value('last_name');?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="address1" class="col-2 col-form-label">Address 1</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="address1" value="<?=set_value('address1');?>">
									</div>
								</div>
                <div class="form-group m-form__group row">
                  <label for="address2" class="col-2 col-form-label">Address 2</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="address2" value="<?=set_value('address2');?>">
                  </div>
                </div>
								<div class="form-group m-form__group row">
									<label for="organization" class="col-2 col-form-label">Organization</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="organization" value="<?=set_value('organization');?>">
									</div>
								</div>
                <div class="form-group m-form__group row">
                  <label for="city" class="col-2 col-form-label">City</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="city" value="<?=set_value('city');?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="state" class="col-2 col-form-label">State</label>
                    <div class="col-2">
                      <select class="form-control m-input" id="exampleSelect1" name="state">
												<option value="<?=set_value('state');?>" selected disabled hidden><?php echo ((set_value('state') !== "") ? set_value('state') : 'Select'); ?></option>
												<?php foreach ($states as $state): ?>
													<option value="<?=$state->statecode;?>"><?=$state->statecode;?></option>
												<?php endforeach;?>
                      </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="country" class="col-2 col-form-label">Country</label>
                    <div class="col-3">
                      <select class="form-control m-input" id="exampleSelect1" name="country">
												<option value="<?=set_value('country');?>" selected disabled hidden><?php echo ((set_value('country') !== "") ? set_value('country') : 'Select'); ?></option>
												<?php foreach ($countries as $country): ?>
													<option value="<?=$country->country_name;?>"><?=$country->country_name;?></option>
												<?php endforeach;?>
                      </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="zip" class="col-2 col-form-label">Zip</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text"name="zip" value="<?=set_value('zip');?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="phone" class="col-2 col-form-label">Phone No.</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="phone" value="<?=set_value('phone');?>">
                  </div>
                </div>
								<div class="form-group m-form__group row">
									<label for="gender" class="col-2 col-form-label">Gender<font color="red"><sup>*</sup></font></label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="gender">
												<option value="<?php echo ((set_value('gender') !== "") ? ucfirst(set_value('gender')) : 'other'); ?>" selected disabled hidden><?php echo ((set_value('gender') !== "") ? ucfirst(set_value('gender')) : 'Select'); ?></option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
									</div>
								 </div>
								<div class="form-group m-form__group row">
									<label for="age_group" class="col-2 col-form-label">Age Group<font color="red"><sup>*</sup></font></label>
										<div class="col-3">
											<select class="form-control m-input" id="exampleSelect1" name="age_group">
												<option value="<?php echo ((set_value('age_group') !== "") ? set_value('age_group') : '18-22'); ?>" selected disabled hidden><?php echo ((set_value('age_group') !== "") ? set_value('age_group') : 'Select'); ?></option>
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
												<option value="<?=set_value('group');?>" selected disabled hidden><?php echo ((set_value('country') !== "") ? set_value('group') : 'Select'); ?></option>
												<?php foreach ($users_groups as $group): ?>
													<option value="<?=$group->id;?>"><?=$group->name;?></option>
												<?php endforeach;?>
                      </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="active" class="col-2 col-form-label">Enabled</label>
                  <div class="col-7">
                    <input type="hidden" name="active" value="0" <?php if (set_value('active') == 0) {
    echo 'checked';
}
?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="active" value="1" <?php echo ((set_value('active') == 0) ? '' : 'checked'); ?>>
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
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Add</button>&nbsp;&nbsp;
											<button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Clear</button>
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
