<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$dir=$_POST['dir'];
if($dir!=NULL){
    if(file_exists($dir)==FALSE){
        mkdir($dir,0755);
    }
        $sdir=get_option('widgetdir');
        $contents=scandir($sdir);
        if(SUBSTR($dir, -1) != '/'){$dir.= '/';}
        foreach($contents as $widgets){
            if ($widgets != "." && $widgets != "..") {
                if(recurse_copy($sdir . $widgets, $dir . $widgets)){
                   recursiveRemove($sdir . $widgets); 
                }
            }
        }
update_option('widgetdir',$dir);
}else{
    $default=dirname(plugin_dir_path(__FILE__)). '/custom-widgets/';
    update_option('widgetdir',$default);
}


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