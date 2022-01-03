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
			<div class="m-portlet m-portlet--bordered-semi m-portlet--half-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Enter Weekly Crypto Give Away !
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget4">
						<?php if ($giveaway) : ?>
							<?php if ($giveaway->status == 0) : ?>
								<div class="m-widget4__item">
									<div class="m-widget4__info">
										<span class="m-widget4__title">
											Giveaway over!
										</span><br>
										<span class="m-widget4__sub">
											<b>Winner user ID: <?= $giveaway->user_id ?></b>
											<br>
											<b>Crypto: <?= $giveaway->crypto ?> &emsp; Amount: <?= $giveaway->amount ?></b>
										</span>
									</div>
									<!-- <span class="m-widget4__ext">
										<?php if ($is_user_participant) : ?>
											<span class="m-badge m-badge--success m-badge--wide m-badge--rounded m--font-boldest">
												Enlisted
											</span>
										<?php else : ?>
											<button id="btn-enter-giveaway" type="button" class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" onclick="enterGiveaway(<?= $giveaway->id ?>, <?= $this->session->userdata('user_id') ?>)">Enter</button>
										<?php endif ?>
									</span> -->
								</div>

							<?php else : ?>
								<div class="m-widget4__item">
									<div class="m-widget4__info">
										<span class="m-widget4__title">
											<?= $giveaway->title ?>
										</span><br>
										<span class="m-widget4__sub">
											Deadline: <?= $giveaway->end_date ?>
										</span>
									</div>
									<span class="m-widget4__ext">
										<?php if ($is_user_participant) : ?>
											<span class="m-badge m-badge--success m-badge--wide m-badge--rounded m--font-boldest">
												Enlisted
											</span>
										<?php else : ?>
											<button id="btn-enter-giveaway" type="button" class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" onclick="enterGiveaway(<?= $giveaway->id ?>, <?= $this->session->userdata('user_id') ?>)">Enter</button>
										<?php endif ?>
									</span>
								</div>
								<?php if (!$is_user_participant) : ?>
									<label class="m-checkbox">
										<input type="checkbox" id="age_verify">I am at least 18 years of age
										<span></span>
									</label>
								<?php endif ?>
							<?php endif ?>
						<?php else : ?>
							There are no giveaways at this time.
						<?php endif ?>
					</div>
				</div>
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
									https://gala.fan/mkK_yJn-T
								</span>
							</div>
							<span class="m-widget4__ext">
								<a href="https://gala.fan/mkK_yJn-T" target="_blank"><span class="m-widget4__number m--font-brand">Visit</span></a>
							</span>
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

<script>
	// Draw giveaway
	function enterGiveaway(id, userID) {
		if ($("#age_verify").prop('checked') != 1) {
			swal("Warning!", "You must be atleast 18 years of age to participate.", "warning")
		} else {
			swal({
				title: "Enter Giveaway?",
				text: "Are you sure?",
				type: "info",
				confirmButtonClass: "btn btn-success",
				confirmButtonText: "Enter Giveaway",
				showCancelButton: true,
				timer: 5000
			}).then(function(e) {
				if (!e.value) return;
				$.ajax({
					url: '<?= site_url('myskearch/participate/giveaway/'); ?>' + id,
					type: 'GET',
					success: function(data, status) {
						if (data == 0) {
							swal("Error!", "Unable to enter giveaway.", "warning")
						} else {
							$("#btn-enter-giveaway").attr("disabled", "disabled").text("Enlisted");
							swal("Success!", "You have been enlisted in the giveaway.", "success")
						}
					},
					error: function(xhr, status, error) {
						swal("Error!", "Unable to process request.", "error")
					}
				});
			});
		}
	}
</script>
<!--Page Scripts-- >

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>