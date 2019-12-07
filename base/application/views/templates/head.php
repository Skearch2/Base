<!--
	File:     ~/application/views/templates/head.php
	Author:   Fred McDonald - fred.mcdonald@live.com

	Defines global head element for every page.
	Defines global metadata, CSS, and JavaScript links
	Uses $data in view call to set canonical URL, page title.

-->
<head>
	<!-- Metadata -->
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139872847-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-139872847-1');
    </script>


	<!--	Set canonical URL for this page -->

	<!--
	* 	Link to:
	* 		**Stylesheets**
	* 		Global cascading stylesheet
	* 			OR Admin cascading stylesheet if admin flag is True
	* 		jQuery style CSS
	*	 	jQuery DataTable style CSS
	*      jQuery Tableizer style CSS
	-->



	<?php
	if($this->session->userdata('css')!=''){
		//echo $this->session->userdata('css');
		//echo $this->session->userdata('css1');
		if($this->session->userdata('css')=="light"){

	?>
	<link rel='stylesheet' href='<?=base_url(ASSETS);?>/style/css/style.css' />
	<?php
		}else{
	?>
	<link rel='stylesheet' href='<?=base_url(ASSETS);?>/style/css/darkstyle.css' />
	<?php
		}
	}else{
	?>
	<link rel='stylesheet' href='<?=base_url(ASSETS);?>/style/css/style.css' />
	<?php } ?>


	<?php

	if($this->session->userdata('css')!=''){
		//echo $this->session->userdata('css');
		if($this->session->userdata('css')=="light"){
	?>
	<link href="<?=base_url(ASSETS);?>/style/css/ns.css" rel="stylesheet" type="text/css" />
	<?php
		}else{
	?>
	<link href="<?=base_url(ASSETS);?>/style/css/darkns.css" rel="stylesheet" type="text/css" />
	<?php
		}
	}else{
	?>
	<link href="<?=base_url(ASSETS);?>/style/css/ns.css" rel="stylesheet" type="text/css" />
	<?php } ?>

	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
  <link href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">


	<!-- Detect IE 7/8 and load CSS -->
	<?php if (isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])): ?>
		<?php if (preg_match('/MSIE 8/i', $_SERVER['HTTP_USER_AGENT'])): ?>
			<link rel='stylesheet' href='".base_url(ASSETS)."/style/css/ie_css/css-ie8.css' />
		<?php elseif (preg_match('/MSIE 7/i', $_SERVER['HTTP_USER_AGENT'])): ?>
			<link rel='stylesheet' href='".base_url(ASSETS)."/style/css/ie_css/css-ie7.css' />
		<?php endif;?>
	<?php endif;?>

	<!--
	* 	Link to:
	*		** JavaScript **
	* 		jQuery script library
	* 		jQuery UI library
	* 		jQuery library for DataTables
	*      jQuery library for Multilevel table data
	* 		HTML5 JS shim for IE to recognize and style the HTML5 elements
	* 		Global JS script file (REPLACE THIS!)
	-->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!--
	* 	Link to:
	* 		** Icons **
	* 		Skearch icon file (page)
	* 		Skearch icon file (shortcut)
	-->
	<link rel='icon' href='<?=base_url(ASSETS);?>/style/images/favicon.png' type='image/png' />
	<link rel='shortcut icon' href='<?=base_url(ASSETS);?>/style/images/favicon.png' type='image/png' />

	<!--	Set page title passed from the Pages controller ($data['title']) -->
	<title><?=$title;?></title>

	<style>
  	.tbtn
  	{
  		margin-bottom:15px
  	}
  	@media only screen and (max-width:600px){
  		.tbtn
  		{
  		clear:both;
  		}
  	}
  	footer {
  		margin-top: 0;
  	}
	</style>

	<script type="text/javascript">
		function submit_me() {
			document.google_search_form.submit();
		}
	</script>

<script type="text/javascript">
	$(document).ready(function(){

	$('#bubble_shutdown').click(function() {

  var src = $('#bubble_shutdown').attr('src');

  if(src=='<?=base_url(ASSETS);?>/style/images/moon_theme.png')
  {
	  var a = 'dark';
	  $('#bubble_shutdown').attr('src','<?=base_url(ASSETS);?>/style/images/moon_theme.png');
  }
  else
  {
	  var a = 'light';
	   $('#bubble_shutdown').attr('src','<?=base_url(ASSETS);?>/style/images/sun_theme.png');
  }

  jQuery.post( "<?php echo base_url();?>setchange/changecss",{'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>','css':a} , function( data ) {
	  	window.location.reload();
  });


 });

});

function ajaxSearch(keyword) {
    $.ajax({
        url: '<?= site_url(); ?>/search?search_keyword=' + keyword,
        type: 'GET',
        async: false,
        success: function(data) {
            urlObj = JSON.parse(data);
            if(urlObj.type == 'external')
                window.open(urlObj.url);
            else if (urlObj.type == 'internal')
                window.location.replace(urlObj.url);
        },
        error: function(data) {
            alert("Something went wrong. Can't Search");
        }

    });
}

