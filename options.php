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
 $data = $_POST;
   $que_array = $data['widgetId'];
   foreach($que_array as $key => $value){
        $widgetId = $value;
    $option = 0;
    if(isset($data['option_' . $widgetId])){
        $option = $data['option_' . $widgetId];
    }

        echo $widgetId . "--" . $option. "<br>";
   } 
?>