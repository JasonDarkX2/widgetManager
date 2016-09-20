<?php
/*
   Widget setter class for Wordpress Widget Manager
 */

class WidgetSetter{
    function __construct() {
        
    }
    function setAllWidget(&$widgetList, $status) {
    foreach ($widgetList as $widgetId) {
        $widgets[$widgetId['key']]['status'] = $status;
        update_option('widgetid', $widgetList);
    }
}


function setByWidgetTypes(&$widgetList, $type, $status) {
    foreach ($widgetList as $wid) {
        if ($wid['type']!= $type){ 
            continue;
        }else{
            $widgetList[$wid['key']]['status'] = $status;
        }
    }
    update_option('widgetid', $widgetList);
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

function status_count($widgetList,&$enableCount, &$disabledCount){ 
    foreach ($widgetList as $wid) {
        if ($wid['status']){ 
            $enableCount ++;
        } else {
            $disabledCount ++;
        }
    }
}

} 
?>