<!-- begin::Header -->
<header id="m_header" class="m-grid__item		m-header " m-minimize="minimize" m-minimize-mobile="minimize" m-minimize-offset="10" m-minimize-mobile-offset="10">
	<div class="m-header__top">
		<div class="m-container m-container--fluid m-container--full-height m-page__container">
			<div class="m-stack m-stack--ver m-stack--desktop">

				<!-- begin::Brand -->
				<div class="m-stack__item m-brand m-stack__item--left">
					<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
						<div class="m-stack__item m-stack__item--middle m-brand__logo">
							<a href="<?= site_url(); ?>" class="m-brand__logo-wrapper">
								<img alt="" src="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/media/img/logo/logo.png" class="m-brand__logo-default" />
								<img alt="" src="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/media/img/logo/logo_inverse.png" class="m-brand__logo-inverse" />
							</a>
						</div>
						<div class="m-stack__item m-stack__item--middle m-brand__tools">

							<!-- begin::Responsive Header Menu Toggler-->
							<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
								<span></span>
							</a>

							<!-- end::Responsive Header Menu Toggler-->

							<!-- begin::Topbar Toggler-->
							<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
								<i class="flaticon-more"></i>
							</a>

							<!--end::Topbar Toggler-->
						</div>
					</div>
				</div>

				<!-- end::Brand -->

				<!--begin::Search-->
				<div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable- m-header-search--skin-" id="m_quicksearch_manual" m-quicksearch-mode="default">

					<!--begin::Search Form -->
					<form class="m-header-search__form" action="javascript:void(0)" onsubmit="search($('#search_keyword').val())">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
						<div class="m-header-search__wrapper">
							<span class="m-header-search__icon-search" id="m_quicksearch_search">
								<i class="la la-search"></i>
							</span>
							<span class="m-header-search__input-wrapper">
								<input autocomplete="off" type="text" class="m-header-search__input" value="" placeholder="Search..." id="search_keyword">
							</span>
							<span class="m-header-search__icon-close" id="m_quicksearch_close">
								<i class="la la-remove"></i>
							</span>
							<span class="m-header-search__icon-cancel" id="m_quicksearch_cancel">
								<i class="la la-remove"></i>
							</span>
						</div>
					</form>

					<!--end::Search Form -->

					<!--begin::Search Results -->
					<!-- <div class="m-dropdown__wrapper">
						<div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
						<div class="m-dropdown__inner">
							<div class="m-dropdown__body">
								<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
									<div class="m-dropdown__content m-list-search m-list-search--skin-light">
									</div>
								</div>
							</div>
						</div>
					</div> -->

					<!--end::Search Results -->
				</div>

				<!--end::Search-->

				<!-- begin::Topbar -->
				<div class="m-stack__item m-stack__item--right m-header-head" id="m_header_nav">
					<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
						<div class="m-stack__item m-topbar__nav-wrapper">
							<ul class="m-topbar__nav m-nav m-nav--inline">
								<!-- <li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
									<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
										<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
										<span class="m-nav__link-icon"><span class="m-nav__link-icon-wrapper"><i class="flaticon-alarm"></i></span></span>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__header m--align-center">
												<span class="m-dropdown__header-title">9 New</span>
												<span class="m-dropdown__header-subtitle">User Notifications</span>
											</div>
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
														<li class="nav-item m-tabs__item">
															<a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
																Alerts
															</a>
														</li>
														<li class="nav-item m-tabs__item">
															<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">Events</a>
														</li>
														<li class="nav-item m-tabs__item">
															<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">Logs</a>
														</li>
													</ul>
													<div class="tab-content">
														<div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
															<div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
																<div class="m-list-timeline m-list-timeline--skin-light">
																	<div class="m-list-timeline__items">
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
																			<span class="m-list-timeline__text">12 new users registered</span>
																			<span class="m-list-timeline__time">Just now</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">System shutdown <span class="m-badge m-badge--success m-badge--wide">pending</span></span>
																			<span class="m-list-timeline__time">14 mins</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">New invoice received</span>
																			<span class="m-list-timeline__time">20 mins</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">DB overloaded 80% <span class="m-badge m-badge--info m-badge--wide">settled</span></span>
																			<span class="m-list-timeline__time">1 hr</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">System error - <a href="#" class="m-link">Check</a></span>
																			<span class="m-list-timeline__time">2 hrs</span>
																		</div>
																		<div class="m-list-timeline__item m-list-timeline__item--read">
																			<span class="m-list-timeline__badge"></span>
																			<span href="" class="m-list-timeline__text">New order received <span class="m-badge m-badge--danger m-badge--wide">urgent</span></span>
																			<span class="m-list-timeline__time">7 hrs</span>
																		</div>
																		<div class="m-list-timeline__item m-list-timeline__item--read">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">Production server down</span>
																			<span class="m-list-timeline__time">3 hrs</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge"></span>
																			<span class="m-list-timeline__text">Production server up</span>
																			<span class="m-list-timeline__time">5 hrs</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
															<div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
																<div class="m-list-timeline m-list-timeline--skin-light">
																	<div class="m-list-timeline__items">
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																			<a href="" class="m-list-timeline__text">New order received</a>
																			<span class="m-list-timeline__time">Just now</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
																			<a href="" class="m-list-timeline__text">New invoice received</a>
																			<span class="m-list-timeline__time">20 mins</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																			<a href="" class="m-list-timeline__text">Production server up</a>
																			<span class="m-list-timeline__time">5 hrs</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																			<a href="" class="m-list-timeline__text">New order received</a>
																			<span class="m-list-timeline__time">7 hrs</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																			<a href="" class="m-list-timeline__text">System shutdown</a>
																			<span class="m-list-timeline__time">11 mins</span>
																		</div>
																		<div class="m-list-timeline__item">
																			<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																			<a href="" class="m-list-timeline__text">Production server down</a>
																			<span class="m-list-timeline__time">3 hrs</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
															<div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
																<div class="m-stack__item m-stack__item--center m-stack__item--middle">
																	<span class="">All caught up!<br>No new logs.</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li> -->
								<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
									<a href="#" class="m-nav__link m-dropdown__toggle">
										<span class="m-topbar__userpic">
											<img src="<?= site_url(ASSETS); ?>/my_skearch/app/media/img/users/user-default.jpg" class="m--img-rounded m--marginless m--img-centered" alt="" />
										</span>
										<span class="m-nav__link-icon m-topbar__usericon  m--hide">
											<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
										</span>
										<span class="m-topbar__username m--hide"><?= ucfirst($this->session->userdata('username')) ?></span>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__header m--align-center">
												<div class="m-card-user m-card-user--skin-light">
													<div class="m-card-user__pic">
														<img src="<?= site_url(ASSETS); ?>/my_skearch/app/media/img/users/user-default.jpg" class="m--img-rounded m--marginless" alt="" />
													</div>
													<div class="m-card-user__details">
														<span class="m-card-user__name m--font-weight-500"><?= ucfirst($this->session->userdata('username')) ?></span>
														<span class="m-card-user__email m--font-weight-300"><?= $this->session->userdata('group'); ?></span>
													</div>
												</div>
											</div>
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav m-nav--skin-light">
														<li class="m-nav__section m--hide">
															<span class="m-nav__section-text">Section</span>
														</li>
														<?php if ($this->ion_auth->in_group($this->config->item('admin', 'ion_auth'))) : ?>
															<li class="m-nav__item">
																<a href="<?= base_url("admin"); ?>" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-app"></i>
																	<span class="m-nav__link-title">
																		<span class="m-nav__link-wrap">
																			<span class="m-nav__link-text">Admin Panel</span>
																		</span>
																	</span>
																</a>
															</li>
														<?php endif ?>
														<li class="m-nav__item">
															<a href="<?= base_url("myskearch/profile"); ?>" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-profile-1"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">My Profile</span>
																	</span>
																</span>
															</a>
														</li>
														<li class="m-nav__separator m-nav__separator--fit">
														</li>
														<li class="m-nav__item">
															<a href="<?= site_url("/myskearch/auth/logout"); ?>" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- end::Topbar -->
			</div>
		</div>
	</div>
	<div class="m-header__bottom">
		<div class="m-container m-container--fluid m-container--full-height m-page__container">
			<div class="m-stack m-stack--ver m-stack--desktop">

				<!-- begin::Horizontal Menu -->
				<div class="m-stack__item m-stack__item--fluid m-header-menu-wrapper">
					<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
					<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
						<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
							<li class="m-menu__item  m-menu__item--active  m-menu__item--active-tab  m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="javascript: void(0)" class="m-menu__link m-menu__toggle"><span class="m-menu__link-text">MySkearch</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item <?= (isset($section) && $section == 'dashboard') ? 'm-menu__item--active' : '' ?> " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/dashboard"); ?>" class="m-menu__link "><i class="m-menu__link-icon la la-bar-chart"></i><span class="m-menu__link-text">Dashboard</span></a></li>
										<?php if (!$this->ion_auth->in_group($this->config->item('regular', 'ion_auth'))) : ?>
											<li class="m-menu__item  <?= (isset($section) && $section == 'digital assets') ? 'm-menu__item--active' : '' ?> " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/digital_assets"); ?>" class="m-menu__link "><i class="m-menu__link-icon flaticon-coins"></i><span class="m-menu__link-text">Digital Assets</span></a></li>
											<li class="m-menu__item <?= (isset($section) && $section == 'private social') ? 'm-menu__item--active' : '' ?>" m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/private_social"); ?>" class="m-menu__link "><i class="m-menu__link-icon la la-comments"></i><span class="m-menu__link-text">Private Social</span></a></li>
										<?php endif ?>
										<?php if ($this->ion_auth->in_group($this->config->item('brand', 'ion_auth'))) : ?>
											<li class="m-menu__item  <?= (isset($section) && $section == 'brand') ? 'm-menu__item--active' : '' ?> m-menu__item--submenu m-menu__item--rel m-menu__item--submenu-tabs" m-menu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon la la-building"></i><span class="m-menu__link-text">Brands</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
												<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
													<ul class="m-menu__subnav">
														<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/brand/ads"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Ads</span></a></li>
														<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/brand/brandlinks"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">BrandLink</span></a></li>
														<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/brand/vault"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Media Vault</span></a></li>
														<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("myskearch/brand/deals"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Deal Drop</span></a></li>
													</ul>
												</div>
											</li>
										<?php endif ?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- end::Horizontal Menu -->
			</div>
		</div>
	</div>
</header>

<!-- end::Header -->