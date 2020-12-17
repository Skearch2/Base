	<!-- begin::Head -->

	<head>
		<meta charset="utf-8" />
		<title><?= $title; ?></title>
		<meta name="description" content="Blank inner page examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139872847-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'UA-139872847-1');
		</script>

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700", "Asap+Condensed:500"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="<?= site_url(ASSETS) ?>/auth/vendors/custom/slidercaptcha/slidercaptcha.css" rel="stylesheet">
		<link href="<?= site_url(ASSETS) ?>/auth/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS) ?>/auth/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS) ?>/auth/css/style.css" rel="stylesheet" type="text/css">
		<!--end::Global Theme Styles -->

		<link rel="shortcut icon" href="<?= site_url(ASSETS); ?>/auth/img/favicon.ico" />
	</head>

	<!-- end::Head -->