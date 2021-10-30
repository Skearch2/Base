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
						<form class="m-form m-form--fit m-form--label-align-right" role="form" id="m_form" method="POST" onsubmit="$('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom m-loader m-loader--light m-loader--right')">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="m-portlet__body">
								<?php if ($this->session->flashdata('success') === 1) : ?>
									<div class="m-form__content">
										<div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
											<div class="m-alert__icon">
												<i class="la la-check-circle"></i>
											</div>
											<div class="m-alert__text">
												The email invite has been sent successfully.
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
												Unable to sent the email invite.
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
								<div class="form-group m-form__group row">
									<div class="col-lg-12 m-form__group-sub" id="recipents">
										<div class="input-group">
											<a href="javascript:void(0);" class="input-group-prepend" id="add_recipent" title="Add recipents" style="text-decoration:none"><span class="input-group-text"><i class="fa fa-plus-circle" style="color:green"></i></span></a>
											<input type="text" class="form-control m-input" name="recipents[]" placeholder="Email Address">
										</div>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-1x"></div>
								<div class=" form-group m-form__group row">
									<div class="col-lg-12 m-form__group-sub">
										<input type="text" name="subject" class="form-control m-input" placeholder="Subject" value="<?= set_value('subject'); ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<textarea name="content" id="html-editor" size="40"><?= set_value('content'); ?></textarea>
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-2">
										</div>
										<div class="col-7">
											<button type="submit" id="btn-submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Send</button>
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
	var FormControls = {
		init: function() {
			$("#m_form").validate({
				rules: {
					recipents: {
						required: 1, // TODO: validation does not work here, need a work around
						email: 1
					},
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

	// custom button function
	var signupLink = function(context) {
		var ui = $.summernote.ui;

		// create button
		var button = ui.button({
			contents: '<i class="fa fa-paper-plane"/>',
			tooltip: 'Sign-up Link',
			click: function() {
				var node = document.createElement('span');
				// invoke insertText method with 'hello' on editor module.
				node.innerHTML = '<a href="http://www.skearch.com/signup" target="_blank">Sign Up for Skearch today.</a>';
				context.invoke('editor.insertNode', node);
			}
		});

		return button.render(); // return button as jquery object
	}

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
				['insert', ['table', 'link', 'signupLink', 'picture', 'video']],
				['other', ['fullscreen', 'code', 'help']]
			],
			buttons: {
				signupLink: signupLink
			},
			height: 300
		});

		var maxField = 10; //Input fields increment limitation
		var addButton = $('#add_recipent'); //Add button selector
		var wrapper = $('#recipents'); //Input field wrapper
		var fieldHTML = '<div class="input-group"><a href="javascript:void(0);" class="input-group-prepend" id="remove_recipent" title="Remove recipent" style="text-decoration:none"><span class="input-group-text"><i class="fa fa-minus-circle" style="color:red"></i></span></a>\
						 <input type="text" class="form-control m-input" name="recipents[]" placeholder="Email Address"></div>' //Input field
		var x = 1; //Initial field counter is 1

		//Once add button is clicked
		$(addButton).click(function() {
			//Check maximum number of input fields
			if (x < maxField) {
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});

		//Once remove button is clicked
		$(wrapper).on('click', '#remove_recipent', function(e) {
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});

	$("#menu-sales").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#invite").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>