<?php
$PMDR->get('Plugins')->run_hook('template_header_begin');

// If a custom header file is set, use it, or else use the default header.tpl file
if($PMDR->get('header_file') AND $PMDR->get('Templates')->path($PMDR->get('header_file'))) {
    $header = $PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.$PMDR->get('header_file'));
} else {
    $header = $PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.'header.tpl');
}

// Check for maintenance option and show header message bar if necesarry
if($PMDR->getConfig('maintenance') AND @in_array('admin_login',$_SESSION['admin_permissions'])) {
    $header->set('maintenance',true);
} else {
    $header->set('maintenance',false);
}









// Set the display of the search form
if($PMDR->getConfig('search_display_all') OR on_page('/index.php')) {
    $header->set('searchform',$searchform);
    $header->set('search_display_all',($PMDR->getConfig('search_display_all') OR on_page('/index.php')));
}















// Load javascript set in the administrative area
$PMDR->loadJavascript($PMDR->getConfig('head_javascript'));

// Set and load the onload javascript
$onLoad = '<script type="text/javascript">'."\n";
$onLoad .= '//<![CDATA['."\n";
$onLoad .= '$(window).load(function(){';
$onLoad .= '$.ajaxSetup({url:"'.BASE_URL.'/ajax.php",type:"POST",data:{from_pmd:"'.$PMDR->get('Cleaner')->clean_output_js((isset($_COOKIE['from_pmd']) ? $_COOKIE['from_pmd'] : from_pmd)).'"}});';
if($PMDR->get('javascript_onload')) {
    $onLoad .= implode("\n",$PMDR->get('javascript_onload'));
}
if(!$PMDR->getConfig('disable_cron')) {
    $onLoad .= '$.getScript("'.BASE_URL.'/cron.php?type=javascript");';
}
$onLoad .= '});'."\n";
$onLoad .= '//]]>'."\n";
$onLoad .= '</script>'."\n";
$PMDR->loadJavascript($onLoad,25);
unset($onLoad);

// Set the javascript and css in the template
$header->set('javascript',$PMDR->getJavascript());
$header->set('css',$PMDR->getCSS());

// Add title from configuration to end of array and display, seperated by a dash -
$header->set('title',$PMDR->getConfig('title'));

if($PMDR->get('meta_title') != '') {
    array_pop($PMDR->data['page_title']);
    $PMDR->setAdd('page_title',$PMDR->get('meta_title'));
}

$header->set('page_title',implode(' - ',array_filter(array_reverse((array) $PMDR->get('page_title')))));

if($PMDR->get('breadcrumb')) {
    $header->set('breadcrumb',$PMDR->get('breadcrumb'));
} else {
    $header->set('breadcrumb',false);
}

$custom_slider_interval_variable = $PMDR->getConfig('custom_slider_interval_variable');
$header->set('custom_slider_interval_variable',$custom_slider_interval_variable);
// Set the 2 character language code in the template
$header->set('languagecode',substr($PMDR->getLanguage('languagecode'),0,2));

// Set the text direction
$header->set('textdirection',$PMDR->getLanguage('textdirection'));

$is_umbrella = $PMDR->get('is_umbrella');
$category_id = $PMDR->get('active_category');
$catId = isset($category_id['id']) && !empty($category_id['id']) ? $category_id['id'] : 0;
$records = $db->GetAll("SELECT * FROM ".T_BANNERS." pb LEFT JOIN ".T_BANNERS_CATEGORIES." pbc ON pb.id = pbc.banner_id where pb.type_id = '13' AND pbc.category_id = ".$catId." AND pb.hidden=0 AND pb.status IN('Approved','active') AND pb.hidden=false");
$is_primary = (isset($records) && count(($records)) > 0) ? TRUE : FALSE;
$records = $db->GetAll("SELECT GROUP_CONCAT(related_id) as related_cat_ids FROM pmd_categories_related pcr INNER JOIN pmd_categories pc on pc.id = pcr.category_id where pcr.category_id = '5'");

if ($records[0]['related_cat_ids'] == "") {
    $charity_cat_arr[] = "5";
} else {
    $charity_cat_ids = $records[0]['related_cat_ids'].",5";
    $charity_cat_arr = explode(",",$charity_cat_ids);
}

