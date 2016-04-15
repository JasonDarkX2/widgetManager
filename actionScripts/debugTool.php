<?php
/*
 * debugTools action script for Wordpress Widget Manager plugin
 * Handles the debug section of the plugin providing quick options to easily debug without hard coding them in the back end  
 * For more information check out: http://JasonDarkX2.com/ 
*/
$option=$_GET['op'];
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
if($option=='cw'){
    echo "custom";
 update_option('custom-widget', "");
}
else{
    echo "All";
  update_option('widgetid', "");  
}

function permissionChecker($status=FALSE){
 $dir=get_option('widgetdir');
$pdir= plugin_dir_path( __FILE__);
 $user=exec(whoami);
 $errors =array();
 
 error_reporting(0);
 if(function_exists('posix_getpwuid')){
 $dirOwner=posix_getpwuid(fileowner($dir));
 if($user!=$dirOwner['name']){
     array_push($errors,'<li>Problem with widget directory ownership:<br/> '
     .  'please change file owner to <strong>'. $user . '</strong> for <strong>' . $dir 
             . '</strong></br>You can use the following command:<br/><strong>sudo chown '. $user . ' '. $dir .'</strong></li>');
 }
 $pdirOwner=posix_getpwuid(fileowner($pdir));
  if($user!=$pdirOwner['name']){
     array_push($errors,'<li>Problem with the  plugin directory ownership:<br/>'
     .  'please change  directory owner to <strong>'. $user . '</strong> for <strong>' . $pdir 
             . '</strong></br>You can use the following command:<br/><strong>sudo chown '. $user . ' '. $pdir .'</strong></li>');
 }
 if(substr(sprintf('%o', fileperms($dir)), -4) !='0755'){
     array_push($errors,'<li>Problem with widget upload directory permissions:<br/>'  
     .  'please change  directory permission to <strong>'.'755' . '</strong> for <strong>' . $dir 
             . '</strong></br>You can use the following command:<br/><strong>sudo chmod '. '755' . ' '. $dir .'</strong></li>');
 }
 if(substr(sprintf('%o', fileperms($pdir)), -4) !='0755'){
     array_push($errors,'<li>Problem with the plugin directory permissions:<br/> '
     .  'please change  directory permission to <strong>'.'755' . '</strong> for <strong>' . $dir 
             . '</strong></br>You can use the following command:<br/><strong>sudo chmod '. '755' . ' '. $pdir .'</strong></li>');
 }
 if(count($errors)>0&& $status!=TRUE){
 echo '<div class="errorNotfi"><ul>';
 foreach ($errors as $msg){
     echo $msg;
 }
 echo '</ul></div>';
 }else{
     if(count($errors)>0)
     return false;
     else
         return true;
 }
}
}