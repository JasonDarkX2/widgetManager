<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once  plugin_dir_path(dirname(__FILE__)).'model/theWidget.php';
class widgetRetriever{

    public $theWidget;
            function __construct() {
                $this->theWidget=new theWidget();
    }
function autoDetect() {
    $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
    $w = get_option('widgetid');
    $shown = false;
    $theWidget= new theWidget();
    foreach ($widgets as $keys) {
        if (array_key_exists($keys, $w) == FALSE) {
            if ($theWidget->get_type($keys) != 'Default') {
                //$type = get_type($keys);
                array_push($w, $w[$keys] =$theWidget->make_widget($keys)); 
//array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
                array_pop($w);
                if ($shown != TRUE) {
                    echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
                    $shown = true;
                }
                echo '<li>' . $theWidget->get_name($keys) . '</li>';
                update_option('widgetid', $w);
            }
        }
    }
    echo'</ul></div>';
    return $shown;
}

function get_widgets_type($widgets, $types) {
    array_pop($wid = array());
    foreach ($widgets as $widget) {
        if ($widget['type'] == $types) {
            array_push($wid, $widget);
        } else {
            continue;
        }
    }
    usort($wid, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
}
}