<?php
/*
   Widget setter class for Wordpress Widget Manager
 */

class WidgetSetter{
    function __construct() {
        
    }
    function setAllWidget(&$widgets, $status) {
    foreach ($widgets as $widgetId) {
        $widgets[$widgetId['key']]['status'] = $status;
        update_option('widgetid', $widgets);
    }
}


function setByWidgetTypes(&$w, $type, $status) {
    foreach ($w as $wid) {
        if ($wid['type']!= $type){ 
            continue;
        }else{
            $w[$wid['key']]['status'] = $status;
        }
    }
    update_option('widgetid', $w);
}
function get_count($type) {

    $w = get_option('widgetid');
    $count = 0;
    foreach ($w as $wid) {
        if (strtolower($wid['type']) == strtolower($type)) {
            $count++;
        }
    }
    return $count;
}

function status_count($wl,&$enablecon, &$disabledcon){ 
    foreach ($wl as $wid) {
        if ($wid['status']){ 
            $enablecon ++;
        } else {
            $disabledcon ++;
        }
    }
}

} 
?>