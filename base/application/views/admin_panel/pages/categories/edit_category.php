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
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
                                <?php echo $this->session->tempdata('success-msg'); ?>
                                <?php if (validation_errors()): ?>
                                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="alert-icon">
                                            <p class="flaticon-danger"> Error:</p>
                                            <?=validation_errors();?>
                                        </div>
									</div>
                                <?php endif;?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Umbrella Information</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Title</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="title" value="<?php if(isset($category[0]->title)) echo $category[0]->title; else if(form_error('title') == '') echo set_value('title');?>" required>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Description</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description" value="<?php if(isset($category[0]->description)) echo $category[0]->description; else if(form_error('description') == '') echo set_value('description');?>" >
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Short Description</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description_short" value="<?php if(isset($category[0]->description_short)) echo $category[0]->description_short; else if(form_error('description_short') == '') echo set_value('description_short');?>" required>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Umbrella Name</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="umbrella_name" value="<?php if(isset($category[0]->umbrella_name)) echo $category[0]->umbrella_name; else if(form_error('umbrella_name') == '') echo set_value('umbrella_name');?>">
									</div>
								</div>
                <div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Home Display Name</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="home_display" value="<?php if(isset($category[0]->home_display)) echo $category[0]->home_display; else if(form_error('home_display') == '') echo set_value('home_display');?>">
									</div>
								</div>
                <div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Keywords</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="keywords" value="<?php if(isset($category[0]->keywords)) echo $category[0]->keywords; else if(form_error('keywords') == '') echo set_value('keywords');?>" required>
                    <span class="m-form__help">Seperated by comma (,)</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Featured</label>
                  <div class="col-7">
							      <input type="hidden" name="featured" value="0" <?php if(isset($category[0]->featured) && $category[0]->featured == 0) echo "checked"; else echo set_checkbox('featured', '0');?>>
							      <span class="m-switch m-switch--icon-check">
								     <label>
									    <input type="checkbox" name="featured" value="1" <?php if(isset($category[0]->featured) && $category[0]->featured == 1) echo "checked"; else echo set_checkbox('featured', '1');?>>
							         <span></span>
							       </label>
							      </span>
					   	</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Enabled</label>
									<div class="col-7">
                    <input type="hidden" name="enabled" value="0" <?php if(isset($category[0]->enabled) && $category[0]->enabled == 0) echo "checked"; else echo set_checkbox('enabled', '0'); ?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="enabled" value="1" <?php if(isset($category[0]->enabled) && $category[0]->enabled == 1) echo "checked"; else echo set_checkbox('enabled', '1'); ?>>
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
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>&nbsp;&nbsp;
											<button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Reset</button>
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
$("#smenu_data").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>
