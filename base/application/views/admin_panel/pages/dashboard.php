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

	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-4">

			<!--begin:: Packages-->
			<div class="m-portlet m-portlet--full-height m-portlet--fit m-portlet--unair">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Results
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">

					<!--begin::Widget 29-->
					<div class="m-widget29">
						<div class="m-widget_content">
							<h3 class="m-widget_content-title">Umbrellas</h3>
							<div class="m-widget_content-items">
								<div class="m-widget_content-item">
									<span>Active</span>
									<span><a class="m--font-success" href="<?= site_url('admin/results/umbrellas/status/active') ?>"><?= $stats->total_umbrellas_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Inactive</span>
									<span><a class="m--font-danger" href="<?= site_url('admin/results/umbrellas/status/inactive') ?>"><?= $stats->total_umbrellas - $stats->total_umbrellas_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Total</span>
									<span><a class="m--font-primary" href="<?= site_url('admin/results/umbrellas/status/all') ?>"><?= $stats->total_umbrellas ?></a></span>
								</div>
							</div>
						</div>
						<div class="m-widget_content">
							<h3 class="m-widget_content-title">Fields</h3>
							<div class="m-widget_content-items">
								<div class="m-widget_content-item">
									<span>Active</span>
									<span><a class="m--font-success" href="<?= site_url('admin/results/fields/status/active') ?>"><?= $stats->total_fields_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Inactive</span>
									<span><a class="m--font-danger" href="<?= site_url('admin/results/fields/status/inactive') ?>"><?= $stats->total_fields - $stats->total_fields_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Total</span>
									<span><a class="m--font-primary" href="<?= site_url('admin/results/fields/status/all') ?>"><?= $stats->total_fields ?></a></span>
								</div>
							</div>
						</div>
						<div class="m-widget_content">
							<h3 class="m-widget_content-title">Links</h3>
							<div class="m-widget_content-items">
								<div class="m-widget_content-item">
									<span>Live</span>
									<span><a class="m--font-info"><?= $stats->total_links_live ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Active</span>
									<span><a class="m--font-success" href="<?= site_url('admin/results/links/status/active') ?>"><?= $stats->total_links_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Inactive</span>
									<span><a class="m--font-danger" href="<?= site_url('admin/results/links/status/inactive') ?>"><?= $stats->total_links - $stats->total_links_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Total</span>
									<span><a class="m--font-primary" href="<?= site_url('admin/results/links/status/all') ?>"><?= $stats->total_links ?></a></span>
								</div>
							</div>
						</div>
					</div>
					<!--end::Widget 29-->
				</div>
			</div>

			<!--end:: Packages-->
		</div>
		<div class="col-xl-4">

			<!--begin:: Packages-->
			<div class="m-portlet m-portlet--full-height m-portlet--fit m-portlet--unair">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Brands
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">

					<!--begin::Widget 29-->
					<div class="m-widget29">
						<div class="m-widget_content">
							<h3 class="m-widget_content-title">Brand Links</h3>
							<div class="m-widget_content-items">
								<div class="m-widget_content-item">
									<span>Active</span>
									<span><a class="m--font-success" href="<?= site_url('admin/results/links/branddirect/status/active') ?>"><?= $brand_stats->total_brandlinks_active ?></a></span>
								</div>
								<div class="m-widget_content-item">
									<span>Inactive</span>
									<span><a class="m--font-danger" href="<?= site_url('admin/results/links/branddirect/status/inactive') ?>"><?= $brand_stats->total_brandlinks_inactive ?></a></span>
								</div>
							</div>
						</div>
					</div>
					<!--end::Widget 29-->
				</div>
			</div>

			<!--end:: Packages-->
		</div>
		<div class="col-xl-4">

			<!--begin:: Widgets/Top Products-->
			<div class="m-portlet m-portlet--half-height m-portlet--fit m-portlet--unair">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Link Checker
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						<button type="button" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--pill"><i class="la la-play"></i></button>
						<button type="button" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--pill"><i class="la la-stop"></i></button>
					</div>
				</div>

				<div class="m-portlet__body">

					<!--begin::Widget5-->
					<div class="m-widget4 m-widget4--chart-bottom" style="min-height: 480px">
						<div class="m-section m-section--last">
							<div class="m-section__content">
								<div class="m--space-10"></div>
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%" title="0%" data-toggle="m-tooltip" data-placement="bottom" data-skin="dark"></div>
								</div>
								<div class="m--space-10"></div>
								<button type="button" class="m-btn btn btn-success">View Links<i class="la la-external-link"></i></button>
							</div>
						</div>
					</div>
					<!--end::Widget 5-->
				</div>
			</div>
			<!--end:: Widgets/Top Products-->
		</div>
	</div>
	<!--End::Section-->
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

<!-- Sidemenu class -->
<script>
	$("#menu-dashboard").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>