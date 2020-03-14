<header>
	<div class="container">
		<div class="row">
			<a href="<?= site_url() ?>">
				<div class="col-sm-4 col-xs-6 logo">
					<div class="logo-header"></div>
				</div>
			</a>
			<div class="col-sm-6 col-xs-12 search-box">
				<div class="search-bar">
					<form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
						<input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
						<button class="search-btn" border="0"></button>
					</form>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6 field-btn">
				<a class="btn-cat" href="<?= site_url('browse') ?>"></a>
				<a class="theme-change" onclick="changeTheme()" title="Change theme">
					<div class="theme-change icon"></div>
				</a>
			</div>
		</div>
	</div>
</header>