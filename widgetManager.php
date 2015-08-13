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
  include( plugin_dir_path( __FILE__ ) . "options.php");
    $my_settings_page = new easyVote();
}
class Widget_manager {
	static $add_script;
        static function init(){
            
        }
        
}