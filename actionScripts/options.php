<?php
/*
admin options file for Widget Manager
Author:Jason Dark X2
Author URI:http://www.jasondarkx2.com/ 
*/  
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$enablecon=0;
 $disabledcon=0;
  $que_array = $_POST['widgetid'];
   If(isset($_POST['quickOp'])){
       switch($_POST['quickOp']){
        case 'enbwid':
            $que_array=get_option('widgetid');
                  enable_all($que_array,$enablecon, $disabledcon);
            break;
        case 'diswid':
            $que_array=get_option('widgetid');
            disable_all($que_array,$disabledcon);
            break;
        case 'disDefault':
            $que_array=get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"default",$enablecon,$disabledcon);
            break;
        case 'enbDefault':
            $que_array=get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"custom",$enablecon,$disabledcon);
            break;
        case 'disCust':
            $que_array=  get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"Custom",$enablecon,$disabledcon);
            break;
   }
   }else{

       $wid=get_option('widgetid');
       if($que_array==NULL){
           return;
       }
   foreach($que_array as $widgetId){
    $option = 0;
    $data=$_POST;
  if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
        if($option=='enable'){
            $enablecon++;
            $wid[$widgetId]['status']=TRUE;
        }
        else{
            $disabledcon++;
             $wid[$widgetId]['status']=FALSE;
            
    }
   } 

    
  }
   update_option('widgetid', $wid);
   }
   echo '<div class="notfi">' . $enablecon . ' enabled widgets and ' . $disabledcon . ' disabled widgets'. '</div>' ;
    function enable_all($que_array, &$enablecon){
                 foreach($que_array as $widgetId){
                $que_array[$widgetId['key']]['status']=TRUE;
                $enablecon++;
        update_option('widgetid', $que_array);
       }
    }
     function disable_all($que_array,&$disabledcon){
         foreach($que_array as $widgetId){
                $que_array[$widgetId['key']]['status']=false;
                $disabledcon++;
        update_option('widgetid', $que_array);
       }
     }
     function disable_types($w,$type,&$enablecon,&$disabledcon){
         foreach($w as $wid){
         if(strtolower($wid['type'])==strtolower($type)){
             $w[$wid['key']]['status']=FALSE;
             $disabledcon++;
             $enablecon--;
         }else{
             $w[$wid['key']]['status']=TRUE;
         }
     }
     update_option('widgetid',$w);
     }
     function get_defaults($w){
        $d=array();
         array_pop($d);
        foreach($w as $wid){
         if($wid['type']==="default"){
          array_push($d, $wid);
         }
        }
         return $d;
     }
    
?>