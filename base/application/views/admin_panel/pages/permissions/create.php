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
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
									<?php if (validation_errors()) : ?>
										<div class="alert alert-danger" role="alert">
											<div class="alert-icon">
												<p class="flaticon-danger"> Error:</p>
												<?= validation_errors(); ?>
											</div>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('success') === 1) : ?>
										<div class="alert alert-success" role="alert">
											<div class="alert-icon">
												<p class="flaticon-like"> Success:</p>
												The permission has been created.
											</div>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('success') === 0) : ?>
										<div class="alert alert-danger" role="alert">
											<div class="alert-icon">
												<p class="flaticon-cancel"> Error:</p>
												Unable to create the permission.
											</div>
										</div>
									<?php endif; ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Permission Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="description" class="col-2 col-form-label">Description<font color="red"><sup>*</sup></font>
									</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description" value="<?= set_value('description'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="username" data-toggle="m-popover" data-content="Key must only contain alphabets and underscores" class="col-2 col-form-label"><mark>Key</mark>
										<font color="red"><sup>*</sup></font>
									</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="key" value="<?= set_value('key'); ?>">
										<span class="m-form__help">Key should be in format like: user_create</span>
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->

<script>
	$("#menu-permissions").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>