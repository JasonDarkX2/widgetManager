<?php
/*
 * Uninstall  script for Wordpress Widget Manager plugin
 * Simply handles uninstalling of plugin
 * For more information check out: http://JasonDarkX2.com/ 
*/
if (
	!defined( 'WP_UNINSTALL_PLUGIN' )
||
	!WP_UNINSTALL_PLUGIN
||
	dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) )
) {
	status_header( 404 );
	exit;
}

delete_option('widgetid');

delete_option('custom-widget');
?>