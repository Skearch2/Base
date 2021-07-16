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
if (isset($viewas)) {
	$this->load->view('my_skearch/templates/viewas/header_menu');
} else {
	$this->load->view('my_skearch/templates/header_menu');
}

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h2 style="text-align:center;float:inline-end">BrandLink</h2>
		</div>
	</div>
</div>

<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<?php if ($is_primary_brand_user) : ?>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label for="keyword" class="col-2 col-form-label">BrandLink Keyword</label>
					<div class="col-7">
						<input class="form-control m-input" type="text" id="keyword">
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label for="url" class="col-2 col-form-label">URL</label>
					<div class="col-7">
						<input class="form-control m-input" type="text" id="url">
					</div>
				</div>
				<button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom" onclick="addKeyword()">Add Branded Keyword</button>
				<span style="float: inline-end;" class="m-form__help">*You can add upto 10 Branded Keywords in this account.</span>
			</div>
		<?php endif ?>
		<div class="m-portlet__body">
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>#</th>
						<th>Keyword</th>
						<th>URL</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
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

<script src="<?= site_url(ASSETS); ?>/my_skearch/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

<script>
	// var csrf_name = '<?= $this->security->get_csrf_token_name() ?>';
	// var csrf_hash = '<?= $this->security->get_csrf_hash() ?>';

	// Add keywords
	function addKeyword() {
		if ($('#keyword').val().length === 0 || $('#url').val().length === 0) {
			toastr.warning("", "All fields are required.");
		} else {
			$.ajax({
				url: '<?= base_url() ?>myskearch/brand/keywords/add',
				type: 'GET',
				// contentType: "application/json",
				// dataType: 'json',
				data: {
					// csrf_name: csrf_hash,
					keyword: $('#keyword').val(),
					url: $('#url').val()
				},
				beforeSend: function(data, status) {
					$('#m_table_1').fadeOut("slow");
				},
				success: function(data, status) {
					if (data == 1) {
						toastr.success("", "Keyword added.");
					} else if (data == 0) {
						toastr.error("", "Unable to add keyword.");
					} else if (data == -1) {
						toastr.error("", "Keyword already exists.");
					}
				},
				error: function(xhr, status, error) {
					toastr.error("", "Unable to process request.");
				},
				complete: function(data, status) {
					//csrf_hash = '<?= $this->security->get_csrf_hash() ?>';

					$('#keyword').val('');
					$('#url').val('');
					$('#m_table_1').DataTable().ajax.reload(null, false);
					$('#m_table_1').fadeIn("slow");
				}
			});
		}
	}

	// Delete keywords
	function deleteKeyword(id, keyword) {
		var keyword = keyword.replace(/%20/g, ' ');

		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the keyword: \"" + keyword + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('myskearch/brand/keywords/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == 0) {
						swal("Error!", "Unable to delete keyword.", "error")
					} else {
						swal("Success!", "The keyword has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	// //Toggles keywords status
	// function toggle(id, row) {
	// 	$.ajax({
	// 		url: '<?= site_url('myskearch/brand/keywords/toggle/id/'); ?>' + id,
	// 		type: 'GET',
	// 		success: function(data, status) {
	// 			if (data == 0) {
	// 				document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
	// 				document.getElementById("tablerow" + row).innerHTML = "Inactive";
	// 				toastr.success("", "Status updated.");
	// 			} else if (data == 1) {
	// 				$("#tablerow" + row).prop("onclick", null).off("click");
	// 				// $("#tablerow" + row).removeStyle('cursor');
	// 				document.getElementById("tablerow" + row).className = "m-badge m-badge--warning m-badge--wide";
	// 				document.getElementById("tablerow" + row).innerHTML = "Pending Approval";
	// 				toastr.success("", "Request has been sent.");
	// 			}
	// 		},
	// 		error: function(xhr, status, error) {
	// 			toastr.error("", "Unable to process request.");
	// 		}
	// 	});
	// }

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				paging: false,
				rowId: "id",
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				filter: 0,
				info: 0,
				ajax: {
					url: "<?= site_url(); ?>myskearch/brand/keywords/get",
					type: "GET",
					data: {
						brand_id: <?= $brand_id ?>
					}
				},
				//ajax: "<?= site_url(); ?>myskearch/brand/keywords/get",
				columns: [{
					data: "#"
				}, {
					data: "keywords"
				}, {
					data: "url"
				}, {
					data: "active"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						var keywords = e['keywords'].replace(/ /g, '%20');
						<?php if ($is_primary_brand_user) : ?>
							return '<a onclick=deleteKeyword("' + e['id'] + '","' + keywords + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						<?php else : ?>
							return "-"
						<?php endif ?>
					}
				}, {
					targets: 3,
					render: function(a, t, e, n) {
						var s = {
							2: {
								title: "Pending Approval",
								class: "m-badge--warning"
							},
							1: {
								title: "Active",
								class: "m-badge--success"
							},
							0: {
								title: "Inactive",
								class: "m-badge--danger"
							}
						};
						if (e['approved'] == 0) return '<span id= tablerow' + n['row'] + ' class="m-badge ' + s[2].class + ' m-badge--wide">' + s[2].title + '</span>'
						else
							return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + '</span>'
					}
				}, {
					targets: 2,
					render: function(a, t, e, n) {
						return '<a href="' + e['url'] + '" target="_blank">' + e['url'] + '</a>'
					}
				}, {
					targets: 0,
					title: "#",
					render: function(a, t, e, n) {
						return n['row'] + 1;
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init();
	});
</script>

<?php

// Close body and html
$this->load->view('my_skearch/templates/close_html');

?>