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
            ///$output = true;
            if(isset($_POST['file'])==FALSE){?>
                <form method="post">
              <?php switch($_GET['op']){
                  case 'add':
                  $output = add_widget();
                      break;
              case'del':
              $output = delete_widget();
                  break;
              }
              ?>
              </form>
            <?php}
if(is_wp_error($output)!=TRUE && $output!=NULL)
            {?>
<?php }
if($output==true){?>
             <div class="notfi">successfully extracted...</div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
    
<?php }
if($output==FALSE && $output!=NULL){ ?>
    <div class="notfi">unsuccessfully extracted...</div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
<?php }
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
  if(!WP_Filesystem($credentials)) 
  {
    request_filesystem_credentials($url, $method, true, $context);
    return false;
  }

  return true;
}
  function delete_widget()
{
  $url = wp_nonce_url(plugins_url('actionScripts/cwdelete.php', dirname(__FILE__)), "filesystem-nonce");
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
     if($wp_filesystem->rmdir($del,true)){
         return true;
     }  else {
     return false;    
     }

}
  }
}

 function add_widget()
{
  $url = wp_nonce_url(plugins_url('actionScripts/addwidget.php', dirname(__FILE__)), "filesystem-nonce");
  $_POST['wpdir']=$_GET['wpdir'];
  $_POST['w']=$_GET['w'];
  $name=$_FILES["widgetToUpload"]['name'];
  $tmp=$_FILES['widgetToUpload']["tmp_name"];
  $upload=wp_upload_bits($name,NULL,$tmp);
  $file=$upload['file'];
  $_POST['file']=$file;
$form_fields=array('file');
  if(connect_fs($url, "POST", get_option('widgetdir'), $form_fields))
  {   
      global $wp_filesystem;
      $destination=str_replace(ABSPATH,$wp_filesystem->abspath(),get_option('widgetdir'));
      $unzip=_unzip_file($file,$destination);
      if($unzip==TRUE){
          unlink($file);
          return true;
      }
      else{
          return false;
      }

}
  }