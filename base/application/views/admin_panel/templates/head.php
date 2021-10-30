	<!-- begin::Head -->

	<head>
		<meta charset="utf-8" />
		<title><?= $title; ?></title>
		<meta name="description" content="Blank inner page examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->


		<!--begin::Global Theme Styles -->
		<link href="<?= site_url(ASSETS); ?>/admin_panel/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/style.bundle.css" rel="stylesheet" type="text/css">
		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css">
		<!-- <link href="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/easy-autocomplete.min.css" rel="stylesheet" type="text/css"> -->
		<link href="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/staff-messaging.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/tagsinput.css" rel="stylesheet" type="text/css">
		<!--end::Page Vendors Styles -->

		<!--Custom style for datatable -->
		<style>
			.dataTables_wrapper .dataTables_length {
				float: left;
			}

			.dataTables_wrapper .dataTables_filter {
				float: left;
				padding-left: 25%;
			}

			.dataTables_wrapper .dataTables_info {
				float: left;
			}
		</style>

		<link rel="shortcut icon" href="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/media/img/logo/favicon.ico" />
	</head>

	<!-- end::Head -->