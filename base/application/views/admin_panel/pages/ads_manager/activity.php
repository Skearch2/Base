<?php

// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

// Start body element
$this->load->view('admin_panel/templates/start_body');

// Start page section
$this->load->view('admin_panel/templates/start_page');

// Load header
$this->load->view('admin_panel/templates/header');

// Start page body
$this->load->view('admin_panel/templates/start_pagebody');

// Load sidemenu
$this->load->view('admin_panel/templates/sidemenu');

// Start inner body in a page body
$this->load->view('admin_panel/templates/start_innerbody');

// Load subheader in inner body
$this->load->view('admin_panel/templates/subheader');
?>

<div class="m-content">
	<div class="m-portlet m-portlet--responsive-mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="fa fa-globe m--font-brand"></i>
					</span>
					<h3 class="m-portlet__head-text m--font-brand">
						Ad Activity
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
							<div class="btn-group" role="group">
								<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Change year
								</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 45px, 0px);">
									<?php $current_year = Date('Y'); ?>
									<?php while ($current_year >= $ad->oldest_activity_year) : ?>
										<a class="dropdown-item" href="javascript:void(0)" onclick="updateStats(<?= $current_year ?>)"><?= $current_year ?></a>
										<?php $current_year--; ?>
									<?php endwhile ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-widget21" style="min-height: 310px">
						<div class="m-widget21__chart m-portlet-fit--sides" style="height:310px;">
							<canvas id="m_chart_ad_stats"></canvas>
						</div>
					</div>
				</div>
			</div>

			<!--begin: Search Form -->
			<form class="m-form m-form--fit m--margin-bottom-20">
				<div class="input-group m-input-group col-3">
					<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="la la-calendar"></i></span></div>
					<input type="text" class="form-control m-input" placeholder="Select Month" aria-describedby="basic-addon1" id="m_datepicker" name="monthFilter">
				</div>
			</form>
			<!-- <table cellspacing="5" cellpadding="5" border="0">
				<tbody>
					<tr>
						<td>Minimum date:</td>
						<td><input type="text" id="min" name="min"></td>
					</tr>
					<tr>
						<td>Maximum date:</td>
						<td><input type="text" id="max" name="max"></td>
					</tr>
				</tbody>
			</table> -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Clicks</th>
						<th>Impressions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

// End page body
$this->load->view('admin_panel/templates/end_pagebody');

// Load footer
$this->load->view('admin_panel/templates/footer');

// End page section
$this->load->view('admin_panel/templates/end_page');

// Load quick sidebar
$this->load->view('admin_panel/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('admin_panel/templates/scrolltop');

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->
<script>
	const stats = document.getElementById("m_chart_ad_stats").getContext("2d");
	const chart = new Chart(stats, {
		type: "bar",
		data: {
			labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"],
			datasets: [{
				label: "Impressions",
				backgroundColor: mApp.getColor("warning"),
				borderColor: mApp.getColor("warning"),
				pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointHoverBackgroundColor: mApp.getColor("danger"),
				pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0.1).rgbString(),
				data: <?= json_encode($ad->monthly_impressions) ?>,
			}, {
				label: "Clicks",
				backgroundColor: mApp.getColor("danger"),
				borderColor: mApp.getColor("danger"),
				pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointHoverBackgroundColor: mApp.getColor("danger"),
				pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0.1).rgbString(),
				data: <?= json_encode($ad->monthly_clicks) ?>,
			}, ],
		},
		options: {
			title: {
				display: 1,
				text: <?= date('Y') ?>
			},
			legend: {
				display: 1
			},
			responsive: 1,
			maintainAspectRatio: 0,
			scales: {
				xAxes: [{
					display: 1,
					gridLines: 0,
					scaleLabel: {
						display: 1
					}
				}],
				yAxes: [{
					display: 1,
					scaleLabel: {
						display: 1
					},
					ticks: {
						beginAtZero: 1
					}
				}],
			}
		}
	});

	function updateStats(year) {
		$.ajax({
			url: '<?= site_url("admin/ads/manager/get/activity/ad/id/{$ad->id}/year/"); ?>' + year,
			type: 'GET',
			success: function(data, status) {
				console.log(data)
				chart.config.data.datasets = [];
				chart.config.data.labels = [];

				chart.config.data.labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"]

				var dataSet1 = {
					label: "Impressions",
					data: data.impressions,
					backgroundColor: mApp.getColor("warning")
				}

				var dataSet2 = {
					label: "Clicks",
					data: data.clicks,
					backgroundColor: mApp.getColor("danger")
				}

				chart.config.data.datasets.push(dataSet1);
				chart.config.data.datasets.push(dataSet2);
				chart.options.title.text = year;

				chart.update();
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to process request.");
			}
		});
	}


	var datatable = {
		init: function() {
			$("#m_table").DataTable({
				responsive: !0,
				dom: '<"top"lp>rt<"bottom"ip><"clear">',
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				displayLength: 31,
				lengthChange: false,
				order: [0, "asc"],
				columns: [{
					data: "date"
				}, {
					data: "clicks"
				}, {
					data: "impressions"
				}]
			});
		}
	}

	var BootstrapDatepicker = (function() {
		var t;
		t = {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		};
		return {
			init: function() {
				$("#m_datepicker").datepicker({
					templates: t,
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					startView: "months",
					minViewMode: "months",
					format: 'MM yyyy',
					startDate: new Date(<?= $ad->oldest_activity_year ?>, 0),
					endDate: '+0m',
					autoclose: true
				});
			}
		};
	})();

	jQuery(document).ready(function() {
		BootstrapDatepicker.init();
		datatable.init();

		// on date select run ajax call to get filtered query
		$("#m_datepicker").datepicker().on('changeDate', function(e) {
			filter_val = e.date.getFullYear() + "-" + ("0" + (e.date.getMonth() + 1)).slice(-2)
			$('#m_table').DataTable().ajax.url("<?= site_url("admin/ads/manager/get/activity/ad/id/{$ad->id}") ?>/filter/" + filter_val).load()
		});
	});

	// menu highlight
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-ads-manager").addClass("m-menu__item  m-menu__item--active");
</script>
<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>