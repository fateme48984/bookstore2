<?php
$configDir = $_SERVER['DOCUMENT_ROOT'].'/etc/app/conf';
require_once($configDir.'/admin_conf.php');

$config = $GLOBALS['config'];
$language	= $config->get('site.app_lang');
$lang = strtolower($language);
$langsObj = new Langs();
$direction = $langsObj->getLangDir($language);
if($direction == 'rtl') {
    $textAlign = 'right';
    $antiTextAlign = 'left';
} else {
    $textAlign = 'left';
    $antiTextAlign = 'right';
}
if($language != 'FA') {
    $language = 'EN';
}

require_once($_SERVER['DOCUMENT_ROOT'].'/admin/tinymce/langs/translate.php');



$contentTypes = ['ne' , 'co' , 'ex'];
$modulesCode = array(
    'ne' => [401 , 410 , 412],
    'co' => [700],
    'ex' => [10 ,1300 , 800 , 1600 ,4200 ,7026 ,7021 , 7011 ,5000 ,7024 , 6006 , 7033 , 7002], //only multimedia

);
