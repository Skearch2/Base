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
$this->load->view('my_skearch/templates/header_menu');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>
<div class="m-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--rounded">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link active" data-toggle="tab" href="#profile" role="tab">
									<i class="flaticon-share m--hide"></i>
									Submit Media
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="profile">
						<?= form_open('', 'id="m_form"'); ?>
						<fieldset class="m-form m-form--fit m-form--label-align-right">
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
										<h3 class="m-form__section">Media</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="media-upload" class="col-2 col-form-label"></label>
									<div class="col-7 custom-file">
										<input type="file" class="custom-file-input" name="media">
										<label class="custom-file-label" for="media">Add Media</label>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class="form-group m-form__group row">
									<div class="col-10 ml-auto">
										<h3 class="m-form__section">Details</h3>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="title" class="col-2 col-form-label">Title *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="title" value="<?= set_value('title') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="link" class="col-2 col-form-label">Link *</label>
									<div class="col-7">
										<input class="form-control m-input" type="text" name="url" value="<?= set_value('url') ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="note" class="col-2 col-form-label">Note</label>
									<div class="col-lg-7 col-md-9 col-sm-12">
										<textarea class="form-control" name="note" rows="5"><?= set_value('note') ?></textarea>
									</div>
								</div>
								<div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-2">
												</div>
												<div class="col-7">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
												</div>
											</div>
										</div>
									</div>
						</fieldset>
						<?= form_close(); ?>
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

// Load global JS files
$this->load->view('my_skearch/templates/js_global');

?>

<script>
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					media: {
						required: 1
					},
					title: {
						required: 1
					},
					url: {
						required: 1,
						url: 1
					},
					note: {
						maxlength: 5000
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
</script>

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>