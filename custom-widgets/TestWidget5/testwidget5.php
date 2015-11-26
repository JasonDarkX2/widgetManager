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

class Test_widget5 extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
  'tdm-testwidget5',
        // Widget name will appear in UI
__('Test Widget #5', 'WM_widget_domain'),
        // Widget description
array( 'description' => __( 'Test Widget for Widget manager', 'WM_widget_domain' ), ) 
);
}
// Creating widget front-end
public function widget( $args, $instance ) {
$title="This is the Test Widget";
    echo $args['before_widget'];
    echo $args['before_title'] . $title . $args['after_title'];
    echo "<h1>HELLO Widget Manager!!</h1>";
    echo $args['after_widget'];
}
// Widget Backend 
public function form( $instance ) {
    
}
// updating widget instances
public function update( $new_instance, $old_instance ) {
    
}
}
function Test_widget5() {
	register_widget( 'Test_widget5' );
}
add_action( 'widgets_init', 'Test_widget5' );
?>