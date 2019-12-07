<?php
if(!defined('IN_PMD')) exit();

$bottom_banners = $db->GetAll("SELECT pb.* FROM pmd_banners_bottom pb WHERE pb.hidden=0 AND pb.type_id IN (14) AND pb.status != 'Delete' ORDER BY pb.display_order ASC");
$is_umbrella = $PMDR->get('is_umbrella');
//echo "<pre>";print_r($bottom_banners);exit;

if(count($bottom_banners)>0){
    for($i=0;$i<count($bottom_banners);$i++) {
        //echo $bottom_banners[$i]['type_id'];
        //echo "<br>";
        //$bannerCode_bottom.="<div id='".$bottom_banners[$i]['id']."'>";
        $bannerCode_bottom.="<div id='".$bottom_banners[$i]['id']."_".$bottom_banners[$i]['display_time']."_".$bottom_banners[$i]['type_id']."' style='position:absolute;'>";
        $target = $bottom_banners[$i]['target'];
        $title = $bottom_banners[$i]['title'];
        $url = $bottom_banners[$i]['url'];
        $alt_text = $bottom_banners[$i]['alt_text'];
        $url = $bottom_banners[$i]['url'];
        if($bottom_banners[$i]['extension']=='swf'){
				$vidPath = BASE_URL."/files/banner_bottom/".$bottom_banners[$i]['id'].".".$bottom_banners[$i]['extension'];
				$bannerCode_bottom.="<a id='".$bottom_banners[$i]['id']."_".$bottom_banners[$i]['type_id']."' href='".$url."' alt='".$alt_text."' target='".$target."' title='".$title."' onClick=updatebottomcount('".$bottom_banners[$i]['id']."','".$is_umbrella."','".$bottom_banners[$i]['type_id']."')>";
				$bannerCode_bottom.= "<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH='620' HEIGHT='260' id='Yourfilename' ALIGN=''>";
				$bannerCode_bottom.= "<PARAM NAME=movie VALUE='".$vidPath."'><PARAM NAME=quality VALUE=high><PARAM NAME=bgcolor VALUE=#000> <PARAM NAME='wmode' VALUE='opaque'> <EMBED src='".$vidPath."' quality=high bgcolor=#FFFFFF WIDTH='620' HEIGHT='260' NAME='Yourfilename' ALIGN='' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED> </OBJECT>";
				$bannerCode_bottom.="</a>";
        } else {
			if($bottom_banners[$i]['extension']){
				$bannerCode_bottom.="<a id='".$bottom_banners[$i]['id']."_".$bottom_banners[$i]['type_id']."' href='http://".$url."' alt='".$alt_text."' target='".$target."' title='".$title."' onClick=updatebottomcount('".$bottom_banners[$i]['id']."','".$bottom_banners[$i]['type_id']."')>";
				$imgUrl = BASE_URL."/files/banner_bottom/".$bottom_banners[$i]['id'].".".$bottom_banners[$i]['extension'];
				$bannerCode_bottom.="<img alt='Slideshow' src='".$imgUrl."' border='0' />";
				$bannerCode_bottom.="</a>";
			}else{
				$code = $bottom_banners[$i]['code'];
				$bannerCode_bottom.= $code;
			}
		}
       	$bannerCode_bottom.= " </div>";
    }
} else {
       $bannerCode_bottom="";
}
//echo $bannerCode_bottom;exit;
?>
