<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.70
Author URI:http://www.jasondarkx2.com/ 
*/ 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
  $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
chmod($dir,777);
if(file_exists(plugin_dir_path(__FILE__) .'custom-widgets/'.$custwid[$widgetid]['file'])===TRUE){
unlink(plugin_dir_path(__FILE__) .'custom-widgets/'.$custwid[$widgetid]['file']);
}
chmod($dir,755);
unset($custwid[$widgetid]);
unset($widgets[$widgetid]);
update_option('custom-widget', $custwid);
update_option('widgetid', $widgets);
echo "deleted $widgetid";