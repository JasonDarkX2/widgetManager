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
require_once  plugin_dir_path(__FILE__).'controllers/widgetLoader_controller.php';
class widget_manager {

    static $add_script;
    static $wc;
    function init() {
        define('WPWM_DEBUG', TRUE);
        if (is_admin()) {
            self::$wc=new WidgetController();
            add_action('init',array(__CLASS__,'load_initProcedures'));
            add_action('widgets_init',array(__CLASS__,'load_procedures'));
            add_action('admin_menu', array(__CLASS__, 'widget_manager_create_menu'));
            add_action('admin_enqueue_scripts', array(__CLASS__, 'add_scripts'));
                if (get_option('widgetdir') == NULL||get_option('widgetdir') ==""||get_option('widgetdir') =='/') {
                $defaultDir = plugin_dir_path(__FILE__) . 'custom-widgets/';
                $user = exec(whoami);
                chown($defaultDir, $user);
                update_option('widgetdir', $defaultDir);
            }
        }
        add_action('plugins_loaded', array(__CLASS__,'loaded_procedures') );
    }
    function load_initProcedures(){
        self::$wc-> obsolete_customWidgets();
        self::$wc-> obsolete_pluginWidgets();
        self::$wc-> load_pluginWidgets();
        self::$wc-> load_customWidgets();
        self::$wc->disable_plugin_widget();
        $cw=get_option('custom-widget');
        if($cw!=NULL && self::$wc->newWidgets()==TRUE){
       $WidgetController->createWidgetResource($cw);
    }
    }
    function load_procedures(){
        self::$wc->import_cust_widget();
        self::$wc->remove_disable_widget();
        self::$wc->load_widgets();
    }
    function loaded_procedures(){
        $WidgetController=new WidgetController();
        $WidgetController-> obsolete_customWidgets();
        $WidgetController->import_cust_widget(TRUE);
        add_action('wp_footer',  widget_manager::frontEndScripts());
    }    
    static function frontEndScripts(){
        $resourceFiles=[
            'css'=>'_inc/cwidgets.css',
            'js'=>'_inc/cwidgets.js',
        ];
        foreach ($resourceFiles as $file){
        if(filesize(plugin_dir_path(__FILE__) . $file)!=0){
        wp_enqueue_style('wm-FrontStyle', plugins_url( $file, __FILE__));
        }
        }
    }
    
    static function add_scripts($hook) {

        wp_enqueue_style('wm-style', plugins_url('_inc/style.css', __FILE__));
        wp_enqueue_style('ui-style', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        wp_enqueue_script('ui-script', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'));
        $dir = plugin_dir_path(__FILE__) . 'custom-widgets/';
        $defaultDir = array('defaultDir' => str_replace('//', '/', str_replace('\\', '/', $dir)));
        wp_enqueue_script('wm-script', plugins_url('_inc/wm-script.js', __FILE__), array('jquery'));
        wp_localize_script('wm-script', 'defaults', $defaultDir);
        $translation_array = array('addWidgetUrl' => menu_page_url('credentials', FALSE));
        wp_localize_script('wm-script', 'url', $translation_array);
        $translation_array = array('pluginUrl' => plugins_url('/controllers/widgetAction_controller.php', __FILE__));
        wp_localize_script('wm-script', 'pd', $translation_array);
    }

    static function widget_manager_create_menu() {
        self::$add_script = true;
        //create new top-level menu
        add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator', 'widgetM', array(__CLASS__, 'Widget_manager_settings_page')
                , plugins_url('_inc/img/WMIconHolder.png', __FILE__));
        add_submenu_page(NULL, 'credentials', 'credentials', 'administrator', 'credentials', array(__CLASS__, 'widgetManager_creds_page'));
        add_submenu_page(NULL, 'Action', 'Action', 'administrator', 'action', array(__CLASS__, 'widgetManager_action_page'));
        //call register settings function
        add_action('admin_init', array(__CLASS__, 'register_widget_manager_settings'));
    }

    static function register_widget_manager_settings() {
        //register our settings
        register_setting('WM-setting', 'widgetid');
        register_setting('WM-setting', 'custom-widget');
        register_setting('WM-setting', 'widgetdir');
    }
    static function Widget_manager_settings_page() {
        include(plugin_dir_path(__FILE__) . '/views/Manager.php');
    }

    static function WidgetManager_creds_page() {
        include(plugin_dir_path(__FILE__) . '/controllers/widgetAdder_controller.php');
    }


}
widget_manager::init();
?>