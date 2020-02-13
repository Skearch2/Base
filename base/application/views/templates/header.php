<header>
	<div class="container">
		<div class="row">
			<a href="<?= site_url() ?>">
				<div class="col-sm-4 col-xs-6 logo">
					<img src="<?= base_url(ASSETS) ?>/frontend/images/logo.png" class="img-responsive" alt="logo" />
				</div>
			</a>
			<div class="col-sm-6 col-xs-12 search-box">
				<div class="search-bar">
					<input type="text" size="64" class="google-input" placeholder="Enter Keywords...">
					<button class="search-btn" border="0" type="submit"></button>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6 field-btn">
				<a class="btn-cat" href="<?= site_url() ?>/browse"></a>
				<a class="theme-change" href="#">
					<img src="<?= base_url(ASSETS) ?>/frontend/images/moon_theme.png" class="theme-change moon" alt="" />
					<img src="<?= base_url(ASSETS) ?>/frontend/images/sun_theme.png" class="theme-change sun" alt="" />
				</a>
			</div>
		</div>
	</div>
</header>