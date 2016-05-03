<?php
/*
 * options action script for Wordpress Widget Manager plugin
 * Handles the adminstrative options for widgets, the enabling and disabling widdgets. Pretty much butter of the plugin :P  
 * For more information check out: http://JasonDarkX2.com/ 
*/
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
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
            disable_types($que_array,"Default",$enablecon,$disabledcon);
            break;
        case 'enbDefault':
            $que_array=get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"Custom",$enablecon,$disabledcon);
             disable_types($que_array,"Plugin",$enablecon,$disabledcon);
            break;
        case 'disCust':
            $que_array=  get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"Custom",$enablecon,$disabledcon);
            break;
                   case 'enbPlugin':
            $que_array=  get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"Default",$enablecon,$disabledcon);
            disable_types($que_array,"Custom",$enablecon,$disabledcon);
            
            break;
                   case 'disPlugin':
            $que_array=  get_option('widgetid');
            enable_all($que_array,$enablecon);
            disable_types($que_array,"Plugin",$enablecon,$disabledcon);
        default:
            status_count($enablecon,$disabledcon);
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
   if(get_option('preset-ndw')){
       if($enablecon>0){
         $enablecon=$enablecon-get_count("Default"); 
       }
       if($disabledcon>0){
         $disabledcon=$disabledcon-get_count("Default"); 
       }
   }
    if(get_option('preset-pwm')==FALSE){
if($enablecon>0){
         $enablecon=$enablecon-get_count("Plugin"); 
       }
       if($disabledcon>0){
         $disabledcon=$disabledcon-get_count("Plugin"); 
   }
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
     function get_count($type){
         $w=get_option('widgetid');
         $count=0;
        foreach($w as $wid){
         if(strtolower($wid['type'])==strtolower($type)){
          $count++;
         }
        }
         return $count;
     }
    function status_count(&$enablecon,&$disabledcon){
         $w=get_option('widgetid');
         foreach($w as $wid){
         if($wid['status']==FALSE){
             $disabledcon++;
         }else{
             $enablecon++;
         }
    }
    }
?>