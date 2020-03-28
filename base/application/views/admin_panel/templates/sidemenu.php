					<!-- BEGIN: Left Aside -->
					<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
					<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

						<!-- BEGIN: Aside Menu -->
						<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
							<ul class="m-menu__nav ">
								<li class="m-menu__section m-menu__section--first">
									<h4 class="m-menu__section-text">Departments</h4>
									<i class="m-menu__section-icon flaticon-more-v2"></i>
								</li>
								<li id="menu-dashboard" class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="<?= site_url("admin/dashboard"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Dashboard</span></a></li>
								<li id="menu-frontend" class="m-menu__item " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Front-end</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li id="submenu-frontend-homepage_items" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/frontend/homepage"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Homepage Items</span></a></li>
										</ul>
									</div>
								</li>
								<li id="menu-users" class="m-menu__item " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Users</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li id="submenu-users-registered" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/5"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Registered Users</span></a></li>
											<li id="submenu-users-premium" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/4"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Premium Users</span></a></li>
											<li id="submenu-users-staff" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/1"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staff</span></a></li>
											<li id="submenu-users-groups" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/groups"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Groups</span></a></li>
											<li id="submenu-users-permissions" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/permissions"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Permissions</span></a></li>
										</ul>
									</div>
								</li>
								<li id="menu-results" class="m-menu__item " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Results</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li id="submenu-results-umbrellas" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/umbrellas/status/all"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Umbrellas</span></a></li>
											<li id="submenu-results-fields" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/fields/status/all"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fields</span></a></li>
											<li id="submenu-results-related_umbrellas" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/frontend/umbrella_suggestions"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Related Umbrellas</span></a></li>
											<li id="submenu-results-related_fields" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/frontend/field_suggestions"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Related Fields</span></a></li>
											<li id="submenu-results-links" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/links/keywords/search"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Add Links</span></a></li>
											<li id="submenu-results-research" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/results/research/list"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Research</span></a></li>
										</ul>
									</div>
								</li>
								<li id="menu-brands" class="m-menu__item " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Brands</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li id="submenu-brands-leads" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/brands/brandleads"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Leads</span></a></li>
											<li id="submenu-brands-members" class="m-menu__item" aria-haspopup="true"><a href="<?= site_url("admin/users/group/id/3"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Members</span></a></li>
											<li class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1"><a href="https://crm.skearch.com/admin" target="_blank" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">CRM</span></a></li>
											<li id="submenu-brands-relationships" id="submenu-brands-leads" class="m-menu__item" aria-haspopup="true"><a href="inner.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand Relationships</span></a></li>
											<li class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("media-manager") ?>" target="_blank" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Media Engine</span></a></li>
											<li id="submenu-brands-products" class="m-menu__item" aria-haspopup="true"><a href="#" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Product</span></a></li>
											<li id="submenu-brands-sales" class="m-menu__item" aria-haspopup="true"><a href="#" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sales</span></a></li>
										</ul>
									</div>
								</li>

								<li id="menu-linkchecker" class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="<?= site_url("admin/linkchecker"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">Link Checker</span></a></li>

								<li class="m-menu__section ">
									<h4 class="m-menu__section-text">Communications</h4>
									<i class="m-menu__section-icon flaticon-more-v2"></i>
								</li>

								<li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= site_url("news/admin/posts"); ?>" target="_blank" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-graphic"></i><span class="m-menu__link-text">Blog</span></a></li>
								<li class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/members"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-graphic"></i><span class="m-menu__link-text">Email</span></a></li>
								<li class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/invite"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-network"></i><span class="m-menu__link-text">Invite</span></a></li>
								<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">Templates</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__item-here"></span><span class="m-menu__link-text">Templates</span></span></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/welcome"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Welcome Email</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/activation"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Activation</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/email/templates/forgotten_password"); ?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Forget Password</span></a></li>
										</ul>
									</div>
								</li>
								<li class="m-menu__section ">
									<h4 class="m-menu__section-text">System</h4>
									<i class="m-menu__section-icon flaticon-more-v2"></i>
								</li>
								<li id="menu-options" class="m-menu__item " aria-haspopup="true"><a href="<?= site_url("admin/option"); ?>" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-settings"></i><span class="m-menu__link-text">Options</span></a></li>
							</ul>
						</div>

						<!-- END: Aside Menu -->
					</div>

					<!-- END: Left Aside -->