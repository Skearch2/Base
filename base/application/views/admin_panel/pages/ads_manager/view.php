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
						<?= ucwords($scope) ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-outline-danger m-btn m-btn--wide m-btn--icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?= ucwords($is_archived == 0 ? 'library' : 'archived') ?>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/<?= $banner ?>/show/library">Library</a>
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/<?= $banner ?>/show/archived">Archived</a>
							</div>
						</div>
					</li>
					<li class="m-portlet__nav-item">
						<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-outline-brand m-btn m-btn--wide m-btn--icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Banner <?= strtoupper($banner) ?>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/a/show/library">Banner A</a>
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/b/show/library">Banner B</a>
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/u/show/library">Banner U</a>
								<a class="dropdown-item" href="<?= site_url(); ?>admin/ads/manager/view/<?= $scope ?>/banner/va/show/library">Banner VA</a>

							</div>
						</div>
					</li>
					<li class="m-portlet__nav-item">
						<a href="<?= site_url("admin/ads/manager/create/{$scope}/banner/{$banner}") ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-plus-circle"></i>
								<span>Create</span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">

			<?php if ($this->session->flashdata('create_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The ad has been created.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('create_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to create the ad.
					</div>
				</div>
			<?php endif ?>

			<?php if ($this->session->flashdata('update_success') === 1) : ?>
				<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						The ad has been updated.
					</div>
				</div>
			<?php elseif ($this->session->flashdata('update_success') === 0) : ?>
				<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						Unable to update the ad.
					</div>
				</div>
			<?php endif ?>

			<!-- bootstrap modal where the image will appear -->
			<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>
						<div class="modal-body">
							<img id="imagepreview" style="display:block; max-width:600px; max-height:600px;">
						</div>
					</div>
				</div>
			</div>

			<!-- bootstrap modal where the video will appear -->
			<div class="modal fade" id="videomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>
						<div class="modal-body">
							<video controls autoplay id="videopreview">
								Unable to play video, incompatible browser.
							</video>
						</div>
					</div>
				</div>
			</div>

			<?php if ($is_archived) : ?>
				<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_archived">
					<thead>
						<tr>
							<th>Ad ID</th>
							<th>Brand</th>
							<th>Title</th>
							<th width="20px">Thumbnail</th>
							<th>Actions</th>
						</tr>
					</thead>
				</table>
			<?php else : ?>
				<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_library">
					<thead>
						<tr>
							<th>Priority</th>
							<th>Ad ID</th>
							<th>Brand</th>
							<th>Title</th>
							<th width="20px">Thumbnail</th>
							<th>Duration</th>
							<th>Clicks</th>
							<th>Impressions</th>
							<th>Ad Sign</th>
							<th>Active</th>
							<th>Last Modified</th>
							<th>Date Created</th>
							<th>Actions</th>
						</tr>
					</thead>
				</table>
			<?php endif ?>
		</div>
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

<script>
	// Archive ad
	function archiveAd(id, title) {
		var title = title.replace(/%20/g, ' ');
		swal({
			title: "Archive Ad: " + title,
			text: "Are you sure you want to archive this ad?",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, archive it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/ads/manager/archive/ad/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else {
						$("#" + id).remove();
						swal("Success!", "The ad has been archived.", "success")
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to archive the ad.", "error")
				}
			});
		});
	}

	// Delet ad
	function deleteAd(id, title) {
		var title = title.replace(/%20/g, ' ');
		swal({
			title: "Delete Ad: " + title,
			html: "Are you sure you want to delete this ad?<br>\
			<small>All clicks and impressions history will also be deleted.</small>",
			type: "warning",
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/ads/manager/delete/ad/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else {
						swal("Success!", "The ad has been deleted.", "success")
						$("#" + id).remove();
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to delete the ad.", "error")
				}
			});
		});
	}

	// Restore ad
	function restoreAd(id, title) {
		var title = title.replace(/%20/g, ' ');
		swal({
			title: "Restore Ad: " + title,
			text: "Are you sure you want to restore this ad?",
			type: "warning",
			confirmButtonClass: "btn btn-success",
			confirmButtonText: "Yes, restore it!",
			showCancelButton: true,
			timer: 5000
		}).then(function(e) {
			if (!e.value) return;
			$.ajax({
				url: '<?= site_url('admin/ads/manager/restore/ad/id/'); ?>' + id,
				type: 'GET',
				success: function(data, status) {
					if (data == -1) {
						swal("Not Allowed!", "You have no permission.", "warning")
					} else if (data == 1) {
						$("#" + id).remove();
						swal("Success!", "The ad has been restored.", "success")
					} else {
						swal("Error!", "Unable to restore the ad.", "warning")
					}
				},
				error: function(xhr, status, error) {
					swal("Error!", "Unable to process request.", "error")
				}
			});
		});
	}

	// Toggle ad active status
	function toggle(id, row) {
		$.ajax({
			url: '<?= site_url('admin/ads/manager/toggle/status/ad/id/') ?>' + id,
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
					// if the user has no access to toggle user status
				} else if (data == -1) {
					toastr.warning("", "You have no permission.");
				}
			},
			error: function(xhr, status, error) {
				toastr.error("", "Unable to change the status.");
			}
		});
	}

	// Show modal dialog to preview ads
	function view(src, isVideo = 0) {
		if (isVideo == 1) {
			$('#videopreview').attr('src', src);
			$('#videomodal').modal('show');
		} else {
			$('#imagepreview').attr('src', src);
			$('#imagemodal').modal('show');
		}
	}

	<?php if ($is_archived) : ?>
		var datatableArchived = {
			init: function() {
				$("#m_table_archived").DataTable({
					responsive: !0,
					dom: '<"top"lfp>rt<"bottom"ip><"clear">',
					rowId: "id",
					searchDelay: 500,
					processing: !0,
					serverSide: !1,
					ajax: "<?= site_url(); ?>admin/ads/manager/get/<?= $scope ?>/banner/<?= $banner ?>/archived/<?= $is_archived ?>",
					columns: [{
						data: "id"
					}, {
						data: "brand"
					}, {
						data: "title"
					}, {
						data: "media"
					}, {
						data: "Actions"
					}],
					columnDefs: [{
						targets: -1,
						orderable: !1,
						render: function(a, t, e, n) {
							var title = e['title'].replace(/ /g, '%20');
							return '<a onclick=restoreAd("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Restore"><i class="la la-undo"></i></a>' +
								'<a onclick=deleteAd("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>'
						}
					}, {
						targets: 2,
						render: function(a, t, e, n) {
							// check if the media is a video (only mp4 format)
							var isVideo = e['media'].substr(e['media'].length - 3) == 'mp4' ? 1 : 0;
							if (isVideo)
								return '<td><i title="View" class="fas fa-video" style="cursor:pointer" onclick="view(\'<?= site_url('base/media') ?>/' + e['media'] + '\',1)"></i></td>'
							else
								return '<td><img src="<?= site_url('base/media') ?>/' + e['media'] + '" title="View" alt="No Media" style="display:block; max-width:200px; max-height:100px; cursor:pointer;" onclick="view(\'<?= site_url('base/media') ?>/' + e['media'] + '\',0)"></td>'
						}
					}]
				})
			}
		}
	<?php else : ?>
		var datatableLibrary = {
			init: function() {
				$("#m_table_library").DataTable({
					responsive: !0,
					dom: '<"top"lfp>rt<"bottom"ip><"clear">',
					rowId: "id",
					rowReorder: {
						selector: 'td:nth-child(2)',
						dataSrc: 'priority'
					},
					searchDelay: 500,
					processing: !0,
					serverSide: !1,
					ajax: "<?= site_url(); ?>admin/ads/manager/get/<?= $scope ?>/banner/<?= $banner ?>/archived/<?= $is_archived ?>",
					columns: [{
						data: "priority"
					}, {
						data: "id"
					}, {
						data: "brand"
					}, {
						data: "title"
					}, {
						data: "media"
					}, {
						data: "duration"
					}, {
						data: "clicks"
					}, {
						data: "impressions"
					}, {
						data: "has_sign"
					}, {
						data: "is_active"
					}, {
						data: "date_modified"
					}, {
						data: "date_created"
					}, {
						data: "Actions"
					}],
					columnDefs: [{
						targets: -1,
						orderable: !1,
						render: function(a, t, e, n) {
							var title = e['title'].replace(/ /g, '%20');
							return '<a href="<?= site_url() . "admin/ads/manager/update/ad/id/" ?>' + e['id'] + '/<?= $scope ?>/banner/<?= $banner ?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>' +
								'<a onclick=archiveAd("' + e['id'] + '","' + title + '") class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive"><i class="la la-archive"></i></a>'
						}
					}, {
						targets: 4,
						render: function(a, t, e, n) {
							// check if the media is a video (only mp4 format)
							var isVideo = e['media'].substr(e['media'].length - 3) == 'mp4' ? 1 : 0;
							if (isVideo)
								return '<td><i title="View" class="fas fa-video" style="cursor:pointer" onclick="view(\'<?= site_url('base/media') ?>/' + e['media'] + '\',1)"></i></td>'
							else
								return '<td><img src="<?= site_url('base/media/') ?>' + e['media'] + '" title="View" alt="No Media" style="display:block; max-width:200px; max-height:100px; cursor:pointer;" onclick="view(\'<?= site_url('base/media') ?>/' + e['media'] + '\',0)"></td>'
						}
					}, {
						targets: 6,
						render: function(a, t, e, n) {
							return '<a href="<?= site_url('admin/ads/manager/view/activity/ad/id/') ?>' + e['id'] + '" title="View Details">' + e['clicks'] + '</a>'
						}
					}, {
						targets: 7,
						render: function(a, t, e, n) {
							return '<a href="<?= site_url('admin/ads/manager/view/activity/ad/id/') ?>' + e['id'] + '" title="View Details">' + e['impressions'] + '</a>'
						}
					}, {
						targets: 8,
						render: function(a, t, e, n) {
							var s = {
								0: {
									title: "No",
									state: "danger"
								},
								1: {
									title: "Yes",
									state: "accent"
								}
							};
							return void 0 === s[a] ? a : '<span class="m--font-bold m--font-' + s[a].state + '">' + s[a].title + "</span>"
						}
					}, {
						targets: 9,
						render: function(a, t, e, n) {
							var s = {
								1: {
									title: "Active",
									class: "m-badge--success"
								},
								0: {
									title: "Inactive",
									class: " m-badge--danger"
								}
							};
							return void 0 === s[a] ? a : '<span id= tablerow' + n['row'] + ' title="Toggle Status" onclick=toggle(' + e['id'] + ',' + n['row'] + ') class="m-badge ' + s[a].class + ' m-badge--wide" style="cursor:pointer">' + s[a].title + '</span>'
						}
					}, {
						targets: 10,
						render: function(a, t, e, n) {
							return new Date(e['date_modified']).toLocaleString();
						}
					}, {
						targets: 11,
						render: function(a, t, e, n) {
							return new Date(e['date_created']).toLocaleString();
						}
					}]
				})
			}
		}
	<?php endif ?>


	$(document).ready(function() {
		<?php if ($is_archived) : ?>
			datatableArchived.init();
		<?php else : ?>
			datatableLibrary.init();

			// on row reorder update ad priority
			var dt = $("#m_table_library").DataTable()
			dt.on('row-reorder', function(e, diff, edit) {
				var result = {}

				for (var i = 0, ien = diff.length; i < ien; i++) {
					var rowData = dt.row(diff[i].node).data();
					result[i] = {
						id: rowData['id'],
						priority: diff[i].newData
					}
				}

				$.ajax({
					url: '<?= site_url("admin/ads/manager/update/priority/banner/id/{$banner_id}"); ?>',
					type: 'GET',
					data: {
						priority: result
					},
					success: function(data, status) {
						if (data == -1) {
							swal("Not Allowed!", "You have no permission.", "warning")
						} else if (data === 0) {
							swal("Error!", "Unable to order priority.", "warning")
						}
					},
					error: function(xhr, status, error) {
						swal("Error!", "Unable to process request.", "error")
					}
				});
			});
		<?php endif ?>
	});
</script>


<!-- Sidemenu class -->
<script>
	$("#menu-brands").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
	$("#submenu-brands-ads-manager").addClass("m-menu__item  m-menu__item--active");
</script>