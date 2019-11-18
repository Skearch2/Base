<?php
$homepage_cat =  $db->GetAll("SELECT id, title, home_display, friendly_url_path, description_short, description, `orderby` FROM ".T_CATEGORIES." WHERE `orderby` != 0 ORDER BY `orderby` ASC LIMIT 0,15");
$homepage_category = array();

for($i = 0 ; $i <= 15; $i++) {
    for($j = 0 ; $j <= count($homepage_cat); $j++) {
        if($homepage_cat[$j]['orderby'] == $i) {
            $homepage_category[$i] = array('title'=>$homepage_cat[$j]['title'],'id'=>$homepage_cat[$j]['id'],'home_display'=>$homepage_cat[$j]['home_display'],'friendly_url_path'=>$homepage_cat[$j]['friendly_url_path']);
            break;
        } else {
            $homepage_category[$i] = $i;
        }
    }
}
#echo "<pre>"; print_r($homepage_category);echo "</pre>";
?>
