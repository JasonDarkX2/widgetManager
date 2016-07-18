<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class widgetRetriever{

    
    
function autoDetect() {
    $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
    $w = get_option('widgetid');
    $shown = false;
    foreach ($widgets as $keys) {
        if (array_key_exists($keys, $w) == FALSE) {
            if (get_type($keys) != 'Default') {
                $type = get_type($keys);
                array_push($w, $w[$keys] = array('key' => $keys, 'name' => get_name($keys), 'Description' => get_description($keys), 'id' => get_id($keys), 'type' => $type, 'status' => TRUE));
                array_pop($w);
                if ($shown != TRUE) {
                    echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
                    $shown = true;
                }
                echo '<li>' . get_name($keys) . '</li>';
                update_option('widgetid', $w);
            }
        }
    }
    echo'</ul></div>';
    return $shown;
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
    return $wid;
}

}