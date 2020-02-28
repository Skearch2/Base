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
						<input type="text" onkeyup="search_adlink(this.value)" class="form-control" placeholder="Search..." name="query">
					</li>
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/categories/create_result"); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-cart-plus"></i>
								<span>Add Link</span>
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
		<div class="modal fade" id="modal_option" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="option-dialog"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<input type="hidden" id="link_id" name="link_id" value="">
							<div class="form-group m-form__group row">
								<label for="example-text-input" class="col-2 col-form-label">Field</label>
								<div class="col-7">
									<select class="form-control" name="field_id" onchange="updatePriority(this.value)" required>
										<option id="field" selected value="">Select</option>
										<?php foreach ($fields as $field) : ?>
											<option value="<?= $field->id ?> <?= set_select("field", $field->id) ?>"><?= $field->title ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label for="example-text-input" class="col-2 col-form-label">Priority</label>
								<div class="col-7">
									<select class="form-control" id="priority" name="priority" disabled>
										<option selected value="">Not Set</option>
										<?php for ($i = 1; $i <= 250; $i++) : ?>
											<?php if (in_array($i, $priorities)) : ?>
												<option style="background-color: #99ff99" value="<?= $i ?>" disabled><?= $i ?></option>
											<?php else : ?>
												<option value="<?= $i ?> <?= set_select("priority", $i) ?>"><?= $i ?></option>
											<?php endif; ?>
										<?php endfor; ?>
									</select>
								</div>
							</div>
							<div class="m-form__group form-group row">
								<label class="col-3 col-form-label">Action</label>
								<div class="col-9">
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
						<button type="button" id="btn-option-action" class="btn btn-primary" onclick="moveOrDuplicate()">Submit</button>
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

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
	// move of duplicate option dialog
	function optionDialog(id) {
		$.ajax({
			url: '<?= site_url(); ?>admin/results/links/get/id/' + id,
			type: 'GET',
			contentType: 'json',
			success: function(data, status) {
				$("#option-dialog").html(data.title);
				$("#link_id").val(data.id);
				$("#field").val(data.umbrella_id);
				$("#field").html(data.umbrella);
				$("#btn-option-action").attr("class", "btn m-btn btn-success");
				$("#btn-option-action").show();
				updatePriority(data.umbrella_id);
			},
			error: function(xhr, status, error) {
				alert("Unable to retrieve link information");
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
			url = '<?= site_url(); ?>admin/results/links/duplicate/id/' + id + '/field/' + field_id + '/priority/' + priority;
		} else if (option == 2) {
			url = '<?= site_url(); ?>admin/results/links/move/id/' + id + '/field/' + field_id + '/priority/' + priority;
		}
		$.ajax({
			url: url,
			type: 'GET',
			beforeSend: function(xhr, options) {
				$("#btn-option-action").attr("class", "btn m-btn btn-success m-loader m-loader--light m-loader--right");
				setTimeout(function() {
					$.ajax($.extend(options, {
						beforeSend: $.noop
					}));
				}, 2000);
				return false;
			},
			success: function(data, status) {
				$("#btn-option-action").hide();
				if (option == 2) {
					$("#" + id).fadeOut("slow");
				}
			},
			error: function(xhr, status, error) {
				alert("Unable to take action to the link");
			}
		});
	}

	function deleteCategory(id, title) {
		var title = title.replace(/%20/g, ' ');
		var result = confirm("Are you sure you want delete listing \"" + title + "\"?");
		if (result) {
			$.ajax({
				url: '<?= site_url(); ?>admin/categories/delete_result_listing/' + id,
				type: 'DELETE',
				success: function(data, status) {
					$("#" + id).fadeOut("slow");
					//$('#m_table_1').DataTable().ajax.reload(null, false);
				}
			});
		}
	}

	/* Disable/Enable item*/
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url(); ?>admin/categories/toggle_result/' + id,
			type: 'GET',
			success: function(status) {
				if (status == 0) {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--danger m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Off";
				} else {
					document.getElementById("tablerow" + row).className = "m-badge m-badge--success m-badge--wide";
					document.getElementById("tablerow" + row).innerHTML = "Active";
				}
			},
			error: function(xhr, status, error) {
				alert("Error toggle Ad-link");
			}
		});
	}

	/* Disable/Enable redirection*/
	function toggleRedirect(id) {
		$.ajax({
			url: '<?= site_url(); ?>admin/categories/toggle_redirect/' + id,
			type: 'GET',
			success: function(data, status) {
				if (status == 0) {
					document.getElementById("redirect" + id).style.color = "red";
				} else {
					document.getElementById("redirect" + id).style.color = "#34bfa3";
				}
			},
			error: function(xhr, status, error) {
				alert("Error toggle Priority");
			}
		});
	}

	var DatatablesDataSourceAjaxServer = {
		init: function() {
			$("#m_table_1").DataTable({
				responsive: !0,
				bFilter: false,
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
				ajax: "",
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
							return '<a href="<?= site_url() . "admin/categories/update_result/" ?>' + e['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=optionDialog(' + e['id'] + ') data-toggle="modal" data-target="#modal_option" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Move/Duplicate"><i class="la la-copy"></i></a>' +
								'<a onclick=toggleRedirect("' + e['id'] + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Redirect"><i style="color:' + redirectVal + '" id="redirect' + e['id'] + '" class="la la-globe"></i></a>' +
								'<a onclick=deleteCategory("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i style="color:RED" class="la la-trash"></i></a>'
						}
					},
					{
						targets: 5,
						render: function(a, t, e, n) {
							var s = {
								2: {
									title: "Pending",
									class: "m-badge--brand"
								},
								1: {
									title: "Active",
									class: " m-badge--success"
								},
								0: {
									title: "Off",
									class: " m-badge--danger"
								}
							};
							return void 0 === s[a] ? a : '<span style="cursor: pointer;" id= tablerow' + n['row'] + ' onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + "</span>"
						}
					}
				]
			})
		}
	}

	function search_adlink(title) {

		var baseUrl = <?= json_encode(BASE_URL); ?>;

		// $('#m_table_1').fadeOut("slow");
		if (title === "") $('#m_table_1').DataTable().clear().draw();
		else $('#m_table_1').DataTable().ajax.url(baseUrl + "admin/categories/search_adlink/" + title).load();
		//$('#m_table_1').fadeIn("slow");
	}

	jQuery(document).ready(function() {
		DatatablesDataSourceAjaxServer.init();
	});
