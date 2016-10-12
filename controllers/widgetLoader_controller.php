<?php

/*
  controller for Wordpress Widget Manager
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'model/theWidget.php';

class WidgetController {

    static $theWidget;
    static $newWidgetList;

    function __construct() {
        self::$theWidget = new theWidget();
    }

    function load_widgets() {
        $widgetsId = get_option('widgetid');
        $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
        $w = ($GLOBALS['wp_widget_factory']->widgets);
        foreach ($widgets as $keys) {
            if (empty($widgetsId)) {
                $widgetsId[$keys] = self::$theWidget->make_widget($keys);
            } else {
                array_push($widgetsId, $widgetsId[$keys] = self::$theWidget->make_widget($keys));

                array_pop($widgetsId);
            }
        }
        update_option('widgetid', $widgetsId);
        $widgets = $widgetsId;
    }

    function load_pluginWidgets() {
        $widgets = array_keys($GLOBALS['wp_widget_factory']->widgets);
        $widgetList = get_option('widgetid');
        foreach ($widgets as $keys) {
            if (!preg_match_all("/Default|Custom/",self::$theWidget->get_type($keys))) {
                if (array_key_exists($keys, $widgetList) == FALSE) {
                    array_push($widgetList, $widgetList[$keys] = self::$theWidget->make_widget($keys));
                    $this->addto($keys);
                    array_pop($widgetList);
                    
                }
            }
        }
        update_option('widgetid', $widgetList);
        session_start();
        if(empty($_SESSION['plugin']))
       $_SESSION['plugin']=self::$newWidgetList;
    }

    function obsolete_pluginWidgets() {
        $widgets = $GLOBALS['wp_widget_factory']->widgets;
        $widgetList = get_option('widgetid');
        foreach ($widgetList as $w) {
            if (!preg_match_all("/Default|Custom/",$w['type'])) {
                if (!array_key_exists($w['key'], $widgets)) {
                    unset($widgetList[$w['key']]);
                }
            }
        }
        update_option('widgetid', $widgetList);
    }

    function disable_plugin_widget() {
        $d = get_option('widgetid');
        if ($d != NULL) {
            foreach ($d as $widget) {
                if ($widget['status'] == FALSE && $widget['type'] == 'Plugin') {
                    if (class_exists($widget['key'])) {                       
                        $wid = ($GLOBALS['wp_widget_factory']->widgets);
                        unregister_widget($widget['key']);
                        unset($GLOBALS['wp_registered_widgets'][$widget['id']]);
                    } else {
                        unset($d[$widget['key']]);
                        unset($GLOBALS['wp_registered_widgets'][$widget['id']]);
                        update_option('widgetid', $d);
                    }
                }
            }
        }
    }

    function remove_disable_widget() {
        $d = get_option('widgetid');
        if ($d != NULL) {
            foreach ($d as $widget) {
                if ($widget['status'] == FALSE) {
                    if (class_exists($widget['key'])) {
                        unregister_widget($widget['key']);
                    } else {
                        unset($d[$widget['key']]);
                        update_option('widgetid', $d);
                    }
                }
            }
        }
    }

    function obsolete_customWidgets() {
        $widgets = get_option('widgetid');
        $cust = get_option('custom-widget');
        if(empty($cust) && !empty($widgets)){
            foreach($widgets as $wid){
                if($wid['type']=='Custom'){
                    unset($widgets[$wid['key']]);
                    update_option('widgetid', $widgets);
                }
            }
        }
        else if (!empty($cust) && !empty($widgets))
            foreach ($cust as $w) {
                if (file_exists(get_option('widgetdir') . $w['file']) == FALSE) {
                    unset($cust[$w['key']]);
                    unset($widgets[$w['key']]);
                    update_option('widgetid', $widgets);
                    update_option('custom-widget', $cust);
                }
            }
    }

    function import_cust_widget($frontEndOnly=FALSE) {
        $dir = get_option('widgetdir');
        $w = get_option('widgetid');
        $cust = get_option('custom-widget');
        $custwid = self::$theWidget->getCustomWidgets($dir);
        //frontend import
        if($frontEndOnly){
         if(!empty($cust)&& !empty($w)){
                foreach ($cust as $wid) {
                   if(array_key_exists($wid['key'], $w)){
                if ($w[$wid['key']]['status']==TRUE) {
                        include($dir . $wid['file']);
                          $class = self::$theWidget->getWidgetClass($wid['file']);
                }
                   }
            }
    }
        }else{
        //backend import
        if ($custwid != null) {
            foreach ($custwid as $wid) {
                $info = new SplFileInfo($dir . $wid);
                if ($info->getExtension() == 'php') {
                    $class = self::$theWidget->getWidgetClass($wid);
                    if (class_exists($class) == FALSE){
                        include($dir . $wid);
                    register_widget($class);
                    
                    }
                }
            }
        }
        }
    }
    function addCustomWidgets(){
        $dir = get_option('widgetdir');
         $custwid = self::$theWidget->getCustomWidgets($dir);
        if ($custwid != null) {
            foreach ($custwid as $wid) {
                $info = new SplFileInfo($dir . $wid);
                if ($info->getExtension() == 'php') {
                    $class = self::$theWidget->getWidgetClass($wid);
                    if (class_exists($class) == FALSE)
                        include($dir . $wid);
                    register_widget($class);
                }
                if (empty($cust) == TRUE && $class != '') {
                    $cust[$class] = self::$theWidget->make_customWiget($wid);
                } else {
                    if (!empty($cust)&& array_key_exists($class, $cust) == FALSE) {
                        array_push($cust, $cust[$class] = self::$theWidget->make_customWiget($wid));
                        array_pop($cust);
                    }
                }
                update_option('custom-widget', $cust);
            }
    }
    }

    function load_customWidgets() {
        $w = get_option('widgetid');
        $this->addCustomWidgets();
        $cust = get_option('custom-widget');
        if(empty($cust)!=TRUE){
        foreach ($cust as $cw) {
            if (!array_key_exists($cw['key'], $w)) {
                array_push($w, $w[$cw['key']] = self::$theWidget->make_widget($cw['key']));
                array_pop($w);
                $this->addto($cw['key']);
                update_option('widgetid', $w);
            }
        }
        }
    }

    function addto($key) {
        $w = get_option('widgetid');
        if (!array_key_exists($key, $w)) {
            self::$newWidgetList[$key] = '<li>' . self::$theWidget->get_name($key) . '</li>';
        } else {
            unset($list[$key]);
        }
    }

    function show() {
        if(count($_SESSION['plugin'])>0){
            self::$newWidgetList=$_SESSION['plugin'];
            $_SESSION['plugin']=null;
        }
        if (count(self::$newWidgetList) > 0) {
            echo '<div class="notfi"><strong>Recently added widgets</strong> <ul style="list-style:disc; padding: 1px; list-style-position: inside;">';
            foreach (self::$newWidgetList as $nw) {
                echo $nw;
            }
            $shown = true;
        }
        echo'</ul></div>';
        self::$newWidgetList = null;
    }
    // Simply compile custom widgets css files and creates the single custom widgets main css file
    function createWidgetCss(){
        $customWidgets=get_option('custom-widget');
        $mainStyleFile=plugin_dir_path(dirname(__FILE__)) .'/_inc/customStyling.css';
        file_put_contents($mainStyleFile,'');   
        foreach($customWidgets as $cw){
            if(dirname($cw['file'])!='.'){
                $styleDir=get_option('widgetdir') . dirname($cw[file]).'/css/';
                $cdir = scandir($styleDir);
               foreach($cdir as $index){
                   $info = new SplFileInfo($index);
                    if (is_dir($dir) == FALSE && $info->getExtension() == 'css') {
                        $styleFile= $styleDir . $index;
                        $fileContent= file_get_contents($styleFile);
                        if($lastfile!=$styleFile){
                            
                        file_put_contents($mainStyleFile,$fileContent,FILE_APPEND);
                        $lastfile=$styleFile;
                        }else{
                            continue;
                        }
                    }
               }
            }
            }
        }
    }
