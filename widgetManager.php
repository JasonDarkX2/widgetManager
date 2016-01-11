<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 
?>
<?php
class widget_manager{
    static $add_script;
static function init(){
add_action( 'widgets_init',array(__CLASS__, 'import_cust_widget') );
add_action( 'widgets_init',array(__CLASS__, 'remove_disable_widget') );
add_action( 'init',array(__CLASS__, 'disable_plugin_widget') );
add_action( 'widgets_init',array(__CLASS__, 'load_widgets') );
add_action( 'widgets_init',array(__CLASS__, 'clean_sweep') );
add_action( 'widgets_init','empty_names' );
add_action('admin_menu',array(__CLASS__, 'widget_manager_create_menu'));
add_action('admin_enqueue_scripts',array(__CLASS__,'add_scripts') );
if(get_option('widgetdir')==NULL){
    $defaultDir=dirname(plugin_dir_path(__FILE__)). '/custom-widgets/';
    update_option('widgetdir',$defaultDir);
}
 }
static function add_scripts($hook){

    wp_enqueue_style( 'wm-style', plugins_url('style.css',__FILE__));
    wp_enqueue_style( 'ui-style','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
     wp_enqueue_script( 'ui-script','//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery') );
    wp_enqueue_script( 'wm-script', plugins_url('wm-script.js',__FILE__), array('jquery') );
     $translation_array = array( 'addWidgetUrl' => plugins_url('/actionScripts/addwidget.php',__FILE__));
wp_localize_script( 'wm-script', 'url', $translation_array ); 
          $translation_array = array( 'pluginUrl' => plugins_url('/actionScripts/options.php',__FILE__ ) );
wp_localize_script( 'wm-script', 'pd', $translation_array ); 
}
static function widget_manager_create_menu() {
self::$add_script = true;
	//create new top-level menu
	add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator','widgetM', 
                array(__CLASS__,'Widget_manager_settings_page')
                , plugins_url('/img/WMIconHolder.png', __FILE__) );
add_submenu_page('widgetM', 'Custom Widgets Options', 'Custom Widgets Options', 'administrator','cwop',array(__CLASS__,'customWidget_option_page'));
    add_submenu_page('widgetM', 'Setting', 'Settings', 'administrator','settings',array(__CLASS__,'widgetManager_setting_page')
                );
	//call register settings function
	add_action( 'admin_init',array(__CLASS__,'register_widget_manager_settings'));
}
 static function register_widget_manager_settings() {
	//register our settings
	register_setting( 'WM-setting', 'widgetid' );
        register_setting( 'WM-setting', 'custom-widget' );
        register_setting( 'WM-setting', 'widgetdir' );
}
static function widgetManager_setting_page() {
include(plugin_dir_path( __FILE__ ) . '/pages/settings.php');
}
static function customWidget_option_page() {
include(plugin_dir_path( __FILE__ ) . '/pages/customWidgets.php');
}
static function Widget_manager_settings_page() {
 include(plugin_dir_path( __FILE__ ) . '/pages/Manager.php');
}
function load_widgets(){
    $w=get_option('widgetid');
    if(empty($w)){
        $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );  
        $w=($GLOBALS['wp_widget_factory']->widgets);
  foreach($widgets as $keys){
          if(empty($widgetsId)){
              $type=get_type($keys);
  $widgetsId=array($keys => array('key'=>$keys,'name'=>get_name($keys),'Description'=>get_description($keys),'type'=> $type, 'status'=>TRUE));
  }  else {
      $type=get_type($keys);
      array_push($widgetsId, $widgetsId[$keys]=array('key'=>$keys,'name'=>get_name($keys),'Description'=>get_description($keys), 'type'=>$type,'status'=>TRUE));
      array_pop($widgetsId);
 }
  }
        update_option('widgetid', $widgetsId);
        $widgets=$widgetsId;
        
    }else{  
        $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );  
        $wid=($GLOBALS['wp_widget_factory']->widgets);
$type=get_type($keys);
        array_push($w,$w[$keys]=array('key'=>$keys,'name'=> get_name($keys),'Description'=>get_description($keys), 'type'=>$type,'status'=>TRUE));
        array_pop($w);
        
        update_option('widgetid', $w);
}
    }

