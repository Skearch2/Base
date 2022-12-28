<?php
// Set DocType and declare HTML protocol
$this->load->view('auth/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('auth/templates/head');
?>

<!-- begin::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-4" id="m_login">
			<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
				<div class="m-login__container">
					<div class="m-login__logo">
						<a href="<?= site_url() ?>">
							<div class="logo"></div>
						</a>
					</div>
					<div align="center" class="m-loader m-loader--lg" id="spinner" style="display:none"></div>
					<div id="section_approved_action" style="display:none">
						<div align="center" class="alert m-alert--outline alert-success">
							Your payment has been successfully completed.
							<br>
						</div>
						<div align="center"><small><i>Please close this page for security reasons<i></small></div>
					</div>
					<div id="section_cancelled_action" style="display:none">
						<div align="center" class="alert m-alert--outline alert-danger">
							Your payment action has been cancalled.
							<br>
						</div>
						<div align="center"><small><i>Please close this page for security reasons<i></small></div>
					</div>
					<div id="section_error_action" style="display:none">
						<div align="center" class="alert m-alert--outline alert-danger">
							An error occured, your payment was not processed.
							<br>
						</div>
						<div align="center"><small><i>Please close this page for security reasons<i></small></div>
					</div>
					<div id="section_dberror_action" style="display:none">
						<div align="center" class="alert m-alert--outline alert-warning">
							Your payment was processed, however, we were unable to provide you our receipt. Please contact sales.
							<br>
						</div>
						<div align="center"><small><i>Please close this page for security reasons<i></small></div>
					</div>
					<?= form_open('', array('class' => 'm-login__form m-form m-form--fit')) ?>
					<div id="section_payment_form">
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">Make a Payment</h3>
							</div>
						</div>
						<div id="smart-button-container">
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="text" placeholder="Brand Name" name="descriptionInput" id="brand" maxlength="50" value="">
								<!-- <input type="hidden" id="brand-id" name="brand_id" value=""> -->
							</div>
							<span id="brandError" style="visibility: hidden; color:red;">Brand Name is required</span>
							<br>
							<div class="input-group m-input-group m-input-group--pill">
								<input class="form-control m-input" type="text" placeholder="Amount" name="amountInput" id="amount" value="">
								<div class="input-group-append"><span class="input-group-text" id="basic-addon1">USD</span></div>
							</div>
							<span id="amountError" style="visibility: hidden; color:red;">Invalid Amount</span>
							<div class="m-form__group form-group row">
								<label class="col-3 col-form-label">Payment Type</label>
								<div class="col-9">
									<div class="m-radio-inline" id="type">
										<label class="m-radio">
											<input type="radio" name="typeInput" value="Advertising" checked> Advertising
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="typeInput" value="BrandLink"> BrandLink
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="typeInput" value="Advertising & BrandLink"> Both
											<span></span>
										</label>
									</div>
								</div>
							</div>
							<!-- <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value=""></div>
						<span id="invoiceidError" style="visibility: hidden; color:red;">Please enter an Invoice ID</span> -->
							<div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
						</div>
						<!-- <div class="m-login__form-action">
							<a href="<?= base_url() ?>">
								<button type="button" id="m_login_cancel" class="btn btn-outline-danger m-btn m-btn--custom m-login__btn">Cancel</button>
							</a>
						</div> -->
						<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>

	<?php
	// Contains global javascripts
	$this->load->view('auth/templates/js_global');
	?>

	<!--begin::Page Scripts -->
	<!-- <script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
	<script>
		// settings for brand search
		var options = {

			url: function(phrase) {
				return "<?= site_url(); ?>myskearch/auth/search/brand/" + phrase
			},

			getValue: "brand",

			template: {
				type: "description",
				fields: {
					description: "organization"
				}
			},

			list: {
				match: {
					enabled: true
				},

				sort: {
					enabled: true
				},

				onSelectItemEvent: function() {
					var brand = $("#brand").getSelectedItemData().brand;
					var id = $("#brand").getSelectedItemData().id;

					$("#brand").val(brand).trigger("change");
					$("#brand-id").val(id);
				},

				showAnimation: {
					type: "slide", //normal|slide|fade
					callback: function() {}
				},

				hideAnimation: {
					type: "normal", //normal|slide|fade
					callback: function() {}
				}
			}
		};

		// initialize brand search
		$("#brand").easyAutocomplete(options);
	</script> -->

	<!--end::Page Scripts -->

	<?php
	// Close body and html (contains some global javascripts)
	$this->load->view('auth/templates/end_html');
	?>