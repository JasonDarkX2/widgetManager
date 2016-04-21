<?php

/*
 * Credentials page for Wordpress Widget Manager plugin
 * Handles the WP_filesystem functionality of the plugin
 * Also handles the  Adding and deletion of widgets
 * For more information check out: http://JasonDarkX2.com/ 
*/
?>
<div class="wrap">      
                <?php
                if(isset($_POST['op'])){
                $op=$_POST['op'];
                }else{
                    $op=$_GET['op'];
                }
 
                switch($op){
                  case 'add':
                      if(isset($_POST['ufile'])==FALSE)
                  $output=add_widget();
                      break;
                  case 'del':
                      echo '<form method="post">';
              delete_widget();
              echo '</form>';
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
  if(!WP_Filesystem($credentials)||$_POST['password']==NULL) 
  {
    request_filesystem_credentials($url, $method, true, $context);
    return false;
  }

  return true;
}
  function delete_widget()
{

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
      display_msg($wp_filesystem->rmdir($del,true),TRUE);
      header('Location: '. menu_page_url( 'cwop' ) .'&del=true');
      session_start();
      $_SESSION['deletion']=display_msg($wp_filesystem->rmdir($del,true),TRUE);
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
  
  $dest=wp_upload_dir();
  var_dump($name);
  if($name!=null){
        $destination=$dest['basedir'] . '/' . $name;
  move_uploaded_file($tmp, $destination);
  $file=str_replace('//', '/', str_replace('\\', '/',$destination));
  $_POST['file']=$file;
  $form_fields=array('file');
  }
if(connect_fs('', "POST", get_option('widgetdir'), $form_fields)){
//$creds=$credentials = request_filesystem_credentials('', 'POST', false, $context, $fields);
//if($creds!=NULL){
//if(WP_Filesystem($creds)==true){
    var_dump($_POST);
$destination=get_option('widgetdir');
$file=$_POST['file'];
      $unzip=unzip_file($file,$destination);
      if(is_wp_error($unzip)){
          echo ' <div class="errorNotfi">'. $unzip->get_error_message() .'</div>';
      }
      unlink($file);
//}
}
      /*$destination=get_option('widgetdir');
       //$zip = new ZipArchive;
       //$unzip=$zip->open($file);
      if($unzip==TRUE){
         //$zip->extractTo($destination);
         //$zip->close();
         //var_dump($file);
        //unlink($file);
      }
              display_msg($unzip,FALSE);*/
}
 function display_msg($output,$del){
     if($del){
         $msgType="Deleted";
     }
      if($output==true){
              return '<div class="notfi">Successfully '. $msgType .' </div>';
}
 else if(is_wp_error($output) && $output!=NULL){ ?>
    <div class="errorNotfi"><?php $output->get_error_message(); ?></div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
<?php } else{?>
 <div class="errorNotfi"> Unable to perform action</div>
             <div><a href="<?php menu_page_url('cwop')?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM')?>">Return to Widgets Manager</a></div>
<?php }
  }
