<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header and menu
$this->load->view('my_skearch/templates/header_menu');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-content">
	<div class="m-portlet m-portlet--full-height m-portlet--fit  m-portlet--rounded">
		<div class="m-portlet__body">
			<div class="form-group m-form__group row">
				<div class="livecoinwatch-widget-5" lcw-base="USD" lcw-color-tx="#0693e3" lcw-marquee-1="coins" lcw-marquee-2="movers" lcw-marquee-items="30"></div>
			</div>
		</div>
	</div>

	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height m-portlet--skin-dark  m-portlet--rounded m-portlet--rounded-force">
				<div class="m-portlet__body">
					<div class="livecoinwatch-widget-1" lcw-coin="BTC" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="1"></div>
					<div class="livecoinwatch-widget-1" lcw-coin="ETH" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="1"></div>
					<div class="livecoinwatch-widget-1" lcw-coin="XRP" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="1"></div>
				</div>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded m-portlet--rounded-force">
			</div>
		</div>
		<div class="col-xl-4">
			<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Links
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget4">
						<div class="m-widget4__item">
							<div class="m-widget4__info">
								<span class="m-widget4__title">
									Ledger Wallet
								</span><br>
								<span class="m-widget4__sub">
									https://shop.ledger.com/?r=c4a2f222a12e
								</span>
							</div>
							<span class="m-widget4__ext">
								<a href="https://shop.ledger.com/?r=c4a2f222a12e" target="_blank"><span class="m-widget4__number m--font-brand">Visit</span></a>
							</span>
						</div>
						<div class="m-widget4__item">
							<div class="m-widget4__info">
								<span class="m-widget4__title">
									Crypto.com
								</span><br>
								<span class="m-widget4__sub">
									https://crypto.com/app/nwsrehpf2k
								</span>
							</div>
							<span class="m-widget4__ext">
								<a href="https://crypto.com/app/nwsrehpf2k" target="_blank"><span class="m-widget4__number m--font-brand">Visit</span></a>
							</span>
						</div>
						<div class="m-widget4__item">
							<div class="m-widget4__info">
								<span class="m-widget4__title">
									Gala Games
								</span><br>
								<span class="m-widget4__sub">
									https://gala.fan/C0KNBwVp9
								</span>
							</div>
							<span class="m-widget4__ext">
								<a href="https://gala.fan/C0KNBwVp9" target="_blank"><span class="m-widget4__number m--font-brand">Visit</span></a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End::Section-->
</div>

<?php

// End page body
$this->load->view('my_skearch/templates/end_pagebody');

// Load footer
$this->load->view('my_skearch/templates/footer');

// End page section
$this->load->view('my_skearch/templates/end_page');

// Load quick sidebar
$this->load->view('my_skearch/templates/quick_sidebar');

// Load global JS files
$this->load->view('my_skearch/templates/js_global');

?>

<!-- Page Scripts -->
<script defer src="https://www.livecoinwatch.com/static/lcw-widget.js"></script>
<!--Page Scripts-- >

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>