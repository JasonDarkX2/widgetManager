<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$dir=$_POST['dir'];
if(empty($dir)){
    $dir=dirname(plugin_dir_path(__FILE__)). '/custom-widgets/';
}
    if(file_exists($dir)==FALSE){
        mkdir($dir,0755);
        $user=exec(whoami);
        chown($dir, $user);
    }
        $sdir=get_option('widgetdir');
        If(file_exists($sdir)){
        $contents=scandir($sdir);
        if(SUBSTR($dir, -1) != '/'){$dir.= '/';}
        foreach($contents as $widgets){
            if ($widgets != "." && $widgets != "..") {
                recurse_copy($sdir . $widgets, $dir . $widgets);
            }
        }
        recursiveRemove($sdir);
        echo '<div class="notfi"><strong>Widget Directory Successfully updated</strong></div>';
    }
update_option('widgetdir',$dir);


function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

function recursiveRemove($dir)
{
    foreach(glob("{$dir}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemove($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dir);
}