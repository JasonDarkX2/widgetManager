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
If (isset($_POST['quickOp']) && $_POST['quickOp'] != "") {
    switch ($_POST['quickOp']) {
        case 'enbwid':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon, $disabledcon);
            break;
        case 'diswid':
            $widgets = get_option('widgetid');
            disable_all($widgets, $disabledcon);
            break;
        case 'disDefault':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon);
            disable_types($widgets, "Default", $enablecon, $disabledcon);
            break;
        case 'enbDefault':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon);
            disable_types($widgets, "Custom", $enablecon, $disabledcon);
            disable_types($widgets, "Plugin", $enablecon, $disabledcon);
            break;
        case 'disCust':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon);
            disable_types($widgets, "Custom", $enablecon, $disabledcon);
            break;
        case 'enbPlugin':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon);
            disable_types($widgets, "Default", $enablecon, $disabledcon);
            disable_types($widgets, "Custom", $enablecon, $disabledcon);

            break;
        case 'disPlugin':
            $widgets = get_option('widgetid');
            enable_all($widgets, $enablecon);
            disable_types($widgets, "Plugin", $enablecon, $disabledcon);
        default:
            status_count($enablecon, $disabledcon);
            break;
    }
} else {

    $wid = get_option('widgetid');
    if ($widgets == NULL) {
        return;
    }

    $option = 0;
    $data = $_POST;
    if (isset($data[$widgets])) {
        $option = $data[$widgets];
        if ($option == 'enable') {
            $wid [$widgets]['status'] = TRUE;
        } else {
            $wid[$widgets]['status'] = FALSE;
        }
    }
    update_option('widgetid', $wid);
    status_count($enablecon, $disabledcon);
}

echo '<div class="notfi">' . $enablecon . ' enabled widgets and ' . $disabledcon . ' disabled widgets' . '</div>';

function enable_all(
$widgets, &$enablecon) {
    foreach ($widgets as $widgetId) {

        $widgets[$widgetId['key']]['status'] = TRUE;
        $enablecon++;
        update_option('widgetid', $widgets);
    }
}

function disable_all(
$widgets, &$disabledcon) {
    foreach ($widgets as $widgetId) {

        $widgets[$widgetId['key']]['status'] = false;
        $disabledcon++;
        update_option('widgetid', $widgets);
    }
}

function disable_types($w, $type, &$enablecon, &$disabledcon) {
    foreach ($w as $wid) {
        if (strtolower($wid['type']) == strtolower($type)) {
            $w[$wid['key']]['status'] = FALSE;
            $disabledcon++;
            $enablecon--;
        } else {
            $w[$wid['key']]['status'] = TRUE;
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

function status_count(&

$enablecon, &$disabledcon) {
    $w = get_option('widgetid');
    foreach ($w as $wid) {
        if ($wid['status'] == FALSE) {
            $disabledcon ++;
        } else {
            $enablecon++;
        }
    }
}

?>