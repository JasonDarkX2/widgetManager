<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
        echo $widgetId.'->'.$option;
        if($option=='true'){
            $custwid[$widgetId]['status']=TRUE;
            echo  $custwid[$widgetId]['status'];
        }else{
             $custwid[$widgetId]['status']=FALSE;
        }
  }
 }
           var_dump($custwid);
        update_option('custom-widget', $custwid);