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
				<!-- Search keywords -->
				<div class="m-form m-form--fit m-form--label-align-right">
					<div class="form-group m-form__group row">
						<div class="input-group m-input-group m-input-group--air">
							<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-search"></i></span></div>
							<input type="text" onkeyup="searchLinks(this.value)" class="form-control m-input" placeholder="Search..." name="query">
						</div>
					</div>
				</div>
			</div>

			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/results/link/create"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Add Link</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<!-- begin::Move or duplicate modal dialog -->
		<div class="modal fade" id="modal_option" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Move or Duplicate Link</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="m-form m-form--fit m-form--label-align-right">
							<input type="hidden" id="link_id" name="link_id" value="">
							<div class="form-group m-form__group row">
								<label for="field" class="col-2 col-form-label">Field</label>
								<div class="col-7">
									<select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="field_id" onchange="getPriorities(this.value)" required>
										<option id="field" selected disabled value=""></option>
										<?php foreach ($fields as $field) : ?>
											<option value="<?= $field->id ?> <?= set_select("field", $field->id) ?>"><?= $field->title ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label for="priority" class="col-2 col-form-label">Priority</label>
								<div class="col-7">
									<select class="form-control" id="priority" name="priority" disabled>
									</select>
								</div>
								<div id="priority-loader" class="m-loader m-loader--brand" style="width: 30px; display: none;"></div>
							</div>
							<div class="m-form__group form-group row">
								<label for="action" class="col-2 col-form-label">Action</label>
								<div class="col-7">
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="option-select" value="1" checked> Duplicate
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="option-select" value="2"> Move
											<span></span>
										</label>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" id="btn-modal-submit" class="btn btn-primary" onclick="moveOrDuplicate()">Submit</button>
					</div>
				</div>
			</div>
		</div>
		<!--end::Move or duplicate modal dialog-->

		<div class="m-portlet__body">
			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The field has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update the field.
					</div>
				</div>
			<?php endif ?>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>Priority</th>
						<th>Title</th>
						<th>Description</th>
						<th>Field</th>
						<th>Display Url</th>
						<th>Status</th>
						<th width="150">Actions</th>
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->

