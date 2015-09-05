<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.1
Author URI:http://www.jasondarkx2.com/ 
*/ 
?>

<?php

class Test_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
  'tdm-testwidget1',
        // Widget name will appear in UI
__('Test Widget #1', 'WM_widget_domain'),
        // Widget description
array( 'description' => __( 'Test Widget for Widget manager', 'WM_widget_domain' ), ) 
);
}
// Creating widget front-end
public function widget( $args, $instance ) {

    
}
// Widget Backend 
public function form( $instance ) {
    
}
// updating widget instances
public function update( $new_instance, $old_instance ) {
    
}
}
function test_widget() {
	register_widget( 'test_widget' );
}
add_action( 'widgets_init', 'test_widget' );
?>