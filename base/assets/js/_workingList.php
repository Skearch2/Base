if(!stripos($_SERVER['SCRIPT_NAME'], 'user_index.php')) {
	$PMDR->loadJavascript('<script type="text/javascript" src="'.CDN_URL.'/includes/jquery/jquery.flexslider.js"></script>',10);
    $PMDR->loadJavascript('<script type="text/javascript" src="'.$PMDR->get('Templates')->urlCDN('jquery.fileUploader.js').'"></script>',15);


}

if(stripos($_SERVER['SCRIPT_NAME'], 'user_account_add.php')){
    $PMDR->loadJavascript('<script type="text/javascript" src="'.CDN_URL.'/includes/jquery/jquery_custom.js"></script>',10);
}






$PMDR->loadCSS('<link rel="stylesheet" type="text/css" href="'.CDN_URL.'/imguploadcss/fileUploader.css" />',10);



$PMDR->loadJavascript('<script type="text/javascript" src="'.$PMDR->get('Templates')->urlCDN('javascript.js').'"></script>',15);
$PMDR->loadJavascript('<script type="text/javascript" src="'.CDN_URL.'/includes/javascript_global.js"></script>',15);
