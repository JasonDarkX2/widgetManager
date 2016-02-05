<?php
/*
 * debugTools action script for Wordpress Widget Manager plugin
 * Handles the debug section of the plugin providing quick options to easily debug without hard coding them in the back end  
 * For more information check out: http://JasonDarkX2.com/ 
*/
$option=$_GET['op'];
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
if($option=='cw'){
    echo "custom";
 update_option('custom-widget', "");
}
else{
    echo "All";
  update_option('widgetid', "");  
}

