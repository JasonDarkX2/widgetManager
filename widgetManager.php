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

function remove_disable_widget() {
	$d=get_option('widgetid');
        $dis=get_option('disabled_widgets');
        $e=get_option('enabled_widgets');
        foreach($d as $widget){
            if($dis[$widget]==TRUE){
            unregister_widget($widget);
            }else{ 
            register_widget($widget);
            }
            }
        }
//add_action('init' ,init());
add_action( 'widgets_init', 'remove_disable_widget' );


add_action('admin_menu', 'widget_manager_create_menu');



function widget_manager_create_menu() {

	//create new top-level menu
	add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator', __FILE__, 
                'my_cool_plugin_settings_page' 
                , plugins_url('/img/WMIconHolder.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_widget_manager_settings' );
}


function register_widget_manager_settings() {
	//register our settings
	register_setting( 'WM-setting', 'widgetid' );
	register_setting( 'WM-setting', 'enabled_widgets' );
	register_setting( 'WM-setting', 'disabled_widgets' );
        register_setting( 'WM-setting', 'defaults' );
}

function my_cool_plugin_settings_page() {?>


    <h1> Widget Manager</h1>
 <form method="post" action="<?php echo plugins_url('options.php', __FILE__); ?>">
    <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
    <table border='1px' >
        <tr><th><input type="checkbox" name="select all" onclick="selectall()"></th><th> Widgets</th><th> Enabled</th><th>Disabled</th></tr>
    <?php  
    
        $defaultWidgets=array();
        $customWidgets=Array();
    $w=get_option('widgetid');
    if(empty($w)){
        
        $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
        update_option('widgetid', $widgets);
    }else{
  $widgets=$w;
    }
    foreach($widgets as $widget):?>
        <input type='hidden' name='count' value='$num' id='count'>
        
<?php if(preg_match("/WP_(Widget|Nav)/", $widget)){
    $type="<strong>(default)</strong>";
    array_push($defaultWidgets, $widget);
}else{
    $type="<strong>(custom)</strong>";
    array_push($customWidgets, $widget);
}
update_option('defaults', $defaultWidgets);
$e=get_option('enabled_widgets');
$d=get_option('disabled_widgets');
?>
        <tr>
            <td><input type="checkbox" name="<?php echo $widget ?>" value="<?php echo $widget; ?>"></td>
            <td><input type='hidden' name='widgetid[]' value='<?php echo  $widget ?>' id='widgetId'> 
                <?php echo $widget . $type; ?></td>
            <td><input type="radio" name="<?php echo $widget; ?>" value="enable" <?php if( !empty($e) ){ checked( 1,$e[$widget] ); } ?> ><?php echo get_option($widget);?></td>
            <td><input type="radio" name="<?php echo $widget;?>" <?php if(!empty($d)){checked(1,$d[$widget] );} ?> value="disable"></td>
        </tr>
    <?php endforeach;?>
        <tr>
        <tr>
            <td><strong>Quick Options</strong></td>
            <td colspan="3">
                <b>Enable Defaults Only:</b><input type="radio" name="quickOp" value="enbDefault">
                <b>|Disable Defaults Only:</b><input type="radio" name="quickOp" value="disDefault">
                <b>|Disable all custom widgets:</b><input type="radio" name="quickOp" value="disCust">
                <b>|Enable all Widgets:</b> <input type="radio" name="quickOp" value="enbwid">
                 <b>|Disable all Widgets:</b> <input type="radio" name="quickOp" value="diswid">
            </td>
        </tr>
    </table>
     <?php submit_button(); ?>
    </form>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    Upload a custom Widget
    <input type="file" name="widgetToUpload" id="widgetToUpload">
    <input type="submit" value="Upload" name="submit">
</form>
    <?php echo "<b>DEBUG Section:</b>";
$s=get_option('widgetid');
var_dump($s);
$e=get_option('enabled_widgets');
echo"<h1> Enabled widgets</h1>";
var_dump($e);
$d=get_option('disabled_widgets');
echo"<h1> Disabled widgets</h1>";
var_dump($d);
//update_option('enabled_widgets', "");
//update_option('disabled_widgets', "");
//update_option('widgetid', "");
   ?>

    
<?php } ?>