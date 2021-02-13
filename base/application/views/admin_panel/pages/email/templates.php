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
						<form class="m-form m-form--fit m-form--label-align-right" id="m_form" role="form" method="POST" action="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="m-portlet__body">
								<?php if ($this->session->flashdata('success') === 1) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-check-circle"></i>
											</div>
											<div class="m-alert__text">
												The email template has been updated.
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php elseif ($this->session->flashdata('success') === 0) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-times-circle"></i>
											</div>
											<div class="m-alert__text">
												Unable to update the email template.
											</div>
											<div class="m-alert__close">
												<button type="button" class="close" data-close="alert" aria-label="Close">
												</button>
											</div>
										</div>
									</div>
								<?php elseif (validation_errors()) : ?>
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
								<div class="form-group m-form__group m--margin-top-10 m--show">
									<!-- <div class="m-section">
										<span class="m-section__sub">
											<b>Information on how to use variables:</b>
										</span>
										<div class="m-section__content">
											<table class="table table-sm m-table m-table--head-bg-brand">
												<thead class="thead-inverse">
													<tr>
														<th>Variable</th>
														<th>Code</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Username</td>
														<td>{username}</td>
													</tr>
													<tr>
														<td>Link</td>
														<td>{link}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div> -->
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12 m-form__group-sub">
										<input type="text" name="subject" class="form-control m-input" placeholder="Subject" value="<?= $subject; ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<textarea name="body" id="html-editor" size="40"><?= $body; ?></textarea>
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" id="btn-submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
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
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					subject: {
						required: 1
					},
					content: {
						required: 1
					}
				},
				invalidHandler: function(e, r) {
					$("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
					$('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom');
				},
				submitHandler: function(e) {
					form.submit();
				},
			});
		}
	};
	$(document).ready(function() {
		FormControls.init();
		$('#html-editor').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['clear', ['clear']],
				['fontsize', ['style', 'fontname', 'fontsize']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['table', 'link', 'picture', 'video']],
				['other', ['fullscreen', 'code', 'help']]
			],
			height: 300
		});
	});
</script>


<script>
	$("#menu-email").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-templates").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>