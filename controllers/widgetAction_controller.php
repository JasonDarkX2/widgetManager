<?php

/*
 * WidgetManager
  widget controller for the setting widgets state
 */
require_once dirname(dirname(__FILE__)) . '/model/WidgetSetter.php';


$w = $_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');
$wid = get_option('widgetid');
$WidgetSetter = new WidgetSetter();
$enablecon = 0;
$disabledcon = 0;
$widgets = $_POST['widgetid'];
If (isset($_POST['quickOp'])) {
    switch ($_POST['quickOp']) {
        case 'enbwid':
            $widgets = get_option('widgetid');
            $WidgetSetter->setAllWidget($widgets, TRUE);
            break;
        case 'diswid':
            $widgets = get_option('widgetid');
            $WidgetSetter->setAllWidget($widgets, FALSE);
            break;
        case 'disDefault':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            $WidgetSetter->setByWidgetTypes($widgets, "Default", FALSE);
            Update_option('defaultStatus',false);
            echo '<div class="notfi">  All Default widgets disabled</div>';
            break;
        case 'enbDefault':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Plugin", FALSE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Custom", FALSE);
            $WidgetSetter->setByWidgetTypes($widgets, "Default", TRUE);
            Update_option('defaultStatus',true);
            echo '<div class="notfi">  All Default widgets enabled</div>';
            break;
        case 'enbCust':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Default", FALSE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Plugin", FALSE);
            $WidgetSetter->setByWidgetTypes($widgets, "Custom", TRUE);
            Update_option('custStatus',TRUE);
            echo '<div class="notfi">  All Custom widgets enabled</div>';
            break;
        case 'disCust':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            $WidgetSetter->setByWidgetTypes($widgets, "Custom", FALSE);
            Update_option('custStatus',FALSE);
            echo '<div class="notfi">  All Custom widgets disabled</div>';
            break;
        case 'enbPlugin':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Default", FALSE);
            //$WidgetSetter->setByWidgetTypes($widgets, "Custom", FALSE);
            $WidgetSetter->setByWidgetTypes($widgets, "Plugin", True);
            Update_option('pluginStatus',true);
            echo '<div class="notfi">  All Plugin widgets enabled</div>';
            break;
        case 'disPlugin':
            $widgets = get_option('widgetid');
            //$WidgetSetter->setAllWidget($widgets, TRUE);
            $WidgetSetter->setByWidgetTypes($widgets, "Plugin", FALSE);
            Update_option('pluginStatus',false);
            echo '<div class="notfi">  All Plugin Widgets disabled</div>';
            break;
        case 'pick':
            return;
            break;
        default:
            $WidgetSetter->status_count($wid, $enablecon, $disabledcon);
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
        $wid[$widgets]['status'] = ($option == 'true') ? TRUE : FALSE;

    }
    update_option('widgetid', $wid);

}
/*$wid = get_option('widgetid');
$WidgetSetter->status_count($wid, $enablecon, $disabledcon);
echo '<div class="notfi">' . $enablecon . ' enabled widgets and ' . $disabledcon . ' disabled widgets' . '</div>';*/