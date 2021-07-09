<?php

/* 
 WidgetManager settings model class maintains the setting options of plugin
 */

class WmSettings{
    public function __construct() {
    
    }
    function setPresetOptions($presets){
    foreach ($presets as $p) {
        $option = 'preset-' . $p;
        update_option($option, FALSE);
        if (isset($_POST[$p])) {
            update_option($option, TRUE);
        } else {
            $v = false;
            update_option($option, FALSE);
        }
    }
    }

}