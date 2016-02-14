<?php
/*
 *setting action script for Wordpress Widget Manager plugin
 * Handles the settings option of plugin. The preset options, changing widget upload directory
 * For more information check out: http://JasonDarkX2.com/ 
*/
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$dir=$_POST['dir'];
if(substr($dir,-1)!='/'){
    $dir=$dir . '/';
}
$presets=$_POST['preset'];
if(count($presets)>0){
    foreach($presets as $p){
        $option='preset-' . $p;
        update_option($option, FALSE);
        if(isset($_POST[$p])){
            $v=true;
            update_option($option, $v);
        }else{
            $v=false;
            update_option($option, $v);
        }
    }
    echo '<div class="notfi"><strong>Settings Successfully Saved</strong></div>';
}
if(empty($dir)|| get_option('preset-cdwd')){
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
                recurse_copy($sdir , $dir);
            }
        }
        
        if($sdir!= get_option('widgetdir')){
        $check=recursiveRemove($sdir);
        }
        if($dir!=get_option('widgetdir')){
        echo '<br/> <div class="notfi"><strong>Widget upload directory Successfully changed</strong></div>';
        }
        if($check==FALSE && $dir!=get_option('widgetdir')){
            echo '<div class="errorNotfi"><strong> An error occured while changing Widget upload directory please check directory file permissions</strong></div>';
            echo get_option('widgetdir');
        }
    }
update_option('widgetdir',$dir);
 echo '<div class="notfi"><strong>Settings Successfully Saved</strong></div>';

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
    var_dump(debug_backtrace());
    echo $dir;
    foreach(glob("{$dir}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemove($file);
        } else {
            unlink($file);
        }
    }
     $check=rmdir($dir);
     return $check;
}