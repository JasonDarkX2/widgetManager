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
    $widgetList = get_option('widgetid');
    $cw=get_option('custom-widget');
    $shown = false;
    array_pop($newWidgets= array());
    $theWidget= new theWidget();
    foreach ($widgets as $keys) {
        $uw = get_option('widgetid');
        if (array_key_exists($keys, $uw) == FALSE) {
            if ($theWidget->get_type($keys) != 'Default') {
                array_push($widgetList, $widgetList[$keys] =$theWidget->make_widget($keys)); 
                array_pop($widgetList);
                //echo $keys. '=>'.$uw[$key]['name'] . var_dump(array_key_exists($keys, $uw));
                array_push($newWidgets, '<li>' . $theWidget->get_name($keys) . '</li>');
               update_option('widgetid', $widgetList);
            }
        }
    }
                    if (count($newWidgets)>0) {
                    echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
                foreach($newWidgets as $nw){echo $nw;}
                $shown=true;
                }
    echo'</ul></div>';
    return $shown;
}

function get_widgets_type($widgets, $types) {
    array_pop($wid = array());
    foreach ($widgets  as $w){
        if ($w['type'] == $types) {
            array_push($wid,$w);
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