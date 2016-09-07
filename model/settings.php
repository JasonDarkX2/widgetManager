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
            $v = true;
            update_option($option, $v);
        } else {
            $v = false;
            update_option($option, $v);
        }
    }
    }
    function changeWidgetDir($dir){
        if (empty($dir) || get_option('preset-cdwd') ||get_option('widgetdir') =='/') {
    $dir = dirname(plugin_dir_path(__FILE__)) . '/custom-widgets/';
    $dirchange = TRUE;
}
$dir = str_replace('//', '/', str_replace('\\', '/', $dir));
$wpdir = str_replace('//', '/', str_replace('\\', '/', wp_upload_dir()));
$plugindir = str_replace('//', '/', str_replace('\\', '/', dirname(plugin_dir_path(__FILE__))));
if (WPWM_DEBUG == 1) {
$error = TRUE;
    $errmsg= "Debug Mode enabled, unrestricted  directory changes permitted"; 
}
else if (strstr($dir, $plugindir) == FALSE) {
    $error = TRUE;
    $errmsg = " ERROR-Custom Widget Directory must be within Wordpress manager plugin directory. The default had been set instead of " .
            $dir .
            '<br/>';
    $dir = dirname(plugin_dir_path(__FILE__)) . '/custom-widgets/';
    $dirchange = TRUE;
}

$dirchange = TRUE;
$dir = str_replace('//', '/', str_replace('\\', '/', $dir));
if (file_exists($dir) == FALSE) {
    $dirDiff = true;
    mkdir($dir, 0755);
    $user = exec(whoami);
    chown($dir, $user);
    $proceed = true;
}
if ($proceed) {
    $sdir = get_option('widgetdir');
    If (file_exists($sdir)) {
        $sdir = str_replace('//', '/', str_replace('\\', '/', $sdir));
        if (strcmp($sdir, $wpdir['basedir']) != 0) {
            $contents = scandir($sdir);
            if (SUBSTR($dir, -1) != '/') {
                $dir.= '/';
            }
            foreach ($contents as $widgets) {
                if ($widgets != "." && $widgets != "..") {
                    self::recurse_copy($sdir, $dir);
                }
            }

            if ($sdir != $dir) {
                $check = self::recursiveRemove($sdir);
            }
        }
    }
    }
msgDisplay($error, $errmsg, $dirchange, $dirDiff);
update_option('widgetdir', $dir);
    
            }
}

function recursiveRemove($dir) {
    foreach (glob("{$dir}/*") as $file) {
        if (is_dir($file)) {
            recursiveRemove($file);
        } else {
            unlink($file);
        }
    }
    $check = rmdir($dir);
    return $check;
}
function recurse_copy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
function msgDisplay($error, $errmsg, $dirChange, $dirDiff) {
    if ($error == FALSE) {
        if ($dirChange && $dirDiff) {
            echo '<br/> <div class="notfi"><strong>Widget upload directory Successfully changed</strong></div>';
        } else {
            echo '<div class="notfi"><strong>Settings Successfully Saved</strong></div>';
        }
    } else {
        ?>
        <div class="errorNotfi"> <?php echo $errmsg; ?><div>    
                <?php
            }
        }
?>