function remove_disable_widget() {
	$d=get_option('widgetid');
        if($d!=NULL){
        foreach($d as $widget){
            if($d[$widget['key']]['status']==FALSE){
                if(class_exists($widget['key'])){
            unregister_widget($widget['key']);
                }else{
                    unset($d[$widget['key']]);
                    update_option('widgetid', $d);
                }
            }
            }
        }
        }
        
        function disable_plugin_widget() {
	$d=get_option('widgetid');
        if($d!=NULL){
        foreach($d as $widget){
            if($d[$widget['key']]['status']==FALSE && $widget['type']=='Plugin'){
                if(class_exists($widget['key'])){
                    //echo $widget['key'];
                    $wid=($GLOBALS['wp_widget_factory']->widgets);
                    //var_dump($wid);
            unregister_widget($widget['key']);
                }else{
                    unset($d[$widget['key']]);
                    update_option('widgetid', $d);
                }
            }
            }
        }
        }
                function import_cust_widget() {
                    $dir=get_option('widgetdir');
                    $w=get_option('widgetid');
                    $cust=get_option('custom-widget');
                   $custwid=getCustomWidgets($dir);
                   if($custwid!=null){
                   foreach($custwid as $wid){
                       if($cust[getWidgetClass($wid)]['status']==true){
                       if(empty($cust)|| array_key_exists($wid, $cust)==FALSE){
                           if(file_exists($dir. '/'.$wid)){
                       include($dir. '/'.$wid);
                       register_widget(getWidgetClass($wid));
                           }
                       }
                       }else{
                           unregister_widget(getWidgetClass($wid));
                       }
                   }
                }
                    if(empty($cust)==TRUE){
                        if($custwid!=null){
                   foreach($custwid as $wid){
                 if(empty($cust)==TRUE && getWidgetClass($wid)!=''){
                      $cust[getWidgetClass($wid)]=array('key'=>getWidgetClass($wid),'class'=> getWidgetClass($wid),'name'=> get_name(getWidgetClass($wid)),'file'=> $wid,'status' => true);
                 }else{
                     if(array_key_exists(getWidgetClass($wid),$cust)==FALSE){
                array_push($cust, $cust[getWidgetClass($wid)]=array('key'=>getWidgetClass($wid),'class'=> getWidgetClass($wid),'name'=> get_name(getWidgetClass($wid)),'file'=> $wid,'status' => true));
                 array_pop($cust);
                     }
                 }
                   }
                        }
                    }
                    if($cust!=''){
                   foreach($cust as $c){
                        if($cust['status']==true){
                           if(array_key_exists($c['class'],$w)==FALSE){
              $newcust[$c['class']]=array('key'=>$c['class'],'class'=>$c['class'],'name'=> $c['name'],'type'=> 'Custom','status' => true);
               array_push($w, $newcust);
                           }
                       }else{
                           if(empty($w)==FALSE&& class_exists($c['key'])){
                           unset($c['key']);
                           }
                       }
                   }
                update_option('custom-widget',$cust);
                update_option('widgetid', $w);
                    }
        }
function clean_sweep(){
   $d=get_option('widgetid');
     foreach($d as $widget){
          if(class_exists($widget['key'])==FALSE){
               unset($d[$widget['key']]);
                    update_option('widgetid', $d);
          }
     }
}
}

function getCustomWidgets($dir){
    $customwidgets=array();
    if(file_exists($dir)){
 $cdir=scandir($dir);
    }else{
        return;
    }

 foreach($cdir as $d){
     if($d == "." || $d == ".."  || $d == ".svn"){
			continue;
     }
     if(is_dir(plugin_dir_path( __FILE__ ) . 'custom-widgets'. '/'.$d)==TRUE){
         $dirFile=scandir(plugin_dir_path( __FILE__ ) . 'custom-widgets'. '/'.$d);
         foreach($dirFile as $dir){
             $info = new SplFileInfo($dir);
             if(is_dir($dir)==FALSE && $info->getExtension()=='php'){
                 $file=$d . '/' . $dir;
             }
         }
         array_pop($customwidgets);
         array_push($customwidgets, $file);
     }
     else{
         if(is_dir($d)==FALSE){
         array_push($customwidgets, $d);
         }
     }
 }
                   return $customwidgets;
}
function getWidgetClass($file){
     $dir=get_option('widgetdir');
     if($file !=""){
        if(file_exists ($dir. '/'.$file))
     $file=file_get_contents($dir. '/'.$file );
     $t=token_get_all($file);
     $class_token = false;
foreach ($t as $token) {
  if (is_array($token)) {
    if ($token[0] == T_CLASS) {
       $class_token = true;
    } else if ($class_token && $token[0] == T_STRING) {
        $widget_class=$token[1];
       $class_token = false;
    }
  }
  
}
}
                   return $widget_class ;
}
function get_type($keys){
    $c=get_option('custom-widget');
    if($c==null){
        $c=get_option('widgetid');
    }
    if(preg_match("/WP_(Widget|Nav)/", $keys)){
    $type="Default";
}else if(array_key_exists($keys,$c)==FALSE){
    $type="Plugin";
}else{
    $type="Custom";
}
return $type;
}
function get_name($key){
    $wid=($GLOBALS['wp_widget_factory']->widgets);
     $name=$wid[$key]->name;
     return  $name;
}
function get_description($key){
    $wid=($GLOBALS['wp_widget_factory']->widgets);
 return $wid[$key]->widget_options['description'];
}
        function empty_names(){
              $cust=get_option('custom-widget');
              if($cust!=NULL)
              foreach($cust as $wid){
                  if(get_name($wid['class'])!=NULL)
                 $cust[$wid['key']]['name']=get_name($wid['class']);
              }
              
              update_option('custom-widget', $cust);
        }
 function autoDetect(){
      $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );  
       $w=get_option('widgetid');
       $shown=false;
     foreach($widgets as $keys){
      if(array_key_exists($keys,$w)==FALSE){
    if(get_type($keys)!='Default' ){
        $type=get_type($keys);
        array_push($w,$w[$keys]=array('key'=>$keys,'name'=> get_name($keys),'Description'=>get_description($keys), 'type'=>$type,'status'=>TRUE));
        array_pop($w);
                 if($shown!=TRUE){
             echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
             $shown=true;
         }
        echo '<li>'. get_name($keys) .'</li>';
        update_option('widgetid', $w);
    }
      }
     }
     echo'</ul></div>';
 }
widget_manager::init();
?>