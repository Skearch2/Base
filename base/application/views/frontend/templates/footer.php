	<footer>
		<div class="container">
			<div class="row">
				<div class="footer-link">

					<a href="https://www.skearch.io/about">About</a>
					<a href="https://www.skearch.io/brands">Brands</a>
					<a href="https://www.skearch.io">Local</a>
					<a href="<?= base_url('pp'); ?>">Privacy Policy</a>
					<a href="<?= base_url('tos'); ?>">Terms of Service</a>
					<a href="<?= base_url('news'); ?>">News</a>
					<a href="<?= base_url('tips'); ?>">Send a Tip</a>

					<p class="copy-right">
						Copyright © <?php echo date('Y'); ?> Skearch, LLC All rights reserved<br>
						<?php if (isset($version)) : ?>
							<span class='app_title'>Skearch v<?= $version; ?></span>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</footer>