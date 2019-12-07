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
						google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700","Asap+Condensed:500"]},
						active: function() {
								sessionStorage.fonts = true;
						}
					});
				</script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="<?= site_url(ASSETS); ?>/my_skearch/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/demo8/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/media/img/logo/favicon.ico" />
	</head>

	<!-- end::Head -->
