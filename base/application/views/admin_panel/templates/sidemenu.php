<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: fixed;max-width: 255px;">
		<ul class="m-menu__nav ">
			<li id="menu-dashboard" class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="<?= site_url("admin/dashboard"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Dashboard</span></a></li>
			<li class="m-menu__section m-menu__section--first">
				<h4 class="m-menu__section-text">Controls</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>
			<li id="menu-users" class="m-menu__item m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Users</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li id="submenu-users-regular" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/5"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Regular Users</span></a></li>
						<li id="submenu-users-premium" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/4"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Premium Users</span></a></li>
						<li id="submenu-users-brand_users" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/3"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand Users</span></a></li>
						<li id="submenu-users-staff" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/1"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staff</span></a></li>
						<li id="submenu-users-groups" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/groups"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Groups</span></a></li>
					</ul>
				</div>
			</li>
			<li id="menu-results" class="m-menu__item m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-interface-11"></i><span class="m-menu__link-text">Results</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li id="submenu-results-umbrellas" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/umbrellas/status/all"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Umbrellas</span></a></li>
						<li id="submenu-results-fields" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/fields/status/all"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fields</span></a></li>
						<li id="submenu-results-links" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/links/search"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Add/Edit Links</span></a></li>
						<li id="submenu-suggestions" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Suggestions</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li id="homepage" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/suggestions/homepage"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Homepage</span></a></li>
									<li id="umbrellas" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/suggestions/umbrellas"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Umbrellas</span></a></li>
									<li id="fields" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/suggestions/fields"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fields</span></a></li>
								</ul>
							</div>
						</li>
						<li id="submenu-results-keywords" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/keywords"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Search Keywords</span></a></li>
						<li id="submenu-results-research" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/research/list"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Research</span></a></li>
					</ul>
				</div>
			</li>
			<li id="menu-brands" class="m-menu__item m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-business"></i><span class="m-menu__link-text">Brands</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li id="submenu-brands-brands" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/brands"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brands</span></a></li>
						<li id="submenu-brands-ads-manager" class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("admin/ads/manager") ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Ads Manager</span></a></li>
						<li id="submenu-brands-brandlinks" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/brands/brandlinks"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">BrandLinks</span></a></li>
						<li id="submenu-brands-dealdrop" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/brands/dealdrop"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Deal Drop</span></a></li>
					</ul>
				</div>
			</li>

			<li id="menu-linkchecker" class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="<?= site_url("admin/linkchecker"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text">Link Checker</span></a></li>

			<li class="m-menu__section ">
				<h4 class="m-menu__section-text">Communications</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>

			<li id="menu-news" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-file-2"></i><span class="m-menu__link-text">News</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("news/admin/posts"); ?>" target="_blank" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Blog</span></a></li>
						<li id="submenu-news-tos" class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("admin/tos"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">TOS/PP</span></a></li>
					</ul>
				</div>
			</li>
			<li id="menu-email" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-email"></i><span class="m-menu__link-text">Email</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li id="submenu-email-members" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/message"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Message Members</span></a></li>
						<li id="submenu-templates" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Templates</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li id="submenu-welcome" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Welcome</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
											<ul class="m-menu__subnav">
												<li id="welcome_regular" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/welcome_regular"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Registered</span></a></li>
												<li id="welcome_premium" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/welcome_premium"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Premium</span></a></li>
												<li id="welcome_brand" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/welcome_brand"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand</span></a></li>
											</ul>
										</div>
									</li>
									<li id="activation" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/activation"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Activation</span></a></li>
									<li id="forget" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/reset_password"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Reset Password</span></a></li>
									<li id="submenu-confirmation" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Confirmation</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
											<ul class="m-menu__subnav">
												<li id="brand_payment" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/brand_payment_confirmation"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand Payment</span></a></li>
												<li id="brand_signup" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/brand_signup_confirmation"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand Signup</span></a></li>
											</ul>
										</div>
									</li>
									<li id="submenu-notification" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Notification</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
											<ul class="m-menu__subnav">
												<li id="lead_signup" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/brand_lead_notification"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Lead Signup</span></a></li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<li id="submenu-marketing-email" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/marketing_emails"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Master Email List</span></a></li>
					</ul>
				</div>
			</li>
			<li id="menu-sales" class="m-menu__item m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon la la-dollar"></i><span class="m-menu__link-text">Sales</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li id="leads" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/brands/leads"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Leads</span></a></li>
						<li class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1"><a href="https://crm.skearch.com/admin" target="_blank" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">CRM</span></a></li>
						<li id="submenu-invite" class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Invite</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li id="invite-email" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/invite"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Send Email</span></a></li>
									<li id="invite-logs" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/logs/invite/view"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sent Invite</span></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</li>
			<li id="menu-tips" class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("admin/tips"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon la la-money"></i><span class="m-menu__link-text">Tip System</span></a></li>
			<li id="menu-giveaways" class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("admin/giveaways"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon la la-gift"></i><span class="m-menu__link-text">Giveaways</span></a></li>
			<li class="m-menu__section ">
				<h4 class="m-menu__section-text">Settings</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>
			<li id="menu-settings" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/settings"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-settings"></i><span class="m-menu__link-text">Settings</span></a></li>
			<li id="menu-permissions" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/permissions"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-lock"></i><span class="m-menu__link-text">Permissions</span></a></li>
		</ul>
	</div>

	<!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->