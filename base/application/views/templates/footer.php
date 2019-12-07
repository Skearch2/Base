	<footer>
		<div class='footer-link'>
			<a href="https://www.skearch.io/about">About</a>
			<a href="https://www.skearch.io/brands">Brands</a>
			<a href="https://www.skearch.io/privacy">Privacy Policy</a>
			<a href="https://www.skearch.io/tos">Terms of Service</a>
			<a href="<?= base_url('news'); ?>">News</a>
			<br /><br />

			<p class='copy-right'>
				Copyright &copy; <?php echo date('Y'); ?> Skearch, LLC All rights reserved<br>
				<?php if (isset($page) && $page === 'default') : ?>
					<span class='app_title'>Skearch v<?= $version; ?></span>
				<?php endif; ?>
			</p> <!-- End: p class='copy-right' -->

		</div> <!-- End: div class='footer-link' -->
	</footer>