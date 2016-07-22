<?php
/*
controller for Wordpress Widget Manager
 */
class widgetController{
   function __construct() {
       
   }
   function load_widgets() {
        $w = get_option('widgetid');
        if (empty($w)) {
            $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $w = ($GLOBALS['wp_widget_factory']->widgets);
            foreach ($widgets as $keys) {
                if (empty($widgetsId)) {
                    $type = get_type($keys);
                    $widgetsId = array($keys => array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'type' => $type, 'status' => TRUE));
                } else {
                    $type = get_type($keys);
                    array_push($widgetsId, $widgetsId[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
                    array_pop($widgetsId);
                }
            }
            update_option('widgetid', $widgetsId);
            $widgets = $widgetsId;
        } else {
            $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $wid = ($GLOBALS['wp_widget_factory']->widgets);
            $type = get_type($keys);
            array_push($w, $w[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
            array_pop($w);

            update_option('widgetid', $w);
        }
    }
}

    function disable_plugin_widget() {
        $d = get_option('widgetid');
        if ($d != NULL) {
            foreach ($d as $widget) {
                if ($d[$widget['key']]['status'] == FALSE && $widget['type'] == 'Plugin') {
                    if (class_exists($widget['key'])) {
                        $wid = ($GLOBALS['wp_widget_factory']->widgets);
                        unregister_widget($widget['key']);
                        unset($GLOBALS['wp_registered_widgets'][$widget['id']]);
                    } else {
                        unset($d[$widget['key']]);
                        unset($GLOBALS['wp_registered_widgets'][$widget['id']]);
                        update_option('widgetid', $d);
                    }
                }
            }
        }
    }
       /*function load_widgets() {
        $w = get_option('widgetid');
        if (empty($w)) {
            $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $w = ($GLOBALS['wp_widget_factory']->widgets);
            foreach ($widgets as $keys) {
                if (empty($widgetsId)) {
                    $type = get_type($keys);
                    $widgetsId = array($keys => array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'type' => $type, 'status' => TRUE));
                } else {
                    $type = get_type($keys);
                    array_push($widgetsId, $widgetsId[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
                    array_pop($widgetsId);
                }
            }
            update_option('widgetid', $widgetsId);
            $widgets = $widgetsId;
        } else {
            $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $wid = ($GLOBALS['wp_widget_factory']->widgets);
            $type = get_type($keys);
            array_push($w, $w[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
            array_pop($w);

            update_option('widgetid', $w);
        }
    }*/
