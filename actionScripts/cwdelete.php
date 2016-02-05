<?php
/*
 * cedelete action script for Wordpress Widget Manager plugin
 * Handles the deletion custom widgets
 * For more information check out: http://JasonDarkX2.com/ 
*/ 
$w=$_GET['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
  $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$wdir=get_option('widgetdir');
chmod($wdir,777);
if(file_exists($wdir .'/' .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     $del= $wdir . '/' . $toDel[0];
if(is_dir($del)===TRUE){
 $objects = scandir($del);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($del."/".$object) == "dir") recursiveRemove($del."/".$object); else unlink($del."/".$object);
       }
     }
     rmdir($del);
}else{
unlink($wdir . '/' . $custwid[$widgetid]['file']);
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