if (in_array($catId, $charity_cat_arr)) {
    $is_charity = "Yes";
} else {
    $is_charity = "No";
}


if($catId != 0) {
	$banner_types_result = hasBanners($catId);
}

if (in_array(13, $banner_types_result)) {
    $sql_type = "pb.type_id IN (13)";   // for primary
} elseif (in_array(19, $banner_types_result)) {
    $sql_type = "pb.type_id IN (19)";   // for umbrealla Default
} else {
    $sql_type = "pb.type_id IN (7)";    // for Top All
}

$sql = "SELECT pb.*,GROUP_CONCAT(pbc.category_id) as category
        FROM ".T_BANNERS." pb LEFT JOIN ".T_BANNERS_CATEGORIES." pbc ON pb.id = pbc.banner_id LEFT JOIN
        `pmd_banner_impressions_clicks` pbic ON pb.id = pbic.banner_id AND pbc.category_id = pbic.category_id AND pb.type_id = pbic.banner_type_id
        WHERE pbc.category_id = $catId AND pb.hidden=0 AND pb.status IN('Approved','active') AND $sql_type AND pb.hidden=false AND (pb.custom_position = 'top' OR pb.custom_position IS NULL)
        GROUP BY pb.id
        ORDER BY pbic.clicks DESC, pbic.date DESC, pbic.impressions DESC, pb.display_order";

$banners = $db->GetAll($sql);

