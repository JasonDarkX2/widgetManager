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
             if(empty($enabled)){
    $enabled=array($widgetId => 1);
}
            else if(array_key_exists($widgetId,$enabled)){
                $enabled[$widgetId]=1;
                if(array_key_exists($widgetId,$disabled)){
                $disabled[$widgetId]=0;
                }
                echo "YUP";
            }else{
            array_push($enabled, $enabled[$widgetId] = 1);
            array_pop($enabled);
            echo "nope";
            }
        }
        else{
            //unregister_widget($widgetId);
            $disabledcon++;
            if(count($disabled)==0){
                $disabled=array($widgetId => 1);
            }else if(array_key_exists($widgetId,$disabled)){
                $disabled[$widgetId]=1;
                if(array_key_exists($widgetId,$enabled)){
                $enabled[$widgetId]=0;
                }
        }else{
            array_push($disabled, $disabled[$widgetId] = 1);
            array_pop($disabled);
    }

        echo $widgetId . "--" . $option. "<br>";
   } 
    echo "$enablecon enabled widgets and $disabledcon disabled widgets";
    update_option('enabled_widgets', $enabled);
    update_option('disabled_widgets', $disabled);
  }
   }
?>