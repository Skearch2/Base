<div class="container">
	<header>
		<div class="col-md-12">
			<nav id='navigation_top' style="max-width:100%">
				<?php if ($this->ion_auth->logged_in()) { ?>
					<ul id='member-display'>
						<li><span style='font-weight: lighter;'>Hello <?= ucwords($user->firstname . " " . $user->lastname); ?></span></li>
						<?php if ($this->ion_auth->is_admin()) { ?>
							<li><a href="admin">Admin Panel</a></li>
						<?php } ?>
						<li><a href="myskearch">My Skearch</a></li>
						<li><a href="myskearch/auth/logout" class="ls">Logout</a></li>
						<li>
							<?php if ($this->session->userdata('css') != '') {
									if ($this->session->userdata('css') == "dark") { ?>
									<img src="<?= base_url(ASSETS); ?>/style/images/sun_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply dark theme" />
								<?php } else { ?>
									<img src="<?= base_url(ASSETS); ?>/style/images/moon_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply light theme" />
								<?php }
									} else { ?>
								<img src="<?= base_url(ASSETS); ?>/style/images/moon_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply light theme" />
							<?php } ?>
						</li>
					</ul>
				<?php } else { ?>
					<div id='navigation_top_welcome'>
						Not a member?<a href="myskearch/auth/signup" class="ls">Sign Up</a><a href="myskearch" class="ls">Login</a>
						&nbsp;
						<?php if ($this->session->userdata('css') != '') {
								if ($this->session->userdata('css') == "dark") { ?>
								<img src="<?= base_url(ASSETS); ?>/style/images/sun_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply dark theme" />
							<?php } else { ?>
								<img src="<?= base_url(ASSETS); ?>/style/images/moon_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply light theme" />
							<?php }
								} else { ?>
							<img src="<?= base_url(ASSETS); ?>/style/images/moon_theme.png" style="width:30px;cursor:pointer;" id="bubble_shutdown" title="Apply light theme" />
						<?php } ?>
					</div> <!-- End: div id='naviation_top_welcome -->
				<?php } ?>
			</nav>
		</div> <!-- End div class='top-green' -->
	</header>
</div>