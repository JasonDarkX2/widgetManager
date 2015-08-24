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
    $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
    $options = get_option( 'widgetId' ); foreach($widgets as $widget):?>
        <input type='hidden' name='count' value='$num' id='count'>
        
<?php if(preg_match("/WP_(Widget|Nav)/", $widget)){
    $type="<strong>(default)</strong>";
    array_push($defaultWidgets, $widget);
}else{
    $type="<strong>(custom)</strong>";
    array_push($customWidgets, $widget);
} 
?>
        <tr>
            <td><input type="checkbox" name="<?php echo $widget ?>" value="<?php echo $widget; ?>"></td>
            <td><input type='hidden' name='widgetid[]' value='<?php echo  $widget ?>' id='widgetId'> 
                <?php echo $widget . $type; ?></td>
            <td><input type="radio" name="<?php echo $widget; ?>" <?php checked( isset( $option[$widgetid] ) ); ?> value="enable"><?php echo get_option($widget);?></td>
            <td><input type="radio" name="<?php echo $widget;?>" <?php checked( isset( $option[$widgetid] ) ); ?> value="disable"></td>
        </tr>
    <?php endforeach;?>
        <tr>
    </table>
    <?php submit_button(); ?>

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
   ?>

    
<?php } ?>