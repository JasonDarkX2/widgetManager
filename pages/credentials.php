<?php

/*
Plugin Name: credentials
Plugin URI: http://www.JasonDarkX2.com
Description: A credential handeler for widget manager
Version: 1.0
Author: JasondarkX2
 * 
*/
?>
<div class="wrap">      
                <?php
                $op=$_GET['op'];
 
                switch($op){
                  case 'add':
                     //echo '<form method="post">';
                      if(isset($_POST['ufile'])==FALSE)
                  $output=add_widget();
                  //echo'</form>';
                      break;
                  case 'del':
                      echo '<form method="post">';
              delete_widget();
              echo '</form>';
                  break;
              }
              ///display_msg($output);
              ?>
</div>
<?php
function connect_fs($url, $method, $context, $fields = null)
{
  global $wp_filesystem;
  if(false === ($credentials = request_filesystem_credentials($url, $method, false, $context, $fields))) 
  {
    return false;
  }

  //check if credentials are correct or not.
  if(!WP_Filesystem($credentials)||$_POST['password']==NULL) 
  {
    request_filesystem_credentials($url, $method, true, $context);
    return false;
  }

  return true;
}
  function delete_widget()
{
 $action=menu_page_url( 'action',FALSE ) .'&op=del';
  $url = wp_nonce_url($action, "filesystem-nonce");
  $_POST['wpdir']=$_GET['wpdir'];
  $_POST['w']=$_GET['w'];
  $form_fields = array('wpdir','w');
  if(connect_fs($url, "POST", get_option('widgetdir'), $form_fields))
  {
      //deletion  process
    global $wp_filesystem;
      $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$wdir=get_option('widgetdir');
if(file_exists($wdir .'/' .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     $del= $wdir . $toDel[0];
     $wp_filesystem->rmdir($del,true);
}
  }else{ 
  }
}
function add_widget()
{
    
  $action=menu_page_url( 'action',FALSE ) .'&op=add';
  $url = wp_nonce_url($action, "filesystem-nonce");
  $name=$_FILES["widgetToUpload"]['name'];
  $tmp=$_FILES['widgetToUpload']["tmp_name"];
  $upload=wp_upload_bits($name,NULL,$tmp);
  $file=str_replace('//', '/', str_replace('\\', '/',$upload['file']));
  $_POST['ufile']=$file;
$form_fields=array('ufile');

  if(connect_fs($url, "POST", get_option('widgetdir'), $form_fields))
  {
      $destination=get_option('widgetdir');
      global $wp_filesystem;
      $destination=get_option('widgetdir');
      $unzip=unzip_file($file,$destination);
      if($unzip==TRUE){
          unlink($file);
          return  $unzip;
      }
      else{
          return $unzip;
      }
  }
}
 function display_msg($output){
      if($output==true){?>
             <div class="notfi">successfully extracted...</div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
    
<?php }
 else if(is_wp_error($output) && $output!=NULL){ ?>
    <div class="errorNotfi"><?php $output->get_error_message(); ?></div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
<?php } else{?>
 <div class="errorNotfi"> Unable to perform action</div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
<?php }
  }
