<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class theWidget{

function make_widget($key){
    $widget = array($keys => array(
        'key' => $keys, 
        'name' => $this->get_name($keys), 
        'Description' => $this->get_description($keys), 
        'type' => $this->get_type($keys), 
        'status' => TRUE));
    return $widget;
}
function make_customWiget($key){
    $index=  $this->getWidgetClass($key);
   $widget=array('key' => $index , 
        'class' => $index, 
        'name' => $this->get_name($index), 
        'file' => $key, 
       'type' =>'Custom', 
        'status' => true);

   return $widget;
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

function get_type($keys) {
    $wc = new widgetController();
    $wc->import_cust_widget();
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