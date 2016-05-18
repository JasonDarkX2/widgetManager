<?php
/*
 *setting action script for Wordpress Widget Manager plugin
 * Handles the settings option of plugin. The preset options, changing widget upload directory
 * For more information check out: http://JasonDarkX2.com/ 
*/
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$dir= $_POST['dir'];
$error=false;
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
    
}
if(empty($dir)|| get_option('preset-cdwd')){
    $dir=dirname(plugin_dir_path(__FILE__)). '/custom-widgets/';
    $dirchange=TRUE;
}
$dir= str_replace('//', '/', str_replace('\\', '/',$dir));
 $wpdir= str_replace('//', '/', str_replace('\\', '/',wp_upload_dir()));
 $plugindir= str_replace('//', '/', str_replace('\\', '/', dirname(plugin_dir_path(__FILE__))));
if(strstr($dir, $plugindir)==FALSE){
    $error=TRUE;
    $errmsg=" ERROR-Custom Widget Directory must be within Wordpress manager plugin directory. The default had been set instead of ".
            $dir .
            '<br/>';
    $dir=dirname(plugin_dir_path(__FILE__)). '/custom-widgets/';
$dirchange=TRUE;
    
}

    $dirchange=TRUE;
$dir= str_replace('//', '/', str_replace('\\', '/', $dir));
    if(file_exists($dir)==FALSE){
        $dirDiff=true;
        mkdir($dir,0755);
        $user=exec(whoami);
        chown($dir, $user);
        $proceed=true;
    }
    if($proceed){
        $sdir=get_option('widgetdir');
        If(file_exists($sdir)){
            $sdir= str_replace('//', '/', str_replace('\\', '/', $sdir));
            if(strcmp($sdir,$wpdir['basedir'])!=0){
        $contents=scandir($sdir);
        if(SUBSTR($dir, -1) != '/'){$dir.= '/';}
        foreach($contents as $widgets){
            if ($widgets != "." && $widgets != "..") {            
               recurse_copy($sdir , $dir);
            }
        }
        
        if($sdir!=$dir){
        $check=recursiveRemove($sdir);
        }
            }
    }
    }
    msgDisplay( $error, $errmsg, $dirchange, $dirDiff);
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
     $check=rmdir($dir);
     return $check;
}

function msgDisplay( $error, $errmsg, $dirChange, $dirDiff){
    if($error==FALSE){
        if($dirChange && $dirDiff){
        echo '<br/> <div class="notfi"><strong>Widget upload directory Successfully changed</strong></div>';
        }
        else{
        echo '<div class="notfi"><strong>Settings Successfully Saved</strong></div>';
        }
        
    }else{?>
<div class="errorNotfi"> <?php echo $errmsg;?><div>    
        <?php }
    }
      
