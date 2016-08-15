<?php

/*
  controller for Wordpress Widget Manager
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'model/theWidget.php';

class widgetController {

    static $theWidget;
    static $newWidgetList;

    function __construct() {
        self::$theWidget = new theWidget();
        //self::$newWidgetList= array();
    }

    function load_widgets() {
        $widgetsId = get_option('widgetid');
        $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
        $w = ($GLOBALS['wp_widget_factory']->widgets);
        foreach ($widgets as $keys) {
            if (empty($widgetsId)) {
                $widgetsId[$keys] = self::$theWidget->make_widget($keys);
            } else {
                array_push($widgetsId, $widgetsId[$keys] = self::$theWidget->make_widget($keys));

                array_pop($widgetsId);
            }
        }
        update_option('widgetid', $widgetsId);
        $widgets = $widgetsId;
    }

    function load_pluginWidgets() {
        $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
        $widgetList = get_option('widgetid');
        foreach ($widgets as $keys) {
            if (self::$theWidget->get_type($keys) != 'Default' && self::$theWidget->get_type($keys) != 'Custom') {
                if (array_key_exists($keys, $widgetList) == FALSE) {
                    array_push($widgetList, $widgetList[$keys] = self::$theWidget->make_widget($keys));
                    $this->addto($keys);
                    array_pop($widgetList);
                    update_option('widgetid', $widgetList);
                }
            }
        }
    }

    function obsolete_pluginWidgets() {
        $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
        $widgetList = get_option('widgetid');
        foreach ($widgetList as $w => $v) {
            if (self::$theWidget->get_type($v[$w]['key']) != 'Default' && self::$theWidget->get_type($v[$w]['key']) != 'Custom') {
                if (array_key_exists($v[$w]['key'], $widgets) == FALSE) {
                    unset($widgetList[$v[$w]['key']]);
                    update_option('widgetid', $widgetList);
                }
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

    function remove_disable_widget() {
        $d = get_option('widgetid');
        if ($d != NULL) {
            foreach ($d as $widget) {
                if ($widget['status'] == FALSE) {
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

    function obsolete_customWidgets() {
        $widgets = get_option('widgetid');
        $cust = get_option('custom-widget');
        if (!empty($cust) && !empty($widgets))
            foreach ($cust as $w) {
                if (file_exists(get_option('widgetdir') . $w['file']) == FALSE) {
                    unset($cust[$w['key']]);
                    unset($widgets[$w['key']]);
                    update_option('widgetid', $widgets);
                    update_option('custom-widget', $cust);
                }
            }
    }

    function import_cust_widget() {
        $dir = get_option('widgetdir');
        $w = get_option('widgetid');
        $cust = get_option('custom-widget');
        $custwid = self::$theWidget->getCustomWidgets($dir);
        if ($custwid != null) {
            foreach ($custwid as $wid) {
                $info = new SplFileInfo($dir . $wid);
                if ($info->getExtension() == 'php') {
                    $class = self::$theWidget->getWidgetClass($wid);
                    if (class_exists($class) == FALSE)
                        include($dir . $wid);
                    register_widget($class);
                }
                if (empty($cust) == TRUE && $class != '') {
                    $cust[$class] = self::$theWidget->make_customWiget($wid);
                } else {
                    if (array_key_exists($class, $cust) == FALSE) {
                        array_push($cust, $cust[$class] = self::$theWidget->make_customWiget($wid));
                        array_pop($cust);
                    }
                }
                update_option('custom-widget', $cust);
            }
        }
    }

    function load_customWidgets() {
        $w = get_option('widgetid');
        $cust = get_option('custom-widget');
        foreach ($cust as $cw) {
            if (!array_key_exists($cw['key'], $w)) {
                array_push($w, $w[$cw['key']] = self::$theWidget->make_widget($cw['key']));
                array_pop($w);
                $this->addto($cw['key']);
                update_option('widgetid', $w);
            }
        }
    }

    function addto($key) {
        $w = get_option('widgetid');
        if (!array_key_exists($key, $w)) {
            self::$newWidgetList[$key] = '<li>' . self::$theWidget->get_name($key) . '</li>';
        } else {
            unset($list[$key]);
        }
    }

    function show() {
        if (count(self::$newWidgetList) > 0) {
            echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
            foreach (self::$newWidgetList as $nw) {
                echo $nw;
            }
            $shown = true;
        }
        echo'</ul></div>';
        self::$newWidgetList = null;
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
        if (!empty($cw))
            foreach ($cw as $c => $v) {
                if (array_key_exists($v[$c]['key'], $d) == FALSE) {
                    unset($cw[$v[$c]['key']]);
                    update_option('custom-widget', $cw);
                }
            }
    }

    function empty_names() {
        $cust = get_option('custom-widget');
        if ($cust != NULL)
            foreach ($cust as $wid) {
                if (self::$theWidget->get_name($wid['class']) != NULL)
                    $cust[$wid['key']]['name'] = self::$theWidget->get_name($wid['class']);
            }

        update_option('custom-widget', $cust);
    }

}
