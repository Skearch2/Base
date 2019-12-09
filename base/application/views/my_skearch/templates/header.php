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

							<!-- BEGIN: Responsive Aside Left Menu Toggler -->
							<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
								<span></span>
							</a>

							<!-- END -->

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
				<div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable- m-header-search--skin-" id="m_quicksearch" m-quicksearch-mode="default">

					<!--begin::Search Form -->
					<form class="m-header-search__form">
						<div class="m-header-search__wrapper">
							<span class="m-header-search__icon-search" id="m_quicksearch_search">
								<i class="la la-search"></i>
							</span>
							<span class="m-header-search__input-wrapper">
								<input autocomplete="off" type="text" name="q" class="m-header-search__input" value="" placeholder="Search..." id="m_quicksearch_input">
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
					<div class="m-dropdown__wrapper">
						<div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
						<div class="m-dropdown__inner">
							<div class="m-dropdown__body">
								<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
									<div class="m-dropdown__content m-list-search m-list-search--skin-light">
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--end::Search Results -->
				</div>

				<!--end::Search-->

				<!-- begin::Topbar -->
				<div class="m-stack__item m-stack__item--right m-header-head" id="m_header_nav">
					<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
						<div class="m-stack__item m-topbar__nav-wrapper">
							<ul class="m-topbar__nav m-nav m-nav--inline">
								<li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
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
								</li>
								<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
									<a href="#" class="m-nav__link m-dropdown__toggle">
										<span class="m-topbar__userpic">
											<img src="<?= site_url(ASSETS); ?>/my_skearch/app/media/img/users/user-default.jpg" class="m--img-rounded m--marginless m--img-centered" alt="" />
										</span>
										<span class="m-nav__link-icon m-topbar__usericon  m--hide">
											<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
										</span>
										<span class="m-topbar__username m--hide"><?= $this->session->userdata('username'); ?></span>
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
														<span class="m-card-user__name m--font-weight-500"><?= $this->session->userdata('first_name') . " " . $this->session->userdata('last_name') ?></span>
														<a href="" class="m-card-user__email m--font-weight-300 m-link"><?= $this->session->userdata('email'); ?></a>
													</div>
												</div>
											</div>
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav m-nav--skin-light">
														<li class="m-nav__section m--hide">
															<span class="m-nav__section-text">Section</span>
														</li>
														<li class="m-nav__item">
															<a href="<?= base_url("myskearch/profile"); ?>" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-profile-1"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">My Profile</span>
																		<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
																	</span>
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="profile.html" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-share"></i>
																<span class="m-nav__link-text">Activity</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="profile.html" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-chat-1"></i>
																<span class="m-nav__link-text">Messages</span>
															</a>
														</li>
														<li class="m-nav__separator m-nav__separator--fit">
														</li>
														<li class="m-nav__item">
															<a href="profile.html" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-info"></i>
																<span class="m-nav__link-text">FAQ</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="profile.html" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																<span class="m-nav__link-text">Support</span>
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
								<li id="m_quick_sidebar_toggle" class="m-nav__item">
									<a href="#" class="m-nav__link m-dropdown__toggle">
										<span class="m-nav__link-icon m-nav__link-icon-alt"><span class="m-nav__link-icon-wrapper"><i class="flaticon-grid-menu"></i></span></span>
									</a>
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
							<li class="m-menu__item  <?php if (isset($page) && $page === 'dashboard') echo 'm-menu__item--active  m-menu__item--active-tab';
														else echo 'm-menu__item--submenu  m-menu__item--tab'; ?>  m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="<?= site_url("myskearch"); ?>/." class="m-menu__link"><span class="m-menu__link-text">Dashboard</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="dashboard" class="m-menu__link "><i class="m-menu__link-icon flaticon-support"></i><span class="m-menu__link-text">Dashboard</span></a></li>
										<li class="m-menu__item " aria-haspopup="true"><a href="index.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-file"></i><span class="m-menu__link-text">Reports</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-coins"></i><span class="m-menu__link-text">Finance</span></a></li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--submenu-tabs" m-menu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Customers</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
											<div class="m-menu__submenu  m-menu__submenu--fixed-xl m-menu__submenu--center"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<div class="m-menu__subnav">
													<ul class="m-menu__content">
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Finance Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Annual Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">HR Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">IPO Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-1"></i><span class="m-menu__link-text">Finance Margins</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-2"></i><span class="m-menu__link-text">Revenue Reports</span></a></li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Project Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Coca
																			Cola CRM</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Delta
																			Airlines Booking Site</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Malibu
																			Accounting</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Vineseed
																			Website Rewamp</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Zircon
																			Mobile App</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Mercury
																			CMS</span></a></li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">HR Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staff
																			Directory</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Client
																			Directory</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Salary
																			Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staff
																			Payslips</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Corporate
																			Expenses</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Project
																			Expenses</span></a></li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Reporting Apps</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Report Adjusments</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Sources & Mediums</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Reporting Settings</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Conversions</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Report Flows</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Audit & Logs</span></a></li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--active  m-menu__item--submenu m-menu__item--rel m-menu__item--submenu-tabs" m-menu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-add"></i><span class="m-menu__link-text">Actions</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item  m-menu__item--active " aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-diagram"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">Generate Reports</span> <span class="m-menu__link-badge"><span class="m-badge m-badge--success">2</span></span> </span></span></a></li>
													<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">Manage Orders</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Latest Orders</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Pending Orders</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Processed Orders</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Delivery Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Payments</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Customers</span></a></li>
															</ul>
														</div>
													</li>
													<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-chat-1"></i><span class="m-menu__link-text">Customer Feedbacks</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Customer Feedbacks</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Supplier Feedbacks</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Reviewed Feedbacks</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Resolved Feedbacks</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><span class="m-menu__link-text">Feedback Reports</span></a></li>
															</ul>
														</div>
													</li>
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Register Member</span></a></li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--submenu-tabs" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Reports</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
											<div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:600px"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<div class="m-menu__subnav">
													<ul class="m-menu__content">
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Finance Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Annual Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">HR Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">IPO Reports</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-1"></i><span class="m-menu__link-text">Finance Margins</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-2"></i><span class="m-menu__link-text">Revenue Reports</span></a></li>
															</ul>
														</li>
														<li class="m-menu__item">
															<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Project Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
															<ul class="m-menu__inner">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Coca
																			Cola CRM</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Delta
																			Airlines Booking Site</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Malibu
																			Accounting</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Vineseed
																			Website Rewamp</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Zircon
																			Mobile App</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Mercury
																			CMS</span></a></li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--more m-menu__item--submenu-tabs m-menu__item--icon-only" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-more-v3"></i><span class="m-menu__link-text"></span></a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--pull"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">eCommerce</span></a></li>
													<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="crud/datatable_v1.html" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-computer"></i><span class="m-menu__link-text">Audience</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Active Users</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-interface-1"></i><span class="m-menu__link-text">User Explorer</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-lifebuoy"></i><span class="m-menu__link-text">Users Flows</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-1"></i><span class="m-menu__link-text">Market Segments</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic"></i><span class="m-menu__link-text">User Reports</span></a></li>
															</ul>
														</div>
													</li>
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Marketing</span></a></li>
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-2"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap">
																	<span class="m-menu__link-text">Campaigns</span> <span class="m-menu__link-badge"><span class="m-badge m-badge--success">3</span></span> </span></span></a></li>
													<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-infinity"></i><span class="m-menu__link-text">Cloud Manager</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
														<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow "></span>
															<ul class="m-menu__subnav">
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-add"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap">
																				<span class="m-menu__link-text">File Upload</span> <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">3</span></span> </span></span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-signs-1"></i><span class="m-menu__link-text">File Attributes</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-folder"></i><span class="m-menu__link-text">Folders</span></a></li>
																<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-cogwheel-2"></i><span class="m-menu__link-text">System Settings</span></a></li>
															</ul>
														</div>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--actions" aria-haspopup="true">
											<div class="m-menu__link m-menu__link--toggle-skip">
												<a href="#" class="btn btn-focus m-btn m-btn--icon m-btn--pill">
													<span>
														<i class="la la-plus"></i>
														<span>New order</span>
													</span>
												</a>
											</div>
										</li>
									</ul>
								</div>
							</li>
							<?php //if (!$this->ion_auth->in_group('member')) {
							?>
							<li class="m-menu__item <?php if (isset($page) && $page === 'digital assets') echo 'm-menu__item--active  m-menu__item--active-tab';
													else echo 'm-menu__item--submenu  m-menu__item--tab'; ?> m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="" aria-haspopup="true"><a href="<?= site_url("myskearch"); ?>/digital_assets" class="m-menu__link" title="Non functional dummy link"><span class="m-menu__link-text">Digital Assets</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-2"></i><span class="m-menu__link-text">Revenue</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-analytics"></i><span class="m-menu__link-text">Bills</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-notes"></i><span class="m-menu__link-text">IPO</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">Tax Management</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-alarm-1"></i><span class="m-menu__link-text">Invoices</span></a></li>
										<li class="m-menu__item  m-menu__item--actions" aria-haspopup="true">
											<div class="m-menu__link m-menu__link--toggle-skip">
												<a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--pill">
													<span>
														<i class="la la-cloud-download"></i>
														<span>Generate report</span>
													</span>
												</a>
											</div>
										</li>
									</ul>
								</div>
							</li>
							<?php //}
							?>
							<li class="m-menu__item  <?php if (isset($page) && $page === 'private social') echo 'm-menu__item--active  m-menu__item--active-tab';
														else echo 'm-menu__item--submenu  m-menu__item--tab'; ?> m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="<?= site_url("myskearch"); ?>/private_social" class="m-menu__link" title="Non functional dummy link"><span class="m-menu__link-text">Private Social</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-settings-1"></i><span class="m-menu__link-text">Build Tools</span></a></li>
										<li class="m-menu__item " aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-imac"></i><span class="m-menu__link-text">Layout Builder</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-paper-plane"></i><span class="m-menu__link-text">Documentatiion</span></a></li>
										<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-multimedia"></i><span class="m-menu__link-text">Reviews</span></a></li>
									</ul>
								</div>
							</li>
							<?php if ($this->ion_auth->in_group(array('Admin', 'Brand Members'))) : ?>
								<li class="m-menu__item  <?php if (isset($page) && $page === 'brand direct') echo 'm-menu__item--active  m-menu__item--active-tab';
																else echo 'm-menu__item--submenu  m-menu__item--tab'; ?> m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="<?= site_url("myskearch"); ?>/brand_direct" class="m-menu__link" title="Non functional dummy link"><span class="m-menu__link-text">Brand Direct</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-settings-1"></i><span class="m-menu__link-text">Build Tools</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="builder.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-imac"></i><span class="m-menu__link-text">Layout Builder</span></a></li>
											<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-paper-plane"></i><span class="m-menu__link-text">Documentatiion</span></a></li>
											<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="inner2.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-multimedia"></i><span class="m-menu__link-text">Reviews</span></a></li>
										</ul>
									</div>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<!-- end::Horizontal Menu -->
			</div>
		</div>
	</div>
</header>

<!-- end::Header -->