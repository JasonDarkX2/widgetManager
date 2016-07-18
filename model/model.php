<?php
/*
 model for Wordpress Widget Manager
 */
class WidgetsList{
    
    
    
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
}