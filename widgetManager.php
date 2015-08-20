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
register_activation_hook(__FILE__,'WP-widgetManager'); 
// Hook for adding admin menus
if( is_admin() ){
    
  // create custom plugin settings menu
add_action('admin_menu', 'widget_manager_create_menu');


}
function widget_manager_create_menu() {

	//create new top-level menu
	add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator', __FILE__, 
                'widgets_manager_page' 
                , plugins_url('/img/WMIconHolder.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'add_plugin_page' );
}
function add_plugin_page()
    {
    //register our settings
	register_setting( 'WMOption', 'widgetId' );
	register_setting( 'WMOption', 'Enabled_Widgets' );
	register_setting( 'WMOption', 'Disabled_widgets' );
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Widget manager', 
            'manage_options', 
            'widget-Manager', 
            array( $this, 'create_admin_page' )
        );
    }
    
   
    function widgets_manager_page()
    {
       
        $defaultWidgets=array();
        $customWidgets=Array();
    $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
    $wvalue=esc_html( var_export( $widgets, TRUE) );?> 
    <h1> Widget Manager</h1>
    <form  method="POST" action="<?php echo plugins_url('options.php', __FILE__); ?>">
    <?php settings_fields( 'WMOption' ); ?>
    <?php do_settings_sections( 'WMOption' ); ?>
    <table border="1px">
        <tr><th><input type="checkbox" name="select all" onclick="selectall()"></th><th> Widgets</th><th> Enabled</th><th>Disabled</th></tr>
    <?php  $options = get_option( 'widgetId' ); foreach($widgets as $widget):?>
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
            <td><input type='hidden' name='widgetId[]' value='<?php echo  $widget ?>' id='widgetId'> 
                <?php echo $widget . $type; ?></td>
            <td><input type="radio" name="<?php echo $widget; ?>" <?php checked( isset( $option[$widget] ) ); ?> value="enable"></td>
            <td><input type="radio" name="<?php echo $widget;?>" value="disable"></td>
        </tr>
    <?php endforeach;?>
    <?php echo "</table>";
    submit_button(); 
echo "</form>";
echo "<b>DEBUG Section:</b>";
foreach($defaultWidgets as $dw){
       echo $dw;
   }
   }
   
class Widget_manager {
	static $add_script;
      public $defaultWidgets=array();
      public  $customWidgets=Array();
        static function init(){
            
        }
        
}