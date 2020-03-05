<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title><?php echo $page['pageTitle']; ?> | <?php echo $settings['siteTitle']; ?> </title>
	<meta name="description" content="<?php echo $page['pageDescription']; ?> " />
	<meta name="keywords" content="<?php echo $page['pageKeywords']; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php if ($settings['siteFavicon'] != "") { ?>
		<link rel="icon" href="<?php echo BASE_URL; ?>/images/<?php echo $settings['siteFavicon']; ?>" />
	<?php } ?>
	<link href="<?php echo THEME_FOLDER; ?>/css/bootstrap.min.css" rel="stylesheet">
	<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<link href="<?php echo THEME_FOLDER; ?>/css/socicon.css" rel="stylesheet">
	<link href="<?php echo THEME_FOLDER; ?>/css/styles.css" rel="stylesheet">
</head>

<body>

	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<?php hooskNav('header') ?>
			</div>
		</div><!-- /.container -->
	</nav><!-- /.navbar -->
	
	<div class="container">
	<a class="navbar-brand" href="https://<?= $_SERVER['HTTP_HOST'] ; ?>">
		<img src="<?= BASE_URL; ?>/images/logo.jpg" alt="<?= $settings['siteTitle']; ?>">
	</a>
</div>
