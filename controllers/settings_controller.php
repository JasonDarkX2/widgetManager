<?php

/* 
 * setting controller manages options requests for widget manager  
 */
require_once dirname(dirname(__FILE__)) . '/model/settings.php';
$settingObj= new WmSettings();
$w = $_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$dir = $_POST['dir'];

if(isset($_POST['preset'])){
    $settingObj->setPresetOptions($_POST['preset']);
}
    $settingObj->changeWidgetDir($dir);


