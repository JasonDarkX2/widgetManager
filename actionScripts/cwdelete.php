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
  $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$dir=get_option('widgetdir');
chmod($dir,755);
if(file_exists($dir .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     $del= $dir. $toDel[0];
if(is_dir($del)===TRUE){
 $objects = scandir($del);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($del."/".$object) == "dir") recursiveRemove($del."/".$object); else unlink($del."/".$object);
       }
     }
     rmdir($del);
}else{
unlink($dir .$custwid[$widgetid]['file']);
}
}
unset($custwid[$widgetid]);
unset($widgets[$widgetid]);
update_option('custom-widget', $custwid);
update_option('widgetid', $widgets);
echo '<div class="notfi">deleted '. $widgetid .'</div>';

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