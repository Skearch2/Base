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
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="la la-dashboard"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Dashboard
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-pricing-table-1">
				<div class="m-pricing-table-1__items row">
					<div class="m-pricing-table-1__item col-lg-3">
						<div class="m-pricing-table-1__visual">
							<div class="m-pricing-table-1__hexagon1"></div>
							<div class="m-pricing-table-1__hexagon2"></div>
							<span class="m-pricing-table-1__icon m--font-secondary"><i class="fa fa-shopping-bag"></i></span>
						</div>
						<span class="m-pricing-table-1__price">Brand</span>
						<span class="m-pricing-table-1__description">
							Ads under Brand<br>
							<br>
						</span>
						<div class="m-pricing-table-1__btn">
							<div class="m-dropdown m-dropdown--up m-dropdown--inline m-dropdown--align-center" m-dropdown-toggle="click" aria-expanded="true">
								<a href="#" class="m-dropdown__toggle btn btn-brand m-btn m-btn--custom m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm dropdown-toggle">
									Choose
								</a>
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<div class="m-scrollable m-scroller ps" data-flip="true" data-scrollable="true">
													<ul class="m-nav">
														<?php foreach ($brands as $brand) : ?>
															<li class="m-nav__item">
																<a class="m-nav__link" href="<?= site_url("admin/brands/ads/brand/id/{$brand->id}/show/library") ?>"><?= $brand->brand ?></a>
															</li>
														<?php endforeach; ?>
													</ul>
													<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
														<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
													</div>
													<div class="ps__rail-y" style="top: 0px; right: 4px; height: 200px;">
														<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 106px;"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-pricing-table-1__item col-lg-3">
						<div class="m-pricing-table-1__visual">
							<div class="m-pricing-table-1__hexagon1"></div>
							<div class="m-pricing-table-1__hexagon2"></div>
							<span class="m-pricing-table-1__icon m--font-secondary"><i class="fa fa-globe"></i></span>
						</div>
						<span class="m-pricing-table-1__price">Global</span>
						<span class="m-pricing-table-1__description">
							Ads shown on all pages<br>
							(if Umbrella/Field ads are not setup)
						</span>
						<div class="m-pricing-table-1__btn">
							<a href="<?= site_url('admin/ads/manager/view/global/banner/a/show/library') ?>" class="btn btn-brand m-btn m-btn--custom m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm">
								View
							</a>
						</div>
					</div>
					<div class="m-pricing-table-1__item col-lg-3">
						<div class="m-pricing-table-1__visual">
							<div class="m-pricing-table-1__hexagon1"></div>
							<div class="m-pricing-table-1__hexagon2"></div>
							<span class="m-pricing-table-1__icon m--font-secondary"><i class="fa fa-umbrella"></i></span>
						</div>
						<span class="m-pricing-table-1__price">Umbrella</span>
						<span class="m-pricing-table-1__description">
							Ads shown on<br>
							Umbrella pages
						</span>
						<div class="m-pricing-table-1__btn">
							<div class="m-dropdown m-dropdown--up m-dropdown--inline m-dropdown--align-center" m-dropdown-toggle="click" aria-expanded="true">
								<a href="#" class="m-dropdown__toggle btn btn-brand m-btn m-btn--custom m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm dropdown-toggle">
									Choose
								</a>
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<div class="m-scrollable m-scroller ps" data-flip="true" data-scrollable="true">
													<ul class="m-nav">
														<?php foreach ($umbrellas as $umbrella) : ?>
															<li class="m-nav__item">
																<a class="m-nav__link" href="<?= site_url("admin/ads/manager/view/umbrella/id/{$umbrella->id}/banner/a/show/library") ?>"><?= $umbrella->title ?></a>
															</li>
														<?php endforeach; ?>
													</ul>
													<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
														<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
													</div>
													<div class="ps__rail-y" style="top: 0px; right: 4px; height: 200px;">
														<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 106px;"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-pricing-table-1__item col-lg-3">
						<div class="m-pricing-table-1__visual">
							<div class="m-pricing-table-1__hexagon1"></div>
							<div class="m-pricing-table-1__hexagon2"></div>
							<span class="m-pricing-table-1__icon m--font-secondary"><i class="fa fa-th"></i></span>
						</div>
						<span class="m-pricing-table-1__price">Field</span>
						<span class="m-pricing-table-1__description">
							Ads shown on<br>
							Field pages
						</span>
						<div class="m-pricing-table-1__btn">
							<div class="m-dropdown m-dropdown--up m-dropdown--inline m-dropdown--align-center" m-dropdown-toggle="click" aria-expanded="true">
								<a href="#" class="m-dropdown__toggle btn btn-brand m-btn m-btn--custom m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm dropdown-toggle">
									Choose
								</a>
								<div class="m-dropdown__wrapper">
									<div class="m-dropdown__inner">
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<div class="m-scrollable m-scroller ps" data-flip="true" data-scrollable="true">
													<ul class="m-nav">
														<?php foreach ($fields as $field) : ?>
															<li class="m-nav__item">
																<a class="m-nav__link" href="<?= site_url("admin/ads/manager/view/field/id/{$field->id}/banner/a/show/library") ?>"><?= $field->title ?></a>
															</li>
														<?php endforeach; ?>
													</ul>
													<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
														<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
													</div>
													<div class="ps__rail-y" style="top: 0px; right: 4px; height: 200px;">
														<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 106px;"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-pricing-table-1__item col-lg-3">
						<div class="m-pricing-table-1__visual">
							<div class="m-pricing-table-1__hexagon1"></div>
							<div class="m-pricing-table-1__hexagon2"></div>
							<span class="m-pricing-table-1__icon m--font-secondary"><i class="fa fa-circle-notch"></i></span>
						</div>
						<span class="m-pricing-table-1__price">Default</span>
						<span class="m-pricing-table-1__description">
							Ads shown on all pages<br>
							(if Global/Umbrella/Field ads are not setup)
						</span>
						<div class="m-pricing-table-1__btn">
							<a href="<?= site_url('admin/ads/manager/view/default/banner/a/show/library') ?>" class="btn btn-brand m-btn m-btn--custom m-btn--wide m-btn--uppercase m-btn--bolder m-btn--sm">
								View
							</a>
						</div>
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
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-ads-manager").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>