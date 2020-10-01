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
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__body">

			<!-- Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Reference No.</th>
						<th>Payment Service</th>
						<th>Transcation ID</th>
						<th>Payment Type</th>
						<th>Payment Date</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>
<style>
	[role=button] {
		cursor: pointer
	}
</style>
<script>
	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				dom: '<"top"lfp>rt<"bottom"ip><"clear">',
				rowId: "id",
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				language: {
					"emptyTable": "No payment records found"
				},
				ajax: "<?= site_url("admin/brand/payments/get/id/$brand_id"); ?>",
				columns: [{
					data: "#"
				}, {
					data: "id"
				}, {
					data: "service"
				}, {
					data: "transaction_id"
				}, {
					data: "payment_type"
				}, {
					data: "payment_date"
				}, {
					data: "amount"
				}],
				columnDefs: [{
						targets: 6,
						render: function(a, t, e, n) {
							return "$" + (Math.round(e['amount'] * 100) / 100).toFixed(2);
						}
					}, {
						targets: 5,
						render: function(a, t, e, n) {
							return new Date(e['payment_date'].replace(/-/g, "/")).toLocaleString();
						}
					},
					{
						targets: 0,
						render: function(a, t, e, n) {
							return n['row'] + 1;
						}

					}
				],
				footerCallback: function(t, e, n, a, r) {
					var o = this.api(),
						l = function(t) {
							return "string" == typeof t ? 1 * t.replace(/[\$,]/g, "") : "number" == typeof t ? t : 0;
						},
						u = o
						.column(6)
						.data()
						.reduce(function(t, e) {
							return l(t) + l(e);
						}, 0),
						i = o
						.column(6, {
							page: "all"
						})
						.data()
						.reduce(function(t, e) {
							return l(t) + l(e);
						}, 0);
					$(o.column(6).footer()).html("Total $" + mUtil.numberString(i.toFixed(2)));
				}
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init()
	});
</script>


<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands").addClass("m-menu__item  m-menu__item--active");
</script>