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
 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
if(isset($_POST['widgetid'])){
    $array=$_POST['widgetid'];
    update_option('widgetid', $array );
    
}
$enabled= get_option('enabled_widgets');
$disabled= get_option('disabled_widgets');
if($enabled==""){
    $enabled=array();
}
if($disabled==""){
    $disabled=array();
}
$enablecon=0;
 $disabledcon=0;
 $data = $_POST;
   $que_array = $data['widgetid'];
   foreach($que_array as $key => $value){
        $widgetId = $value;
    $option = 0;
    if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
        if($option=='enable'){
             //register_widget($widgetId);
            $enablecon++;
            array_push($enabled, $widgetId);
        }
        else{
            //unregister_widget($widgetId);
            $disabledcon++;
            array_push($disabled, $widgetId);
        }
    }

        echo $widgetId . "--" . $option. "<br>";
   } 
    echo "$enablecon enabled widgets and $disabledcon disabled widgets";
    update_option('enabled_widgets', $enabled);
    update_option('disabled_widgets', $disabled);
?>