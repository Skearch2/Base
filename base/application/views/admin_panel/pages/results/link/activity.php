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
		<div class="m-portlet__body">
			<div class="m-portlet m-portlet--full-height m-portlet--skin-light m-portlet--fit">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
							<div class="btn-group" role="group">
								<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Choose year
								</button>
								<div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 45px, 0px);">
									<?php $current_year = Date('Y'); ?>
									<?php while ($current_year >= $link->oldest_activity_year) : ?>
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
							<canvas id="m_chart_link_stats"></canvas>
						</div>
					</div>
				</div>
			</div>

			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Clicks</th>
					</tr>
				</thead>
			</table>
			<br>
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
	const stats = document.getElementById("m_chart_link_stats").getContext("2d");
	const chart = new Chart(stats, {
		type: "bar",
		data: {
			labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"],
			datasets: [{
				label: "Clicks",
				backgroundColor: mApp.getColor("danger"),
				borderColor: mApp.getColor("danger"),
				pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
				pointHoverBackgroundColor: mApp.getColor("danger"),
				pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0.1).rgbString(),
				data: <?= json_encode($link->monthly_clicks) ?>,
			}, ],
		},
		options: {
			title: {
				display: 1,
				text: <?= date('Y') ?>
			},
			legend: {
				display: 0
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
			},
			onClick: (event, elements) => {
				if (elements[0]) {

					var year = chart.options.title.text
					var month = elements[0]._index + 1

					filter_val = year + "-" + ("0" + month).slice(-2)
					$('#m_table').DataTable().ajax.url("<?= site_url("admin/results/links/get/activity/link/id/{$link->id}") ?>/filter/" + filter_val).load()
				}
			}
		}
	});

	function updateStats(year) {
		$.ajax({
			url: '<?= site_url("admin/results/links/get/activity/link/id/{$link->id}/year/"); ?>' + year,
			type: 'GET',
			success: function(data, status) {
				chart.config.data.datasets = [];
				chart.config.data.labels = [];

				chart.config.data.labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"]

				var dataSet = {
					label: "Clicks",
					data: data.clicks,
					backgroundColor: mApp.getColor("danger")
				}

				chart.config.data.datasets.push(dataSet);
				chart.options.title.text = year;

				chart.update();
				$('#m_table').DataTable().clear().draw()
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
				paging: false,
				order: [0, "asc"],
				language: {
					"emptyTable": "To view stats select the bar for that month from the chart."
				},
				columns: [{
					data: "date"
				}, {
					data: "clicks"
				}]
			});
		}
	}

	jQuery(document).ready(function() {
		datatable.init();
	});

	// menu highlight
	$("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-results-links").addClass("m-menu__item  m-menu__item--active");
</script>
<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>