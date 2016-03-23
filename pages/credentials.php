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
                  add_widget();
                      break;
                  case 'del':
              delete_widget();
                  break;
              }
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
 $action=menu_page_url( 'action',FALSE ) .'&op=del';
  $url = wp_nonce_url($action, "filesystem-nonce");
  $_POST['wpdir']=$_GET['wpdir'];
  $_POST['w']=$_GET['w'];
  $form_fields = array('wpdir','w');
  if(connect_fs($url, "POST", get_option('widgetdir'), $form_fields))
  {
      //deletion  process
    /*global $wp_filesystem;
      $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_GET['w'];
$wdir=get_option('widgetdir');
if(file_exists($wdir .'/' .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     $del= $wdir . $toDel[0];
     $wp_filesystem->rmdir($del,true);
}*/
  }else{ 
  }
}
function add_widget()
{
  $action=menu_page_url( 'action',FALSE ) .'&op=add';
  $url = wp_nonce_url($action, "filesystem-nonce");
  $_POST['wpdir']=$_GET['wpdir'];
  $_POST['w']=$_GET['w'];
  $name=$_FILES["widgetToUpload"]['name'];
  $tmp=$_FILES['widgetToUpload']["tmp_name"];
  if($file==NULL){
  $upload=wp_upload_bits($name,NULL,$tmp);
  $file=$upload['file'];
  $_POST['file']=$file;
$form_fields=array('file');
  }
  if(connect_fs($url, "POST", get_option('widgetdir'), $form_fields))
  {   
  }
}