if (count($banners) == 0) {
    $banners = $db->GetAll("SELECT pb.*,GROUP_CONCAT(pbc.category_id) as category
    FROM ".T_BANNERS." pb LEFT JOIN ".T_BANNERS_CATEGORIES." pbc ON pb.id = pbc.banner_id
    WHERE pbc.category_id = $catId AND pb.hidden=0 AND pb.status IN('Approved','active') AND $sql_type AND pb.hidden=false AND (pb.custom_position = 'top' OR pb.custom_position IS NULL)
    GROUP BY pb.id
    ORDER BY pb.display_order");
}

if (count($banners) == 0) {
    $banners = $db->GetAll("SELECT pb.*
    FROM ".T_BANNERS." pb
    WHERE pb.hidden=0 AND pb.status IN('Approved','active') AND $sql_type AND pb.hidden=false AND (pb.custom_position = 'top' OR pb.custom_position IS NULL)
    GROUP BY pb.id
    ORDER BY pb.display_order");
}
/*****  Banners Priority Changes - Primary > Umbrella Default > Top All Ends]*****/

$bannerID = $banners[0]['id'];
$type_id = $banners[0]['type_id'];
$result = $db->GetRow("SELECT id FROM ".T_BANNER_IMPR_CLICK." WHERE date = CURDATE() AND banner_id=? AND banner_type_id=? AND category_id=?",array($bannerID,$type_id,$catId));

if (!empty($result)) {
    $results = $db->Execute("UPDATE ".T_BANNER_IMPR_CLICK." SET impressions=impressions+1 WHERE id=?",array($result['id']));
} else {
    $results = $db->Execute("INSERT INTO ".T_BANNER_IMPR_CLICK." (`banner_id`,`banner_type_id`,`impressions`,`clicks`,`date`,`category_id`) VALUES ('".$bannerID."','".$type_id."','1','0',CURDATE(),'".$catId."')");
}

//Start section for the banner
$bannerCode = "";
if (count($banners)>0) {

    for ($i=0;$i<count($banners);$i++) {
        
        $arrCat = $PMDR->get('active_category');
        $iCatId = $arrCat['id'];
        $arrCategoryId = array();
        $arrCategoryId = explode(',',$banners[$i]['category']);

        if ($banners[$i]['type_id'] == '13' && !in_array($iCatId,$arrCategoryId)) {
             $bannerCode .= "";
        } else {
            $display_time = $banners[$i]['display_time'] * 1000;
            $bannerCode.="<li id='".$banners[$i]['id']."_".$banners[$i]['display_time']."_".$banners[$i]['type_id']."_".$catId."' data-duration='".$display_time."'>";
            $target = $banners[$i]['target'];
            $title = $banners[$i]['title'];
            $alt_text = $banners[$i]['alt_text'];
            //$url = $banners[$i]['url'];
            if (strstr($banners[$i]['url'], 'http://') || strstr($banners[$i]['url'], 'https://')){
                $url = $banners[$i]['url'];
            } else {
                $url = "http://".$banners[$i]['url'];
            }
            $bannerCode.="<a id='".$banners[$i]['id']."_".$banners[$i]['type_id']."' href='".$url."' alt='".$alt_text."' target='".$target."' title='".$title."' onClick=updatecount('".$banners[$i]['id']."','".$is_umbrella."','".$banners[$i]['type_id']."') style='width:982px;height:100px; z-index:999;'>";

            if ($banners[$i]['extension']=='swf') {
                $vidPath = BASE_URL."/files/banner/".$banners[$i]['id'].".".$banners[$i]['extension'];

                $bannerCode.= "<object type='application/x-shockwave-flash' data='".$vidPath."' width='982' height='100'>
                                <param name='flashvars' value='clickTag=&clickTarget=_blank' />
                                <param name='allowScriptAccess' value='always' />
                                <param name='movie' value='".$vidPath."' />
                                <param name='bgcolor' value='#fff'>
                                <embed src='".$vidPath."' width='100%' height='100' quality='best' pluginspage='http://www.macromedia.com/go/getflashplayer'>
                               </object>";
                $bannerCode.="</a>";
            } else {
                if ($banners[$i]['extension']) {
                    if ($banners[$i]['type_id'] == '11') { // getting the umbrella type banners.
                        $sFile = $banners[$i]['id'].".".$banners[$i]['extension'];
                        if($sFile && file_exists("files/banner/{$sFile}")){
                            $imgUrl = BASE_URL."/files/banner/".$sFile;
                        } else {
                            $imgUrl = BASE_URL."/files/banner/no-img.jpg";
                        }
                    } elseif($banners[$i]['type_id'] == '15') { // getting the category specific banners.
                        $sFile = $banners[$i]['id'].".".$banners[$i]['extension'];
                        $file_path = "files/category_banners/{$sFile}";
                        if($sFile && file_exists($file_path)){
                            $imgUrl = BASE_URL."/files/category_banners/".$sFile;
                        } else {
                            $imgUrl = BASE_URL."/files/banner/no-img.jpg";
                        }
                    } else {
                        $sFile = $banners[$i]['id'].".".$banners[$i]['extension'];
                        if($sFile && file_exists("files/banner/{$sFile}")){
                            $imgUrl = BASE_URL."/files/banner/".$sFile;
                        } else {
                            $imgUrl = BASE_URL."/files/banner/no-img.jpg";
                        }
                    }

                    $bannerCode.="<img alt='Slideshow' src='".$imgUrl."' width='992' height='120' border='0' />";
                }else{
                    $code = $banners[$i]['code'];
                    $bannerCode .= $code;
                }
            }

            $bannerCode.= " </a>";
            $bannerCode.= " </li>";
        }
    }
} else {
    $bannerCode="";
}

$header->set('bannerCode',$bannerCode);
//End section for the banner

if(!empty($_SESSION['user_id'])){
	$user_frame = getUserFrame();
	$header->set('userFrame',$user_frame);
}

$PMDR->get('Plugins')->run_hook('template_header_end');

function hasBanners($catId){

    global $db;

    $sql_where = " `bc`.`category_id` = '" . $catId . "' ";

    $sql = "SELECT DISTINCT(pb.type_id)
        FROM " . T_BANNERS_CATEGORIES . " bc JOIN " . T_BANNERS . " pb ON bc.banner_id = pb.id
        WHERE pb.hidden=0 AND pb.status IN('Approved','active') AND $sql_where AND pb.hidden=false AND (pb.custom_position = 'top' OR pb.custom_position IS NULL)
        ORDER BY pb.display_order";

    $result = array();

    $banners_top = $db->GetAll($sql);

    foreach($banners_top as $val) {
        $result[] = $val['type_id'];
    }

    return $result;
}
?>
