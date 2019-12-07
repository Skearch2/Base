<!--  Start body element -->
<?php
if(isset($page)){
	if($page=="default"){
			$css_cal='home_id';
	}else{
			$css_cal='';
	}
}else{
	$css_cal='';
}
?>
<body id="<?php echo $css_cal; ?>">
    <div id="main-wrapper">