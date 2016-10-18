<?php

/**
  controller for Wordpress Widget Manager
 * handles loading and unregistering  of widgets  
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'model/theWidget.php';

class WidgetController {

    static $theWidget;
    static $newWidgetList;

    function __construct() {
        self::$theWidget = new theWidget();
    }
/**
 * Simply load default widgets into the widgetid plugin option.
 */
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
/**
 * Simply load plugin type widgets into the widgetid plugin option.
 */
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
/**
 * Simply removes non existing  plugin widgets index from widgetid option.
 */
    function obsolete_pluginWidgets() {
         $customWidgets=get_option('custom-widget');
        $widgets = $GLOBALS['wp_widget_factory']->widgets;
        $widgetList = get_option('widgetid');
        foreach ($widgetList as $w) {
            if (!preg_match_all("/Default|Custom/",$w['type'])) {
                if (!array_key_exists($w['key'], $widgets)) {
                    unset($widgetList[$w['key']]);
                }
                     if (array_key_exists($w['key'], $customWidgets)) {
                    unset($widgetList[$w['key']]);
                }
            }
        }
        update_option('widgetid', $widgetList);
    }
/**
 * Simply unregister  widgets the are plugin type.
 */
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
/**
 * Simply Unregister disabled widgets.
 */
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
/**
 * Simply removes non existing  custom widgets index from widgetid option.
 */
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
/**
 *  functions that loads custom widget classes for back-end and/or front-end
 * @param  boolean $frontEndOnly -  if TRUE only the front-end load is performed
 */
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
    /**
     * Gets custom widgets from widget directory  and adds them into custom-widget plugin option.
     */
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
/**
 * Simply gets custom widgets and adds them into widgetid plugin option
 */
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
   /**
    *  checkes the status of the jnewWidgetList array and returns true if there are new widgets, otherwise false. 
    * @return boolean
    */
    function newWidgets(){
        if(count(self::$newWidgetList)>0){
            return TRUE;
        }  else {
        return FALSE;    
        }
    }
    /**
     *  Process and adds the new widgets to the newWidgetList array 
     * @param string $key contains the index of the new widget
     */
            function addto($key) {
        $w = get_option('widgetid');
        if (!array_key_exists($key, $w)) {
            self::$newWidgetList[$key] = '<li>' . self::$theWidget->get_name($key) . '</li>';
        } else {
            unset($list[$key]);
        }
    }
/**
 * Display a list of new widgets added to widgetManager
 */
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
 /**
  * Creates and compiles custom widgets css/js files into their respective single main files.
  *
  * @param type $customWidgets
  * @return  array  containing file sizes
  */  
function createWidgetResource($customWidgets){
    $dir=get_option('widgetdir');
    $mainStyleFile = plugin_dir_path(dirname(__FILE__)) . '/_inc/cwidgets.css';
    $mainScriptFile = plugin_dir_path(dirname(__FILE__)) . '/_inc/cwidgets.js';
        file_put_contents($mainStyleFile, '');
        file_put_contents($mainScriptFile, '');
        //get custom widgets css and js  directorties
        $resourceDir=[];
        foreach ($customWidgets as $cw) {
            if (dirname($cw['file']) != '.') {
                array_push($resourceDir, $dir . dirname($cw['file']) . '/css/');
                array_push($resourceDir, $dir . dirname($cw['file']) . '/js/');
            }else{
                continue;
            }
        }
        //get js and css files and  compile them into repective main files
        foreach ($resourceDir as $dirIndex) {
            if (file_exists($dirIndex)) {
              $resourceFiles = scandir($dirIndex);
                foreach ($resourceFiles as $fileIndex) {
                    $info = new SplFileInfo($fileIndex);
                    //write to css main file
                     if (is_dir($info) == FALSE && $info->getExtension() == 'css') {
                         $theFile = $dirIndex . $fileIndex;
                         $fileContent = file_get_contents($theFile);
                        $fileContent=preg_replace('/\/.*\n/', '', $fileContent); //remove comments
                        $fileContent=  trim(preg_replace('/\s\s+/', ' ', $fileContent)); //minify file
                         file_put_contents($mainStyleFile, $fileContent, FILE_APPEND);
                     }
                     //write to js main file
                      if (is_dir($info) == FALSE && $info->getExtension() == 'js') {
                         $theFile = $dirIndex . $fileIndex;
                         $fileContent = file_get_contents($theFile);
                         $fileContent=preg_replace('!/\*.*?\*/!s', '', $fileContent); //remove comments
                         $fileContent=  trim(preg_replace('/\s\s+/', ' ', $fileContent)); //minify file
                         file_put_contents($mainScriptFile, $fileContent, FILE_APPEND);
                     }
                     
                }
            }
                        }
       
       $fileSizes=[
           'css'=> filesize($mainStyleFile),
           'js' => filesize($mainScriptFile),            
        ];
       return $fileSizes;
}
}
