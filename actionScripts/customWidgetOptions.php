<?php
/*
 * customWidgetOption action script for Wordpress Widget Manager  plugin
 * Handles the custom widgets options
 * For more information check out: http://JasonDarkX2.com/ 
*/ 
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
  $custwid= get_option('custom-widget');
 $que_array = $_POST['customWidget'];
 foreach($que_array as $widgetId){
    $option = 0;
    $data=$_POST;
  if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
         $wList=get_option('widgetid');
        if($option=='true'){
            $custwid[$widgetId]['status']=TRUE;
            if(array_key_exists( $custwid[$widgetId]['class'],$wList)==FALSE){
                      array_push($wList, $wList[$widgetId]=array('key'=>$custwid[$widgetId]['class'],'class'=>$custwid[$widgetId]['name'],'name'=>$custwid[$widgetId]['name'],'Description'=>get_description($custwid[$widgetId]['class']), 'type'=>'Custom','status' => true));
                      array_pop($wList);
                      update_option('widgetid', $wList);
                 }
            echo '<div class="notfi">'. $custwid[$widgetId]['name'] . ' registered and enabled</div>';
        }else{
             $custwid[$widgetId]['status']=FALSE;
             unset($wList[$widgetid]);
             update_option('widgetid', $wList);
              echo '<div class="notfi">'.   $custwid[$widgetId]['name'] . ' unregistered</div>';
        }
  }
 }
        update_option('custom-widget', $custwid);