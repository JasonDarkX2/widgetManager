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
$enablecon=0;
 $disabledcon=0;
 $data = $_POST;
   $que_array = $data['widgetId'];
   foreach($que_array as $key => $value){
        $widgetId = $value;
    $option = 0;
    if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
        if($option=='enable'){
             //register_widget($widgetId);
            $enablecon++;
        }
        else{
            //unregister_widget($widgetId);
            $disabledcon++;
        }
    }

        echo $widgetId . "--" . $option. "<br>";
   } 
    echo "$enablecon enabled widgets and $disabledcon disabled widgets";
?>