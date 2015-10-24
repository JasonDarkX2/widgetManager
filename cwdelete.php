<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
  $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
chmod($dir,777);
unlink(plugin_dir_path(__FILE__) .'custom-widgets/'.$custwid[$widgetid]['file']);
chmod($dir,755);
unset($custwid[$widgetid]);
unset($widgets[$widgetid]);
update_option('custom-widget', $custwid);
update_option('widgetid', $widgets);
echo "deleted $widgetid";