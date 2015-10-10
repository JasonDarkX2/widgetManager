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
class widget_manager{
    static $add_script;
static function init(){
add_action( 'widgets_init',array(__CLASS__, 'import_cust_widget') );
add_action( 'widgets_init',array(__CLASS__, 'remove_disable_widget') );
add_action( 'widgets_init',array(__CLASS__, 'clean_sweep') );
add_action('admin_menu',array(__CLASS__, 'widget_manager_create_menu'));
add_action('admin_enqueue_scripts',array(__CLASS__,'add_scripts') );
}
static function add_scripts($hook){
 if ( basename($_GET['page']) != "widgetManager.php" ) {
        return;
    }
    wp_enqueue_script( 'wm-script', plugins_url('wm-script.js',__FILE__), array('jquery') );
          $translation_array = array( 'pluginUrl' => plugins_url('option.php',__FILE__ ) );
wp_localize_script( 'wm-script', 'pd', $translation_array ); 
}
static function widget_manager_create_menu() {
self::$add_script = true;
	//create new top-level menu
	add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator',__FILE__, 
                array(__CLASS__,'Widget_manager_settings_page')
                , plugins_url('/img/WMIconHolder.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init',array(__CLASS__,'register_widget_manager_settings'));
}
 static function register_widget_manager_settings() {
	//register our settings
	register_setting( 'WM-setting', 'widgetid' );
}
static function Widget_manager_settings_page() { ?>
    <h1> Widget Manager</h1>
 <form id="widmanager" method="post" action="<?php echo plugins_url('options.php', __FILE__); ?>">
    <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
    <table border='1px' >
        <tr><th> Widgets</th><th>Type</th><th> Enabled</th><th>Disabled</th></tr>
    <?php  
    
        $defaultWidgets=array();
        $customWidgets=Array();
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
      echo'<label><h1>Notifications:</h1></label>';
    echo '<p id="msg"></p>';
  foreach($widgets as $keys){
if(array_key_exists($keys,$w)==FALSE){
    echo '<br/><strong>*recently added widgets*-></strong>'. get_name($keys);
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
    <!---<form action="upload.php" method="post" enctype="multipart/form-data">
    Upload a custom Widget
    <input type="file" name="widgetToUpload" id="widgetToUpload">
    <input type="submit" value="Upload" name="submit">
</form>!--->
    <?php 
    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
    $custwid=getCustomWidgets($dir);?>
    <table border="1px;"><tr><th>Custom Widgets</th><th>filename</th><th>Register Custom Widget</th><th>UnRegister Custom Widget</th></tr>
        <form method="POST" action="#">
    <?php 
    foreach($custwid as $c):?>
    <tr>
        <td><?php echo getWidgetClass($c);?></td><td><?php echo $c; ?></td>
        <td><input type="radio" name="<?php echo $c?>" <?php checked('',$custwidget['status'] ); ?> value="unregister"></td>
        <td><input type="radio" name="<?php echo $c?>" <?php checked('',$custwidget['status'] ); ?> value="unregister"></td>
    </tr>
    <?php endforeach;
    echo "</table>";
    submit_button('save custom widget');
    echo "</form>";
$s=get_option('widgetid');
echo '<div id="debug" hidden="true">';
echo "<b>DEBUG Section:</b>";
var_dump($s);
echo "<h1>widgets</h1>";
var_dump( $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets ));
echo '</div>';
//update_option('widgetid', "");
   ?>

    
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
        function remove_cust_widget() {
	$d=get_option('widgetid');

        if(class_exists($d['Jetpack_Contact_Info_Widget']['key'])){
        unregister_widget('Jetpack_Contact_Info_Widget');
        }else{
        }
            //unregister_widget('Jetpack_Contact_Info_Widget');
                }
                function import_cust_widget() {
                    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
                    $customwidgets=getCustomWidgets($dir);
                   header('Content-Type: text/plain');
                   $file=file_get_contents($dir. '/'.$customwidgets[0]);
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

                   //var_dump($token);
	include($dir. '/'.$customwidgets[0]);
                register_widget($widget_class);
                $w=get_option('widgetid');
                if(array_key_exists($widget_class,$w)==TRUE){
                 $w[$widget_class]['type']='Custom';
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
 $customwidgets=scandir($dir);
                   rsort($customwidgets);
                   array_pop($customwidgets);
                   array_pop($customwidgets);
                   array_pop($customwidgets);
                   return $customwidgets;
}
function getWidgetClass($file){
     $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
     $file=file_get_contents($dir. '/'.$file);
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
                   return $widget_class ;
}
function get_type($keys){
    if(preg_match("/WP_(Widget|Nav)/", $keys)){
    $type="Default";
}else{
    $type="Plugin";
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



widget_manager::init();
?>