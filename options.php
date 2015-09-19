<?php
/*
admin options file for Widget Manager
Author:Jason Dark X2
Author URI:http://www.jasondarkx2.com/ 
*/  
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$enabled= get_option('enabled_widgets');
$disabled= get_option('disabled_widgets');
if(empty($disabled)){
    $disabled=array();
}
if(empty($enabled)){
    $enabled=array();
}
$enablecon=0;
 $disabledcon=0;
   $que_array = $_POST['widgetid'];
   If(isset($_POST['quickOp'])){
       switch($_POST['quickOp']){
        case 'enbwid':
            $que_array=  get_option('widgetid');
                  enable_all($que_array, $enabled, $disabled);
            break;
        case 'diswid':
            $que_array=get_option('widgetid');
            disable_all($que_array, $enabled, $disabled);
            break;
        case 'disDefault':
            $que_array=get_option('widgetid');
            $defaultwid= get_defaults($que_array);
            enable_all($que_array, $enabled, $disabled);
            disable_all($defaultwid, $enabled, $disabled);
            break;
        case 'enbDefault':
            $que_array=get_option('widgetid');
            $defaultwid= get_defaults($que_array);
            disable_all($que_array, $enabled, $disabled);
            enable_all($defaultwid, $enabled, $disabled);
            break;
        case 'disCust':
            
            $que_array=  get_option('widgetid');
            $defaultwid= get_defaults($que_array);
           
            disable_all($que_array, $enabled, $disabled);
            enable_all($defaultwid, $enabled, $disabled);
            break;
   }
   }else{
       //var_dump($que_array);
   foreach($que_array as $widgetId){
    $option = 0;
    $data=$_POST;
  if(isset($data[ $widgetId])){
        $option = $data[$widgetId];
        if($option=='enable'){
            $enablecon++;
             if(empty($enabled)){
    $enabled=array($widgetId => TRUE);
}
            else if(array_key_exists($widgetId,$enabled)){
                $enabled[$widgetId]=TRUE;
                if(array_key_exists($widgetId,$disabled)){
                $disabled[$widgetId]=FALSE;
                }
            }else{
            array_push($enabled, $enabled[$widgetId] = TRUE);
            array_pop($enabled);
            }
        }
        else{
            $disabledcon++;
            /*if(count($disabled)==0){
                $disabled=array($widgetId => TRUE);
            }else if(array_key_exists($widgetId,$disabled)){
                $disabled[$widgetId]=TRUE;
                if(array_key_exists($widgetId,$enabled)){
                $enabled[$widgetId]=FALSE;
                }
        }else{
            array_push($disabled, $disabled[$widgetId] = TRUE);
            array_pop($disabled);
    }*/
   } 

    
  }
   }
   }
   echo "$enablecon enabled widgets and $disabledcon disabled widgets";
    update_option('enabled_widgets', $enabled);
    update_option('disabled_widgets', $disabled);
    
    function enable_all($que_array, &$enabled, &$disabled){
                 foreach($que_array as $widgetId){
                $que_array[$widgetId['key']]['status']=TRUE;
        update_option('widgetid', $que_array);
       }
       var_dump($que_array);
    }
     function disable_all($que_array, &$enabled, &$disabled){;
         foreach($que_array as $widgetId){
                $que_array[$widgetId['key']]['status']=false;
        update_option('widgetid', $que_array);
       }
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