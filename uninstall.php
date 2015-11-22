<?php
/*
Uninstall script for Widget Manager
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
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