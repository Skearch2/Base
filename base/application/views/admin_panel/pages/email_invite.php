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
						<form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST" onsubmit="$('#btn-submit').attr('class', 'btn btn-accent m-btn m-btn--air m-btn--custom m-loader m-loader--light m-loader--right')">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
									<?php if (validation_errors()) : ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
											<?= validation_errors(); ?>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('email_sent_success')) : ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
											<?= $this->session->flashdata('email_sent_success'); ?>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('email_sent_failed')) : ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
											<?= $this->session->flashdata('email_sent_failed'); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-9 m-form__group-sub" id="recipents">
										<div class="input-group">
											<a href="javascript:void(0);" class="input-group-prepend" id="add_recipent" title="Add recipents" style="text-decoration:none"><span class="input-group-text"><i class="fa fa-plus-circle" style="color:green"></i></span></a>
											<input type="text" class="form-control m-input" name="recipents[]" placeholder="Email Address">
										</div>
									</div>
								</div>
								<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
								<div class=" form-group m-form__group row">
									<div class="col-lg-9 m-form__group-sub">
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
	// initialize html editor
	$(document).ready(function() {
		$('#html-editor').summernote({
			height: 300
		});
	});

	$(document).ready(function() {
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
</script>


<script>
	$("#menu-invite").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>