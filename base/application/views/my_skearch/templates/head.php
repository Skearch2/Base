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
		<link href="<?= site_url(ASSETS); ?>/my_skearch/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/my_skearch/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/base/style.bundle.css" rel="stylesheet" type="text/css">
		<link href="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/custom/style.css" rel="stylesheet" type="text/css">

		<!-- Background Image -->
		<style>
			body {
				background:
					linear-gradient(0deg, rgba(226, 248, 197, 0.500), rgba(226, 248, 197, 0.500));
				url(<?= site_url(ASSETS); ?>/my_skearch/app/media/img/bg/bg-3.jpg);
				background-size: cover;
			}

			.demo {
				/* margin: 150px auto; */
				max-width: 960px;
			}

			.demo .toutiao-wrap {
				border: 1px solid #ccc;
				width: 272px;
			}

			.demo .toutiao {
				width: 350px;
				height: 96px;
				overflow: hidden;
				margin: 9px 10px;
			}

			.demo .toutiao ul {
				width: 350px
			}

			.demo .toutiao ul li {
				width: 350px;
				height: 48px
			}

			.demo .toutiao p {
				width: 350px;
				height: 40px;
				overflow: hidden
			}

			.demo .toutiao a {
				text-decoration: none
			}

			.demo .toutiao a:hover {
				color: #F60
			}

			.demo .toutiao a:hover i {
				color: #F60
			}

			.demo .toutiao i {
				margin-right: 5px;
				color: #F60
			}
		</style>
		<!--end::Global Theme Styles -->

		<link rel="shortcut icon" href="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/media/img/logo/favicon.ico" />
	</head>

	<!-- end::Head -->