</script>

<script>
	$("#smenu_data").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
</script>

<script>
	jQuery(document).ready(function() {
		Dashboard.init(); // init metronic core componets
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-bottom-right",
			"onclick": null,
			"showDuration": "500",
			"hideDuration": "500",
			"timeOut": "1500",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
	});

	$("#smenu_data").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	//$( "#priority" ).prop( "disabled", true );

	function updatePriority(id) {
		toastr.info("", "Updating Priority...");

		var selectElement = document.getElementById("priority");
		selectElement.disabled = true;
		while (selectElement.length > 0) {
			selectElement.remove(0);
		}

		if (id == "") return;
		$.ajax({
			//changes
			url: '<?= site_url(); ?>admin/categories/get_links_priority/' + id,
			type: 'GET',
			success: function(data, status) {
				var obj = JSON.parse(data);
				var option = document.createElement("option");
				option.text = "Not Set";
				option.value = 0;
				selectElement.add(option);

				for (i = 1; i <= 255; i++) {
					var option = document.createElement("option");
					var array = searchArray(i, obj);
					if (array) {
						option.text = i + " - " + array.title;
						option.value = i;
						option.style.backgroundColor = "#99ff99";
						option.disabled = true;
					} else {
						option.text = i;
						option.value = i;
					}
					selectElement.add(option);
					selectElement.disabled = false;
				}
			},
			error: function(xhr, status, error) {
				alert("Error Updating Priority");
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
</script>