function searchBtn() {
  toastr.success("Searching for results...");
}

jQuery(document).ready(function() {
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
});

</script>

<!-- Update image impressions shown on media boxes -->
<script>
	$(function(){
		$('.carousel').on('slide.bs.carousel', function(event) {
	    imageid = $(event.relatedTarget).attr('data-imageid');
      $.get( "<?= site_url("impression/image/id/"); ?>" + imageid, function() {
      });
	  })
	});
</script>

 <style>
 #navigation_top_welcome{
	font-family: 'Conv_NeoSans_4';
}
@font-face {
	font-family: 'Conv_NeoSans_4';
	src: url('<?=base_url(ASSETS);?>/fonts/NeoSans_4.eot');
	src: local('☺'), url('<?=base_url(ASSETS);?>/fonts/NeoSans_4.woff') format('woff'), url('<?=base_url(ASSETS);?>/fonts/NeoSans_4.ttf') format('truetype'), url('fonts/NeoSans_4.svg') format('svg');
	font-weight: normal;
	font-style: normal;
}
#navigation_top_date{
font-family: 'Conv_NeoSans_4';
    margin-top: 12px;
}
.skearch-result-blue
{
	width: 100%;
}
.result-btn-area-blue ul
{
	    padding: 10px 10px 0px;
    overflow: hidden;
    min-height: 128px;
    -moz-border-radius: 0 4px 0 0;
    border: 1px solid #ddd;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    height: 100px;
    overflow-y: scroll;
    background: #fff;
}
.result-btn-area-blue li {
    width: auto;
}
.result-btn-area-blue li a {
    background: transparent;
    color: #545454;
    display: inline-block;
    font-size: 18px;
    text-align: center;
    font-family: 'Conv_NeoSans_4';
    border: 1px solid #7fa006;
    padding: 4px 16px;
	width: auto;
    border-radius: 6px;
}
.search-box input.google-input
{
	height: 60px;
}
.accessorize-list li>a
{
	background:transparent;
}
.slider .flexslider img
{
	    width: 100%;
    height: 100px;
    object-fit: cover;
}
@media only screen and (max-width:600px)
{
	.tbtn {
    float: none;
    margin-top: 10px;
}
#navigation_top_date {
    text-align: center;
}
.top-inner {
    width: 100%;
}
.logo-result {
    float: none;
    text-align: center;
    margin: 0 auto;
}
.top-inner-right-result {
    width: 100%;
    padding: 0 15px 15px;
}
.search-box-top {
    width: 100%;
}
.search-box-top input.google-input {
    width: 100%;
}
.result-btn-div {
    float: left;
    width: 100%;
    text-align: center;
}
a.btn-cat {
    display: block;
    margin: 0 auto;
    float: none !important;
}
.result-btn-area-blue {
        width: 100%;
    padding: 0 15px;
    margin-bottom: 20px;
}
.result-btn-area-blue ul {
    width: 100%;
}
.banner-container-bottom {
    width: 100% !important;
}
.result-btn-right-blue {
    text-align: left;
}
.middle-inner
{
	width:100%;
}
.result-btn-area-blue-field li a {
    font-size: 14px;
}
.result-right {
    float: none;
    width: 100%;
}
.banner-container-right {
    width: 100%;
}
.banner-container-right img {
    width: 100%;
}
.mp0
{
	margin:auto;
}
.search-box-top input.google-input {
    background: transparent;
    line-height: 36px;
    border: 4px double #ddd !important;
    border-radius: 30px;
}
.result-btn-area-blue-field {
    padding: 0 15px;
}
.skearch-result-blue {
    margin-bottom: 20px;
}
}
@media only screen and (min-width:601px) and (max-width:768px)
{
	.top-inner {
    width: 100%;
}
.logo-result {
    float: none;
    text-align: center;
}
.top-inner-right-result {
    float: left;
    width: 100%;
    padding-top: 0;
    padding: 0 30px 30px;
}
.search-box-top {
    width: 82%;
}
.search-box-top input.google-input {
    background:transparent;
    width: 100%;
    line-height: 36px;
    border: 4px double #ddd !important;
    border-radius: 30px;
}
.result-btn-div {
    width: 18%;
}
.result-btn-area-blue {
    width: 100%;
}
.result-btn-area-blue ul {
    width: 100%;
}
.banner-container-bottom {
    width: 600px !important;
}
.middle-inner {
    width: 100%;
}
.result-btn-area-blue-field li a {
    font-size: 14px;
}
.result-btn-right-blue {
    text-align: left;
}
.mp0
{
	margin-right: auto;
    margin-left: auto;
}
.skearch-result-blue
{
	    margin-bottom: 30px;
}
.slider_right
{
	padding-bottom:0;
}
.result-btn-area-blue-field {
    padding: 0 15px;
}
.result-right
{
	text-align: center;
    float: none;
    margin: 0px auto;
}
}

.media-box-a {display:none;}
.media-box-b {display:none;}
.media-box-u {display:none;}

 </style>

</head>
