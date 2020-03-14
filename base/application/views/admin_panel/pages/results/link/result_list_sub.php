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
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?= $subTitle; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/categories/create_result"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-cart-plus"></i>
								<span>Add Result</span>
							</span>
						</a>
					</li>
					<li class="m-portlet__nav-item"></li>
					<li class="m-portlet__nav-item">
						<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
							<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
								<i class="la la-ellipsis-h m--font-brand"></i>
							</a>
							<div class="m-dropdown__wrapper">
								<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
								<div class="m-dropdown__inner">
									<div class="m-dropdown__body">
										<div class="m-dropdown__content">
											<ul class="m-nav">
												<li class="m-nav__section m-nav__section--first">
													<span class="m-nav__section-text">Quick Actions</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-share"></i>
														<span class="m-nav__link-text">Create Post</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-chat-1"></i>
														<span class="m-nav__link-text">Send Messages</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-multimedia-2"></i>
														<span class="m-nav__link-text">Upload File</span>
													</a>
												</li>
												<li class="m-nav__section">
													<span class="m-nav__section-text">Useful Links</span>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-info"></i>
														<span class="m-nav__link-text">FAQ</span>
													</a>
												</li>
												<li class="m-nav__item">
													<a href="" class="m-nav__link">
														<i class="m-nav__link-icon flaticon-lifebuoy"></i>
														<span class="m-nav__link-text">Support</span>
													</a>
												</li>
												<li class="m-nav__separator m-nav__separator--fit m--hide">
												</li>
												<li class="m-nav__item m--hide">
													<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Result Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!--end::Modal-->

		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Priority</th>
						<th>Title</th>
						<th>Description</th>
						<th>Category</th>
						<th>Display Url</th>
						<th>Status</th>
						<th width="18%">Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- END EXAMPLE TABLE PORTLET-->
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

<script>
	// function showResultDetails(id) {

	//   $( "div.modal-body" ).html(
	// 	   "<p>Result ID:</p> "+ id +" \
	// 	    <p>This is a test.</p> "
	//   );
	// }

	// Deletes link
	function deleteLink(id, link) {
		var link = link.replace(/%20/g, ' ');
		swal({
			title: "Are you sure?",
			text: "Are you sure you want delete the link: \"" + link + "\"?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/categories/delete_result_listing/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					swal("Success!", "The link has been deleted.", "success")
					$("#" + id).remove();
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the link.", "error")
				}
			});
		});
	}

	//Toggles link active status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/categories/toggle_result/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Inactive";
					toastr.success("", "Status updated.");
				} else if (data == 1) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Active";
					toastr.success("", "Status updated.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to change the status.");
			}
		});
	}

	//Toggles link redirection
	function toggleRedirect(id) {
		$.ajax({
			url: '<?= site_url(); ?>admin/categories/toggle_redirect/' + id,
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					document.getElementById("redirect" + id).style.color = "red";
				} else if (data == 1) {
					document.getElementById("redirect" + id).style.color = "#34bfa3";
				}
				toastr.success("", "Redirection updated.");
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to take action.");
			}
		});
	}

	// change field priority
	function change_priority(id, priority) {
		$('#m_table_1').fadeOut("slow");
		$.ajax({
			url: '<?= site_url(); ?>/admin/categories/change_priority/' + id + '/' + priority,
			type: 'GET',
			success: function(status) {
				get_links_priority();
				$('#m_table_1').DataTable().ajax.reload(null, false);
				toastr.success("", "Priority updated.");
			},
			error: function(err) {
				toastr.error("", "Unable to update priority.");
			}
		});
	}

	function get_links_priority() {
		$.ajax({
			url: '<?= site_url(); ?>/admin/categories/get_links_priority/' + <?= $subcategoryid; ?>,
			type: 'GET',
			success: function(result) {
				obj = JSON.parse(result);
				$('#m_table_1').fadeIn("fast");
			},
			error: function(err) {
				toastr.error("", "Unable to get priorities for the link.");
			}
		});
	}

	function searchArray(key, array) {
		for (var i = 0; i < array.length; i++) {
			if (array[i].priority == key) {
				return array[i];
			}
		}
		return false;
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				dom: '<"top"lfp>rt<"bottom"ip><"clear">',
				rowId: "id",
				order: [
					[0, 'asc']
				],
				searchDelay: 500,
				lengthMenu: [
					[50, 100, -1],
					[50, 100, "ALL"]
				],
				processing: !0,
				serverSide: !1,
				ajax: "<?= site_url(); ?>/admin/categories/get_result_list/<?= $subcategoryid; ?>/<?= $status; ?>",
				columns: [{
					data: "Priority"
				}, {
					data: "title"
				}, {
					data: "description_short"
				}, {
					data: "stitle"
				}, {
					data: "display_url"
				}, {
					data: "enabled"
				}, {
					data: "Actions"
				}],
				columnDefs: [{
					targets: -1,
					title: "Actions",
					orderable: !1,
					render: function(a, t, e, n) {
						var $select = $("<select onchange= change_priority(" + e['id'] + ",this.value)></select>", {
							"id": "priority" + e['id'],
						});
						for (var i = 0; i <= 250; i++) {
							var $option = $("<option></option>", {
								"text": i,
								"value": i
							});
							if (searchArray(i, obj)) {
								$option.attr('disabled', 'disabled');
								$option.attr('style', 'background-color:#99ff99');
							}
							if (i == e['priority']) {
								$option.attr("selected", "selected")
							}
							$select.append($option);
						}

						var redirectVal;
						if (e['redirect'] == 0) redirectVal = "red";
						else redirectVal = "#34bfa3";
						var title = e['title'].replace(/ /g, '%20');
						var row = (n.row).toString().slice(-1);
						//return'<a onclick="showResultDetails('+e['id']+')" data-toggle="modal" data-target="#m_modal_2" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-search-plus"></i></a>'
						return $select.prop("outerHTML") +
							'<a href="<?= site_url() . "admin/categories/update_result/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=toggleRedirect("' + e['id'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Redirect"><i style="color:' + redirectVal + '" id="redirect' + e['id'] + '" class="la la-globe"></i></a>' +
							'<a onclick=deleteLink("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
					}
				}, {
					targets: 0,
					render: function(a, t, e, n) {
						return e['priority'];
					}
				}, {
					targets: 5,
					render: function(a, t, e, n) {
						var s = {
							1: {
								title: "Active",
								class: " m-badge--success"
							},
							0: {
								title: "Off",
								class: " m-badge--danger"
							}
						};
						return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
					}
				}]
			})
		}
	}

	jQuery(document).ready(function() {
		get_links_priority();
		DatatablesDataSourceAjaxServer.init();
	});
</script>

<!-- Sidemenu class -->
<script>
	$("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-results-fields").addClass("m-menu__item  m-menu__item--active");
</script>