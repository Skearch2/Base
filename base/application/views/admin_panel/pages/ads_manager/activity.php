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

			<!--begin: Search Form -->
			<form class="m-form m-form--fit m--margin-bottom-20">
				<div class="row m--margin-bottom-20">
					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
						<label>Date Range:</label>
						<div class="input-daterange input-group" id="m_datepicker">
							<input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
							<div class="input-group-append">
								<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
							</div>
							<input type="text" class="form-control m-input" name="end" placeholder="To" data-col-index="5" />
						</div>
					</div>
				</div>
				<div class="m-separator m-separator--md m-separator--dashed"></div>
				<div class="row">
					<div class="col-lg-12">
						<button class="btn btn-brand m-btn m-btn--icon" id="m_search">
							<span>
								<i class="la la-search"></i>
								<span>Search</span>
							</span>
						</button>
						&nbsp;&nbsp;
						<button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
							<span>
								<i class="la la-close"></i>
								<span>Reset</span>
							</span>
						</button>
					</div>
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
				ajax: "<?= site_url("admin/ads/manager/get/activity/ad/id/{$ad->id}"); ?>",
				columns: [{
					data: "date"
				}, {
					data: "clicks"
				}, {
					data: "impressions"
				}],
				columnDefs: [{
					targets: 0,
					render: function(a, t, e, n) {
						return new Date(e['date']).toLocaleDateString();
					}
				}]
			});
		}
	}

	var BootstrapDatepicker = (function() {
		var t;
		t = mUtil.isRTL() ? {
			leftArrow: '<i class="la la-angle-right"></i>',
			rightArrow: '<i class="la la-angle-left"></i>'
		} : {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		};
		return {
			init: function() {
				$("#m_datepicker").datepicker({
					rtl: mUtil.isRTL(),
					todayHighlight: !0,
					templates: t
				})
			},
		};
	})();

	jQuery(document).ready(function() {

		BootstrapDatepicker.init();
		datatable.init();
	});

	// var minDate, maxDate;

	// // Custom filtering function which will search data in column four between two values
	// $.fn.dataTable.ext.search.push(
	// 	function(settings, data, dataIndex) {
	// 		var min = minDate.val();
	// 		var max = maxDate.val();
	// 		var date = new Date(data[4]);

	// 		if (
	// 			(min === null && max === null) ||
	// 			(min === null && date <= max) ||
	// 			(min <= date && max === null) ||
	// 			(min <= date && date <= max)
	// 		) {
	// 			return true;
	// 		}
	// 		return false;
	// 	}
	// );

	// var DatatablesSearchOptionsAdvancedSearch = (function() {
	// 	return {
	// 		init: function() {
	// 			var a;
	// 			(a = $("#m_table_1").DataTable({
	// 				responsive: !0,
	// 				dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
	// 				lengthMenu: [5, 10, 25, 50],
	// 				pageLength: 10,
	// 				searchDelay: 500,
	// 				processing: !0,
	// 				serverSide: !0,
	// 				ajax: {
	// 					url: "<?= site_url("admin/ads/manager/get/activity/ad/id/{$ad->id}"); ?>",
	// 					type: "GET",
	// 					data: {
	// 						columnsDef: ["ShipDate"]
	// 					},
	// 				},
	// 				columns: [{
	// 					data: "date"
	// 				}, {
	// 					data: "clicks"
	// 				}, {
	// 					data: "impressions"
	// 				}],
	// 			})),
	// 			$("#m_search").on("click", function(t) {
	// 					t.preventDefault();
	// 					var e = {};
	// 					$(".m-input").each(function() {
	// 							var a = $(this).data("col-index");
	// 							e[a] ? (e[a] += "|" + $(this).val()) : (e[a] = $(this).val());
	// 						}),
	// 						$.each(e, function(t, e) {
	// 							a.column(t).search(e || "", !1, !1);
	// 						}),
	// 						a.table().draw();
	// 				}),
	// 				$("#m_reset").on("click", function(t) {
	// 					t.preventDefault(),
	// 						$(".m-input").each(function() {
	// 							$(this).val(""), a.column($(this).data("col-index")).search("", !1, !1);
	// 						}),
	// 						a.table().draw();
	// 				});
	// 			// $("#m_datepicker").datepicker({
	// 			// 	todayHighlight: !0,
	// 			// 	templates: {
	// 			// 		leftArrow: '<i class="la la-angle-left"></i>',
	// 			// 		rightArrow: '<i class="la la-angle-right"></i>'
	// 			// 	}
	// 			// });
	// 		},
	// 	};
	// })();

	// $(document).ready(function() {
	// 	DatatablesSearchOptionsAdvancedSearch.init();

	// 	minDate = new Date($('#min'), {
	// 		format: 'YYYY-MM-DD'
	// 	});
	// 	maxDate = new Date($('#max'), {
	// 		format: 'YYYY-MM-DD'
	// 	});


	// 	// DataTables initialisation
	// 	var table = $('#m_table_1').DataTable();

	// 	// Refilter the table
	// 	$('#min, #max').on('change', function() {
	// 		table.draw();
	// 	});
	// });

	// menu highlight
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-ads-manager").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>