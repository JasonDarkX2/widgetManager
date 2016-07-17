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
require_once plugin_dir_path(__FILE__).'controllers/widgetController.php';
class widget_manager {

    static $add_script;
    static function init() {
        //define('WPWM_DEBUG', true);
        $dir = get_option('widgetdir');
        $w = get_option('widgetid');
        $cust = get_option('custom-widget');
         $w=new widgetController($dir,$w,$cust);
        if (is_admin()) {
            add_action('widgets_init',$w->import_cust_widget);
            add_action('widgets_init', $w->remove_disable_widget);
            add_action('init',$w->disable_plugin_widget);
            add_action('widgets_init',$w->load_widgets);
            add_action('widgets_init', $w->clean_sweep);
            add_action('widgets_init', 'empty_names');
            add_action('admin_menu', array(__CLASS__, 'widget_manager_create_menu'));
            add_action('admin_enqueue_scripts', array(__CLASS__, 'add_scripts'));
            if (get_option('widgetdir') == NULL||get_option('widgetdir') ==''||get_option('widgetdir') =='/') {
                $defaultDir = dirname(plugin_dir_path(__FILE__)) . '/custom-widgets/';
                $user = exec(whoami);
                chown($defaultDir, $user);
                update_option('widgetdir', $defaultDir);
            }
        }

            add_action('plugins_loaded', array(__CLASS__, 'front_end_import'));
    }
static function front_end_import(){
    $dir = get_option('widgetdir');
    $widgetid=get_option('widgetid');
    $custwid= get_option('custom-widget');
    if(!empty($custwid)){
                foreach ($custwid as $wid) {
                if ($widgetid[$wid['key']]['status']==TRUE) {
                        include($dir . $wid['file']);
                }
            }
    }
}
    
    static function add_scripts($hook) {

        wp_enqueue_style('wm-style', plugins_url('style.css', __FILE__));
        wp_enqueue_style('ui-style', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        wp_enqueue_script('ui-script', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'));
        $dir = plugin_dir_path(__FILE__) . 'custom-widgets/';
        $defaultDir = array('defaultDir' => str_replace('//', '/', str_replace('\\', '/', $dir)));
        wp_enqueue_script('wm-script', plugins_url('wm-script.js', __FILE__), array('jquery'));
        wp_localize_script('wm-script', 'defaults', $defaultDir);
        $translation_array = array('addWidgetUrl' => menu_page_url('credentials', FALSE));
        wp_localize_script('wm-script', 'url', $translation_array);
        $translation_array = array('pluginUrl' => plugins_url('/actionScripts/options.php', __FILE__));
        wp_localize_script('wm-script', 'pd', $translation_array);
    }

    static function widget_manager_create_menu() {
        self::$add_script = true;
        //create new top-level menu
        add_menu_page('Widget Manager Settings', 'Widget Manager', 'administrator', 'widgetM', array(__CLASS__, 'Widget_manager_settings_page')
                , plugins_url('/img/WMIconHolder.png', __FILE__));
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
        
        include(plugin_dir_path(__FILE__) . '/pages/Manager.php');
    }

    static function WidgetManager_creds_page() {
        include(plugin_dir_path(__FILE__) . '/pages/credentials.php');
    }

}

function getCustomWidgets($dir) {
    $customwidgets = array();
    $widgetdir = get_option('widgetdir');
    if (file_exists($dir)) {
        $cdir = scandir($dir);
    } else {
        return;
    }

    foreach ($cdir as $d) {
        if ($d == "." || $d == ".." || $d == ".svn") {
            continue;
        }
        if (is_dir($widgetdir . '/' . $d) == TRUE) {
            $dirFile = scandir($widgetdir . '/' . $d);
            foreach ($dirFile as $dir) {
                $info = new SplFileInfo($dir);
                if (is_dir($dir) == FALSE && $info->getExtension() == 'php') {
                    $file = $d . '/' . $dir;
                    array_push($customwidgets, $file);
                }
            } 
        } else {
            if (is_dir($d) == FALSE) {
                array_push($customwidgets, $d);
            }
        }
    }
    return $customwidgets;
}

function getWidgetClass($file) {

    $c = get_option('custom-widget');
    $dir = get_option('widgetdir');
    if ($file != "") {
        if (file_exists($dir . $file))
            $file = file_get_contents($dir . $file);
        $t = token_get_all($file);
        $class_token = false;
        foreach ($t as $token) {
            if (is_array($token)) {
                if ($token[0] == T_CLASS) {
                    $class_token = true;
                } else if ($class_token && $token[0] == T_STRING) {
                    $widget_class = $token[1];
                    $class_token = false;
                }
            }
        }
    }
    return $widget_class;
}

/*function get_type($keys) {
    $wm = new widget_manager();
    $wm->import_cust_widget();
    $c = get_option('custom-widget');
    if ($c == null) {
        $c = get_option('widgetid');
    }
    if (preg_match("/WP_(Widget|Nav)/", $keys)) {
        $type = "Default";
    } else if (array_key_exists($keys, $c) == FALSE) {
        $type = "Plugin";
    } else {
        $type = "Custom";
    }
    return $type;
}*/

function get_name($key) {
    $wid = ($GLOBALS['wp_widget_factory']->widgets);
    $name = $wid[$key]->name;
    return $name;
}

function get_id($key) {
    $wid = ($GLOBALS['wp_widget_factory']->widgets);
    $id = $wid[$key]->id;
    return $id;
}

function get_description($key) {
    $wid = ($GLOBALS['wp_widget_factory']->widgets);
    return $wid[$key]->widget_options['description'];
}

function empty_names() {
    $cust = get_option('custom-widget');
    if ($cust != NULL)
        foreach ($cust as $wid) {
            if (get_name($wid['class']) != NULL)
                $cust[$wid['key']]['name'] = get_name($wid['class']);
        }

    update_option('custom-widget', $cust);
}


widget_manager::init();
?>