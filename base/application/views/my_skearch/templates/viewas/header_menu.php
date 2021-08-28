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
						</div>
					</div>
				</div>

				<!-- end::Brand -->
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
							<li class="m-menu__item  m-menu__item--active  m-menu__item--active-tab  m-menu__item--submenu m-menu__item--tabs" m-menu-submenu-toggle="tab" aria-haspopup="true"><a href="javascript: void(0)" class="m-menu__link m-menu__toggle"><span class="m-menu__link-text">View as Brand</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item m-menu__item--active m-menu__item--submenu m-menu__item--rel m-menu__item--submenu-tabs" m-menu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon la la-building"></i><span class="m-menu__link-text">Brands</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("admin/viewas/brand/id/{$brand_id}/show/ads"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Ads</span></a></li>
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("admin/viewas/brand/id/{$brand_id}/show/brandlinks"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">BrandLink</span></a></li>
													<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="<?= base_url("admin/viewas/brand/id/{$brand_id}/show/vault"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Media Vault</span></a></li>
												</ul>
											</div>
										</li>
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