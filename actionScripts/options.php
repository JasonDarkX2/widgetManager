<?php

/*
 * options action script for Wordpress Widget Manager plugin
 * Handles the adminstrative options for widgets, the enabling and disabling widdgets. Pretty much butter of the plugin :P  
 * For more information check out: http://JasonDarkX2.com/ 
 */
$w = $_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$enablecon = 0;
$disabledcon = 0;
$widgets = $_POST['widgetid'];
If (isset($_POST['quickOp'])) {
    switch ($_POST['quickOp']) {
        case 'enbwid':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            break;
        case 'diswid':
            $widgets = get_option('widgetid');
            disable_all($widgets);
            break;
        case 'disDefault':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            disable_types($widgets, "Default");
            break;
        case 'enbDefault':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            disable_types($widgets, "Plugin");
            disable_types($widgets, "Custom");
            break;
        case 'disCust':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            disable_types($widgets, "Custom");
            break;
        case 'enbPlugin':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            disable_types($widgets, "Default");
            disable_types($widgets, "Custom");

            break;
        case 'disPlugin':
            $widgets = get_option('widgetid');
            enable_all($widgets);
            disable_types($widgets, "Plugin");
            break;
        case 'pick':
            return;
            break;
        default:
            status_count($enablecon, $disabledcon);
            break;
    }
} else {

    $wid = get_option('widgetid');
    if (empty($widgets)) {
        return;
    }
    $option = 0;
    $data = $_POST;
    if (isset($data[$widgets])) {
        $option = $data[$widgets];
        $wid[$widgets]['status']=($option == 'enable') ? TRUE:FALSE; 
    }
    update_option('widgetid', $wid);
    
}
status_count($enablecon, $disabledcon);
echo '<div class="notfi">' . $enablecon . ' enabled widgets and ' . $disabledcon . ' disabled widgets' . '</div>';

function enable_all(&$widgets) {
    foreach ($widgets as $widgetId) {

        $widgets[$widgetId['key']]['status'] = TRUE;
        update_option('widgetid', $widgets);
    }
}

function disable_all(&$widgets) {
    foreach ($widgets as $widgetId) {
        $widgets[$widgetId['key']]['status'] = false;
        update_option('widgetid', $widgets);
    }
}

function disable_types(&$w, $type) {
    foreach ($w as $wid) {
        if ($wid['type']!= $type){ 
            continue;
        }else{
            $w[$wid['key']]['status'] = FALSE;
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

function status_count(&$enablecon, &$disabledcon){ 
    $w = get_option('widgetid');
    foreach ($w as $wid) {
        if (!$wid['status']){ 

            $disabledcon ++;
        } else {
            $enablecon++;
        }
    }
}

?>