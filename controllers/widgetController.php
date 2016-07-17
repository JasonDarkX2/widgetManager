<?php
/*
controller for Wordpress Widget Manager
 */

class widgetController{
    
private $dir;
public $widget;
public $cust;
private function __constructor($d,$w,$c){
   $this->dir=$d;
$this->widget=$w;
$this->cust=$c;
}
        function import_cust_widget() {
        $custwid = getCustomWidgets($dir);
        if ($custwid != null) {
            foreach ($custwid as $wid) {
                $info = new SplFileInfo($dir . $wid);
                if ($info->getExtension() == 'php') {
                    if (class_exists(getWidgetClass($wid)) == FALSE)
                        include($dir . $wid);
                    register_widget(getWidgetClass($wid));
                }
                if (empty(self::$cust) == TRUE && getWidgetClass($wid) != '') {
                    self::$cust[getWidgetClass($wid)] = array('key' => getWidgetClass($wid), 'class' => getWidgetClass($wid), 'name' => get_name(getWidgetClass($wid)), 'file' => $wid, 'status' => true);
                } else {
                    if (array_key_exists(getWidgetClass($wid), $cust) == FALSE) {
                        array_push(self::$cust, self::$cust[getWidgetClass($wid)] = array('key' => getWidgetClass($wid), 'class' => getWidgetClass($wid), 'name' => get_name(getWidgetClass($wid)), 'file' => $wid, 'status' => true));
                        array_pop(self::$cust);
                    }
                }
                $w[getWidgetClass($wid)]['type'] = "Custom";
                update_option('custom-widget', self::$cust);
            }
        }
    }
    function load_widgets() {
        $w = self::widget;
        var_dump($w);
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
    
}