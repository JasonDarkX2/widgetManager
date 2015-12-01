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
add_action( 'widgets_init',array(__CLASS__, 'clean_sweep') );
add_action( 'widgets_init','empty_names' );
add_action('admin_menu',array(__CLASS__, 'widget_manager_create_menu'));
add_action('admin_enqueue_scripts',array(__CLASS__,'add_scripts') );
}
static function add_scripts($hook){
 /*if ( basename($_GET['page']) != "widgetManager.php" ) {
        return;
    }*/
    wp_enqueue_style( 'wm-style', plugins_url('style.css',__FILE__));
    wp_enqueue_style( 'ui-style','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
     wp_enqueue_script( 'ui-script','//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery') );
    wp_enqueue_script( 'wm-script', plugins_url('wm-script.js',__FILE__), array('jquery') );
     $translation_array = array( 'addWidgetUrl' => plugins_url('/actionScripts/addwidget.php',__FILE__));
wp_localize_script( 'wm-script', 'url', $translation_array ); 
          $translation_array = array( 'pluginUrl' => plugins_url('option.php',__FILE__ ) );
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
}
static function widgetManager_setting_page() {
include('/pages/settings.php');
}
static function customWidget_option_page() {
include('/pages/customWidgets.php');
}
static function Widget_manager_settings_page() { ?>
<form>
<div id="dialog" hidden="true">
  <p>Add or Import your Custom widgets below.... </p>
  <form id="addWidget" method="POST" action="addwidget.php"enctype= "multipart/form-data">
  <input type="file" name="widgetToUpload" id="widgetToUpload" accept=".php,.zip">

</form>
</div>
</form>
    <h1> Widget Manager</h1>
 <form id="widmanager" method="post" action="<?php echo plugins_url('actionScripts/options.php', __FILE__); ?>">
    <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
    <table border='1px' >
        <tr><th> Widgets</th><th>Type</th><th> Enabled</th><th>Disabled</th></tr>
    <?php  
    
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
      echo'<h1>Notifications:</h1>';
    echo '<p id="msg"></p>';
  foreach($widgets as $keys){
if(array_key_exists($keys,$w)==FALSE){
    if(get_type($keys)!='Default' ){
    echo '<br/><strong>*recently added widgets*-></strong>'. get_name($keys);
    }
$type=get_type($keys);
        array_push($w,$w[$keys]=array('key'=>$keys,'name'=> get_name($keys),'Description'=>get_description($keys), 'type'=>$type,'status'=>TRUE));
        array_pop($w);
        
        update_option('widgetid', $w);
}

      }
    
  $widgets=$w; 
    }
    foreach($widgets as $widget):?>
        <input type='hidden' name='count' value='$num' id='count'>
 <?php
?>
        <tr>
            <td><input type='hidden' name='widgetid[]' value='<?php echo  $widget['key'] ?>' id='widgetId'> 
                <?php echo $widget['name']; ?></td>
            <td><?php echo $widget['type']; ?></td>
            <td><input type="radio" name="<?php echo $widget['key']; ?>" value="enable" <?php  checked(1,$widget['status']); ?> ><?php //echo get_option($widget['key']);?></td>
            <td><input type="radio" name="<?php echo $widget['key'];?>" <?php checked('',$widget['status'] ); ?> value="disable"></td>
        </tr>
    <?php endforeach;?>
        <tr>
        <tr>
            <td><strong>Quick Options</strong></td>
            <td colspan="3">
                <b>|Enable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="enbDefault">
                <b>|Disable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="disDefault">
                <b>|Disable all custom widgets:</b><input type="radio" name="quickOp" value="disCust">
                <b>|Enable all Widgets:</b> <input type="radio" name="quickOp" value="enbwid">
                 <b>|Disable all Widgets:</b> <input type="radio" name="quickOp" value="diswid">
            </td>
        </tr>
    </table>
     <?php submit_button(); ?>
    </form>
    <?php 
    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
    empty_names();
    $custwid= get_option('custom-widget')?>
    <h2><strong>Custom Widgets Option</strong></h2>
    <table border="1px;"><tr><th>Custom Widgets</th><th>filename</th><th>Register Custom Widget</th><th>UnRegister Custom Widget</th><th>Extra options</th></tr>
        <form id="customswid" method="POST" action="<?php echo plugins_url('customWidgetOptions.php', __FILE__); ?>">
    <?php 
    if(empty($custwid)==FALSE)
    foreach($custwid as $c):?>
    <tr>
        <?php if(getWidgetClass($c['file'])!=''):?>
        <td><?php echo $c['name'];?></td><td><?php echo $c['file']; ?></td>
        <td>
            <input type='hidden' name='customWidget[]' value='<?php echo  $c['key'] ?>' id='customWidget'> 
            <input type="radio" name="<?php echo$c['key'];?>" <?php checked(1,$c['status'] ); ?> value="true"></td>
        <td><input type="radio" name="<?php echo $c['key'];?>" <?php checked('',$c['status'] ); ?> value="false"></td>
        <td><a class="deleteWid" href="<?php echo plugins_url('cwdelete.php',__FILE__); ?>?w=<?php echo$c['key']; ?>" title="delete <?php echo$c['name']; ?>">Delete Widget</a></td>
      <?php endif;?>
    </tr>
    <?php endforeach;?>
    <tr><td colspan="5"><a href="#"> Get more Custom Widgets</a>|<a href="#" id="addWidget"> Add/import new Custom Widgets</a></td></tr>
    </table>
    <?php submit_button('save custom widget');?>
    </form> 
<?php }


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
                function import_cust_widget() {
                    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
                    $w=get_option('widgetid');
                    $cust=get_option('custom-widget');
                   $custwid=getCustomWidgets($dir);
                   if($custwid!=null){
                   foreach($custwid as $wid){
                       if($cust[getWidgetClass($wid)]['status']==true){
                       if(empty($cust)|| array_key_exists($wid, $cust)==FALSE){
                       include($dir. '/'.$wid);
                       register_widget(getWidgetClass($wid));
                       }
                       }else{
                           unregister_widget(getWidgetClass($wid));
                       }
                   }
                }
                    if(empty($cust)==TRUE){
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
 $cdir=scandir($dir);

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
     $dir=plugin_dir_path( __FILE__ ).'custom-widgets';
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
              foreach($cust as $wid){
                  if(get_name($wid['class'])!=NULL)
                 $cust[$wid['key']]['name']=get_name($wid['class']);
              }
              
              update_option('custom-widget', $cust);
        }
widget_manager::init();
?>