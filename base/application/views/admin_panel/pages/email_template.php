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
						<form class="m-form m-form--fit m-form--label-align-right" id="postForm" role="form" method="POST" action="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="m-portlet__body">
								<div class="form-group m-form__group m--margin-top-10 m--show">
									<?php if (validation_errors()) : ?>
										<div class="alert alert-danger" role="alert">
											<?= validation_errors(); ?>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('template_update_success')) : ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
											<?= $this->session->flashdata('template_update_success'); ?>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('template_update_fail')) : ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
											<?= $this->session->flashdata('template_update_fail'); ?>
										</div>
									<?php endif; ?>

									<div class="m-section">
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
														<td>First Name</td>
														<td>{firstname}</td>
													</tr>
													<tr>
														<td>Last Name</td>
														<td>{lastname}</td>
													</tr>
													<tr>
														<td>Link</td>
														<td>{link}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12 m-form__group-sub">
										<input type="text" name="subject" class="form-control m-input" placeholder="Subject" value="<?= $subject; ?>">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<textarea name="body" id="summernote" size="40"><?= $body; ?></textarea>
									</div>
								</div>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-12">
											<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save</button>&nbsp;&nbsp;
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
	$(document).ready(function() {
		$('#summernote').summernote({
			height: 300
		});
	});
</script>


<script>
	$("#menu-templates").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>