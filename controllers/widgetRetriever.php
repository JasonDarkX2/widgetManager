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