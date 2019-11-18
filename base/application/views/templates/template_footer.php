<?php

// Load the footer file.  If a custom footer file is set, load it, if not load the default footer.tpl file
if($PMDR->get('footer_file') AND $PMDR->get('Templates')->path($PMDR->get('footer_file'))) {
    $footer = $PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.$PMDR->get('footer_file'));
} else {
    $footer = $PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.'footer.tpl');
}

// Load the footer options which includes the language and template drop downs
include(PMDROOT.'/includes/template_options.php');
$options = $PMDR->getNew('Template',PMDROOT.TEMPLATE_PATH.'blocks/options.tpl');
if(count($languages_array) > 1) {
    $options->set('languages_array',$languages_array);
}
if(count($templates_array) > 1) {
    $options->set('templates_array',$templates_array);
}
$options->set('current_language',$PMDR->getConfig('language'));
$options->set('current_template',$PMDR->getConfig('template'));

//	var_dump( get_class_vars($footer));

			//														$footer->set('options',$options);
$footer->set('disable_cron',$PMDR->getConfig('disable_cron'));
$footer->set('pmd_version',$PMDR->getConfig('pmd_version'));





$PMDR->get('Plugins')->run_hook('template_footer_end');

unset($languages_array,$templates_array,$options);
?>
