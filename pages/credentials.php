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
         <form method="post">
          <?php
            $output = true;
              $output = delete_widget();
if(is_wp_error($output)!=TRUE && $output!=NULL)
            {?>
             <h1><?php var_dump($output);?></h1>
<?php }?>
         </form>
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
    //include(plugin_dir_path( dirname(__FILE__) ) . '/actionScripts/cwdelete.php');
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
     echo $del;
     var_dump($wp_filesystem);
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
      $unzip=unzip_file($file,$destination);
      if($unzip==TRUE){
          unlink($file);
          
          return true;
      }
      else{
          return false;
      }

}
  }
