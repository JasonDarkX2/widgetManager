<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 

$option=$_GET['op'];

if($option=='cw'){
    echo "custom";
 //update_option('custom-widget', "");
}
else{
    echo "All";
  //update_option('widgetid', "");  
}

