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
    
    
 function get_type($keys) {
    $wm = new widget_manager();
    import_cust_widget();
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
}
    
}