<header>
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col logo">
				<a href="<?= site_url() ?>">
					<div class="logo-header"></div>
				</a>
			</div>
			<div class="col-sm-6 search-box">
				<div class="search-bar">
					<form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
						<input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
						<button class="search-btn" border="0"></button>
					</form>
				</div>
			</div>
			<div class="col-sm-2 col field-btn">
				<a class="btn-cat" href="<?= site_url('browse') ?>"></a>
				<a class="theme-change" onclick="changeTheme()" title="Change theme">
					<div class="theme-change icon"></div>
				</a>
			</div>
			<div class="col-sm-12 login-bar" style="padding: 0;">
				<?php if ($this->ion_auth->logged_in()) : ?>
					<?php if ($this->ion_auth->is_admin()) : ?>
						<a href="<?= site_url('admin') ?>" class="btn btn-danger" role="button">Admin Panel</a>
					<?php endif ?>
					<a href="<?= site_url() ?>myskearch" class="btn btn-danger" role="button">My Skearch</a>
					<a href="<?= site_url() ?>myskearch/auth/logout" class="btn btn-danger" role="button">Logout</a>
				<?php else : ?>
					<a href="<?= site_url() ?>myskearch/auth/login" class="btn btn-danger" role="button">Sign in</a>
					<!--span>Not a Member?</span-->
					<a href="<?= site_url() ?>myskearch/auth/signup" class="btn btn-danger" role="button">Get Started</a>

				<?php endif ?>
			</div>
		</div>
	</div>
</header>