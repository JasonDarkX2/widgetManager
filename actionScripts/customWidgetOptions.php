<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
  $custwid= get_option('custom-widget');
 $que_array = $_POST['customWidget'];
 foreach($que_array as $widgetId){
    $option = 0;
    $data=$_POST;
  if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
        if($option=='true'){
            $custwid[$widgetId]['status']=TRUE;
             $wList=get_option('widgetid');
            if(array_key_exists( $custwid[$widgetId]['class'],$wList)==FALSE){
                      array_push($wList, $wList[$widgetId]=array('key'=>$wid,'class'=>$custwid[$widgetId]['name'],'name'=> get_name($custwid[$widgetId]['class']),'Description'=>get_description($custwid[$widgetId]['class']), 'type'=>'Custom','status' => true));
                      array_pop($wList);
                      update_option('widgetid', $wList);
                 }
            echo  $custwid[$widgetId]['name'] . ' registered and enabled<br/>';
        }else{
             $custwid[$widgetId]['status']=FALSE;
              echo  $custwid[$widgetId]['name'] . ' unregistered<br/>';
        }
  }
 }
        update_option('custom-widget', $custwid);