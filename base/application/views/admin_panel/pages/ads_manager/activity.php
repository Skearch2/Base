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
			<div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit ">
				<div class="m-portlet__body">
					<div class="m-widget21" style="min-height: 310px">
						<div class="m-widget21__chart m-portlet-fit--sides" style="height:310px;">
							<canvas id="m_chart_adwords_stats"></canvas>
						</div>
					</div>
				</div>
			</div>

			<!--begin: Search Form -->
			<form class="m-form m-form--fit m--margin-bottom-20">
				<div class="input-group m-input-group col-3">
					<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="la la-calendar"></i></span></div>
					<input type="text" class="form-control m-input" placeholder="Month" aria-describedby="basic-addon1" id="m_datepicker" name="monthFilter">
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
	var datatable = {
		init: function() {
			$("#m_table").DataTable({
				responsive: !0,
				dom: '<"top"lp>rt<"bottom"ip><"clear">',
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				order: [0, "desc"],
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
			$('#m_table').DataTable().ajax.url("<?= site_url("admin/ads/manager/get/activity/ad/id/{$ad->id}") ?>/filter/" + filter_val).load();
		});
	});

	// menu highlight
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-ads-manager").addClass("m-menu__item  m-menu__item--active");

	var Dashboard = (function() {
		if (0 != $("#m_chart_adwords_stats").length) {
			var e = document.getElementById("m_chart_adwords_stats").getContext("2d");
			var a = {
				type: "bar",
				data: {
					labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"],
					datasets: [{
						label: "Impressions",
						backgroundColor: mApp.getColor("accent"),
						borderColor: mApp.getColor("accent"),
						pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
						pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
						pointHoverBackgroundColor: mApp.getColor("danger"),
						pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0.1).rgbString(),
						data: [26254, 16396, 27027, 17532, 17686, 29158, 15876, 23791, 30241, 31183, 31224, 27620],
					}, {
						label: "Clicks",
						backgroundColor: mApp.getColor("brand"),
						borderColor: mApp.getColor("brand"),
						pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
						pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
						pointHoverBackgroundColor: mApp.getColor("danger"),
						pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0.1).rgbString(),
						data: [1501, 1543, 1612, 1581, 1615, 1707, 1095, 1240, 1922, 1920, 1971, 1745],
					}, ],
				},
				options: {
					title: {
						display: 0
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
				},
			};
			new Chart(e, a);
		}
	})();
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>