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
						<form class="m-form m-form--fit m-form--label-align-right" id="m_form" role="form" method="POST">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
							<div class="m-portlet__body">
								<?php if (validation_errors()) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-warning"></i>
											</div>
											<div class="m-alert__text">
												<?= validation_errors() ?>
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php endif ?>
								<div class="m-form__content">
									<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_msg">
										<div class="m-alert__icon">
											<i class="la la-warning"></i>
										</div>
										<div class="m-alert__text">
											There are some errors found in the form, please check and try submitting again!
										</div>
										<div class="m-alert__close">
											<button type="button" class="close" data-close="alert" aria-label="Close">
											</button>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Field Information</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<input type="hidden" name="field_id" value="<?= $field->id ?>">
									<label for="example-text-input" class="col-2 col-form-label">Title *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="title" value="<?= set_value('title', $field->title) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Description</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description" value="<?= set_value('description', $field->description) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Hover Over Info *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="description_short" value="<?= set_value('description_short', $field->description_short) ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Umbrella *</label>
									<div class="col-7">
										<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="parent_id">
											<?php foreach ($umbrellas as $umbrella) : ?>
												<option value="<?= $umbrella->id ?>" <?= set_select("parent_id", $umbrella->id) ?> <?= ($umbrella->id == $field->parent_id) ? "selected" : "" ?>><?= $umbrella->title ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Home Display Name*</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="home_display" value="<?= set_value('home_display', $field->home_display); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Keyword(s)*</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="keywords" data-role="tagsinput" value="<?= set_value('keywords', $keywords) ?>">
										<span class="m-form__help">Press Enter after each keyword to continue adding more.</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Featured</label>
									<div class="col-7">
										<input type="hidden" name="featured" value="0" <?= set_value('featured', $field->featured) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="featured" value="1" <?= set_value('featured', $field->featured) == 1 ? 'checked' : "" ?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="example-text-input" class="col-2 col-form-label">Enabled</label>
									<div class="col-7">
										<input type="hidden" name="enabled" value="0" <?= set_value('enabled', $field->enabled) == 0 ? 'checked' : "" ?>>
										<span class="m-switch m-switch--icon-check">
											<label>
												<input type="checkbox" name="enabled" value="1" <?= set_value('enabled', $field->enabled) == 1 ? 'checked' : "" ?>>
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
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
										</div>
										<div class="col-3">
											<small>* Indicates required field</small>
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

<script src="<?= site_url(ASSETS) ?>/admin_panel/demo/demo12/custom/crud/forms/widgets/tagsinput.js" type="text/javascript"></script>

<script>
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					title: {
						required: 1
					},
					description_short: {
						required: 1
					},
					parent_id: {
						required: 1
					},
					home_display: {
						required: 1
					},
					keywords: {
						required: 1
					}
				},
				invalidHandler: function(e, r) {
					$("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
				},
				submitHandler: function(e) {
					form.submit();
				},
			});
		}
	};

	$(document).ready(function() {
		FormControls.init();
	});

	$("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-results-fields").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>