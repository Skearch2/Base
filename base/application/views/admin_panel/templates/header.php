<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
	<div class="m-container m-container--fluid m-container--full-height">
		<div class="m-stack m-stack--ver m-stack--desktop">

			<!-- BEGIN: Brand -->
			<div class="m-stack__item m-brand  m-brand--skin-dark ">
				<div class="m-stack m-stack--ver m-stack--general">
					<div class="m-stack__item m-stack__item--middle m-brand__logo">
						<a href="<?= BASE_URL; ?>" class="m-brand__logo-wrapper">
							<img width="112" height="51" src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/media/img/logo/logo.png" />
						</a>
					</div>
					<div class="m-stack__item m-stack__item--middle m-brand__tools">

						<!-- BEGIN: Responsive Aside Left Menu Toggler -->
						<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Responsive Header Menu Toggler -->
						<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Topbar Toggler -->
						<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
							<i class="flaticon-more"></i>
						</a>

						<!-- BEGIN: Topbar Toggler -->
					</div>
				</div>
			</div>

			<!-- END: Brand -->
			<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
				<!-- BEGIN: Topbar -->
				<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
					<div class="m-stack__item m-topbar__nav-wrapper">
						<ul class="m-topbar__nav m-nav m-nav--inline">
							<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-topbar__userpic">
										<img src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/users/user-default.jpg" class="m--img-rounded m--marginless m--img-centered" alt="" />
									</span>
									<span class="m-nav__link-icon m-topbar__usericon  m--hide">
										<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
									</span>
									<span class="m-topbar__username m--hide"><?= $this->session->userdata('firstname') ?></span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center">
											<div class="m-card-user m-card-user--skin-light">
												<div class="m-card-user__pic">
													<img src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/users/user-default.jpg" class="m--img-rounded m--marginless" alt="" />
												</div>
												<div class="m-card-user__details">
													<span class="m-card-user__name m--font-weight-500"><?= $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'); ?></span>
													<a href="" class="m-card-user__email m--font-weight-300 m-link"><?= $this->session->userdata('group');; ?></a>
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
														<a href="<?= site_url('myskearch'); ?>" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-profile"></i>
															<span class="m-nav__link-text">MySkearch</span>
														</a>
													</li>
													<li class="m-nav__separator m-nav__separator--fit">
													</li>
													<li class="m-nav__item">
														<a href="<?= site_url('admin/auth/logout'); ?>" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li id="m_quick_sidebar_toggle" class="m-nav__item">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!-- END: Topbar -->
			</div>
		</div>
	</div>
</header>

<!-- END: Header -->