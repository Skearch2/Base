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
	<div class="m-portlet m-portlet--full-height m-portlet--fit m-portlet--unair">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head">
						Cryto Markets
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--Begin::Section-->
			<div class="row">
				<div class="col-xl-3">
					<!--begin:: Packages-->
					<div class="m-portlet m--bg-info m-portlet--bordered m-portlet--full-height  m-portlet--rounded">
						<div class="m-portlet__body">
							<!--begin::Widget 29-->
							<div class="m-widget29">
								</script>
								<div class="livecoinwatch-widget-1" lcw-coin="BTC" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="0"></div>
								<div class="livecoinwatch-widget-1" lcw-coin="ETH" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="1"></div>
								<div class="livecoinwatch-widget-1" lcw-coin="XRP" lcw-base="USD" lcw-period="d" lcw-color-tx="#ffffff" lcw-color-pr="#58c7c5" lcw-color-bg="#1f2434" lcw-border-w="1"></div>
							</div>

							<!--end::Widget 29-->
						</div>
					</div>
					<!--end:: Packages-->
				</div>
			</div>
		</div>
	</div>
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