<script>
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
				url: '<?= site_url('admin/results/link/delete/id/'); ?>' + id,
				type: 'DELETE',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else if (data == 1) {
						swal("Success!", "The link has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the link.", "error")
				}
			});
		});
	}

	// get priorites of the links for the given field
	function getPriorities(fieldId) {

		var selectElement = document.getElementById("priority");
		selectElement.disabled = true;
		while (selectElement.length > 0) {
			selectElement.remove(0);
		}

		if (fieldId == "") return;
		$.ajax({
			url: '<?= site_url('admin/results/links/priorities/field/id/'); ?>' + fieldId,
			type: 'GET',
			beforeSend: function(xhr, options) {
				$("#priority-loader").css("display", "inline-block");
				setTimeout(function() {
					$.ajax($.extend(options, {
						beforeSend: $.noop
					}));
				}, 500);
				return false;
			},
			success: function(data, status) {
				var obj = JSON.parse(data);
				for (i = 1; i <= 250; i++) {
					// check if any field has taken the priority value (1-250)
					var field = searchArray(i, obj);

					if (field) {
						$("#priority").append('<option value="' + i + '" disabled>' + i + ' - ' + field.title + '</option>');
					} else {
						$("#priority").append('<option value="' + i + '">' + i + '</option>');
					}
				}
				$('#priority').attr('disabled', false);
				$("#priority").selectpicker('refresh');
			},
			complete: function() {
				$("#priority-loader").css("display", "none");
			},
			error: function(xhr, status, error) {
				toastr.error("Error getting priorities.");
			}
		});
	}

	// Move or duplicate a link to a field
	function moveOrDuplicate() {
		var id = $("[name=link_id]").val();
		var field_id = $("[name=field_id]").val().trim();
		var priority = $("[name=priority]").val();
		var option = $("[name=option-select]:checked").val();
		var url;
		if (option == 1) {
			url = '<?= site_url(); ?>admin/results/link/duplicate/id/' + id + '/field/' + field_id + '/priority/' + priority;
		} else if (option == 2) {
			url = '<?= site_url(); ?>admin/results/link/move/id/' + id + '/field/' + field_id + '/priority/' + priority;
		}
		$.ajax({
			url: url,
			type: 'GET',
			beforeSend: function(xhr, options) {
				$("#btn-modal-submit").attr("class", "btn m-btn btn-success m-loader m-loader--light m-loader--right");
				setTimeout(function() {
					$.ajax($.extend(options, {
						beforeSend: $.noop
					}));
				}, 2000);
				return false;
			},
			success: function(data, status) {
				$("#modal_option").modal('hide');
				if (data == -1) {
					toastr.warning("", "You have no permission.");
				} else if ((data == 1)) {
					// hide the link from the list
					if (option == 1) {
						toastr.success("The link has been duplicated.");
					} else if (option == 2) {
						toastr.success("The link has been moved.");
						$("#" + id).fadeOut("slow");
					}
				}
			},
			error: function(xhr, status, error) {
				$("#modal_option").modal('hide');
				toastr.error("Unable to process request.");
			}
		});
	}

	// move of duplicate dialog
	function moveOrDuplicateDialog(id) {
		$.ajax({
			url: '<?= site_url(); ?>admin/results/link/get/id/' + id, // get link information
			type: 'GET',
			contentType: 'json',
			success: function(data, status) {
				$("#link_id").val(data.id);
				// $("#field").val(data.field_id);
				// $("#field").html(data.field);
				$("#btn-modal-submit").attr("class", "btn m-btn btn-success");
				$("#btn-modal-submit").show();
				//getPriorities(data.field_id);
			},
			error: function(xhr, status, error) {
				toastr.error("Unable to retrieve link information.");
			}
		});
	}

	// search for links and fetch into datatable
	function searchLinks(keywords) {
		// escape special charactors
		keywords = encodeURIComponent(keywords)

		if (keywords === "") $('#m_table_1').DataTable().clear().draw();
		else $('#m_table_1').DataTable().ajax.url("<?= site_url() ?>admin/results/links/get/keywords/" + keywords).load();
	}

	// helper method to search for a key in an array
	function searchArray(key, array) {
		for (var i = 0; i < array.length; i++) {
			if (array[i].priority == key) {
				return array[i];
			}
		}
		return false;
	}

	//Toggles link active status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/results/link/toggle/id/'); ?>' + id,
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
				} else if (data == -1) {
					toastr.warning("", "You have no permission.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to update status.");
			}
		});
	}

	//Toggles link redirection
	function toggleRedirect(id) {
		$.ajax({
			url: '<?= site_url('admin/results/link/redirect/id/'); ?>' + id,
			type: 'GET',
			success: function(data, status) {
				if (data == 0) {
					document.getElementById("redirect" + id).style.color = "red";
					toastr.success("", "BrandLink disabled.");
				} else if (data == 1) {
					document.getElementById("redirect" + id).style.color = "#34bfa3";
					toastr.success("", "BrandLink enabled.");
				} else if (data == -1) {
					toastr.warning("", "You have no permission.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to update redirection.");
			}
		});
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				bFilter: false,
				dom: '<"top"lfp>rt<"bottom"ip><"clear">',
				rowId: "id",
				searchDelay: 500,
				processing: !0,
				serverSide: !1,
				columns: [{
					data: "priority"
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
						var redirectVal;
						if (e['redirect'] == 0) redirectVal = "red";
						else redirectVal = "#34bfa3";
						var title = e['title'].replace(/ /g, '%20');
						var row = (n.row).toString().slice(-1);
						//return'<a onclick="showResultDetails('+e['id']+')" data-toggle="modal" data-target="#m_modal_2" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="la la-search-plus"></i></a>'
						return '<a href="<?= site_url() . "admin/results/link/update/id/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
							'<a onclick=moveOrDuplicateDialog(' + e['id'] + ') data-toggle="modal" data-target="#modal_option" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Move/Duplicate"><i class="la la-copy"></i></a>' +
							'<a onclick=toggleRedirect("' + e['id'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="BrandLink"><i style="color:' + redirectVal + '" id="redirect' + e['id'] + '" class="la la-share"></i></a>' +
							'<a onclick=deleteLink("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
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
		DatatablesDataSourceAjaxServer.init();
	});

	$("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-results-links").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>