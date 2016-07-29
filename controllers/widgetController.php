<?php
/*
controller for Wordpress Widget Manager
 */
require_once  plugin_dir_path(dirname(__FILE__)).'model/theWidget.php';
class widgetController{
   function __construct() {
       
   }
   function load_widgets() {
       $theWidget= new theWidget();
        $w = get_option('widgetid');
        if (empty($w)) {
            $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $w = ($GLOBALS['wp_widget_factory']->widgets);
            foreach ($widgets as $keys) {
                if (empty($widgetsId)) {
                    //$type = get_type($keys);
                    $widgetsId = $theWidget->make_widget($keys);
                            //array($keys => array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'type' => $type, 'status' => TRUE));
                } else {
                    //$type = get_type($keys);
                    array_push($widgetsId, $widgetsId[$keys] = $theWidget->make_widget($keys));
                            //array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
                    array_pop($widgetsId);
                }
            }
            update_option('widgetid', $widgetsId);
            $widgets = $widgetsId;
        } else {
            /*$widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
            $wid = ($GLOBALS['wp_widget_factory']->widgets);
            $type = get_type($keys);
            array_push($w, $w[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
            array_pop($w);

            update_option('widgetid', $w);*/
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
    function remove_disable_widget() {
        $d = get_option('widgetid');
        if ($d != NULL) {
            foreach ($d as $widget) {
                if ($d[$widget['key']]['status'] == FALSE) {
                    if (class_exists($widget['key'])) {
                        unregister_widget($widget['key']);
                    } else {
                        unset($d[$widget['key']]);
                        update_option('widgetid', $d);
                    }
                }
            }
        }
    }
        function import_cust_widget() {
        $dir = get_option('widgetdir');
        $w = get_option('widgetid');
        $cust = get_option('custom-widget');
        $custwid = getCustomWidgets($dir);
        $theWidget = new theWidget();
        if ($custwid != null) {
            foreach ($custwid as $wid) {
                $info = new SplFileInfo($dir . $wid);
                if ($info->getExtension() == 'php') {
                    if (class_exists($theWidget->getWidgetClass($wid)) == FALSE)
                        include($dir . $wid);
                    register_widget($theWidget->getWidgetClass($wid));
                }
                if (empty($cust) == TRUE && $theWidget->getWidgetClass($wid) != '') {
                    $cust[$theWidget->getWidgetClass($wid)] = $theWidget->make_customWiget($wid);
                            //array('key' => getWidgetClass($wid), 'class' => getWidgetClass($wid), 'name' => get_name(getWidgetClass($wid)), 'file' => $wid, 'status' => true);
                } else {
                    if (array_key_exists($theWidget->getWidgetClass($wid), $cust) == FALSE) {
                        array_push($cust, $cust[getWidgetClass($wid)] = $theWidget->make_customWiget($wid));
                                //array('key' => getWidgetClass($wid), 'class' => getWidgetClass($wid), 'name' => get_name(getWidgetClass($wid)), 'file' => $wid, 'status' => true));
                        array_pop($cust);
                    }
                }
                //$w[getWidgetClass($wid)]['type'] = "Custom";
                update_option('custom-widget', $cust);
            }
        }
    }
    function clean_sweep() {
        $d = get_option('widgetid');
        $cw = get_option('custom-widget');
        foreach ($d as $widget) {
            if (class_exists($widget['key']) == FALSE) {
                unset($d[$widget['key']]);
                update_option('widgetid', $d);
            }
        }
        if (empty($cw) == FALSE)
            foreach ($cw as $c) {
                if (array_key_exists($c['key'], $d) == FALSE) {
                    unset($cw[$c['key']]);
                    update_option('custom-widget', $cw);
                }
            }
    }
    function empty_names() {
        $theWidget= new theWidget();
    $cust = get_option('custom-widget');
    if ($cust != NULL)
        foreach ($cust as $wid) {
            if ($theWidget->get_name($wid['class']) != NULL)
                $cust[$wid['key']]['name'] = $theWidget->get_name($wid['class']);
        }

    update_option('custom-widget', $cust);
}
        }



