<?php

/*
Plugin Name: Wordpress widget manager
Plugin URI: http://www.JasonDarkX2.com
Description: An action handeler page for widget manager
Version: 1.0
Author: JasondarkX2
 */ 
$op=$_GET['op'];
switch($op){
    case 'add':
        add_widget();
        break;
    case 'del':
        delete_widget();
        break;
    
}

function add_widget()
{
    $here='yup';
$file=$_POST['file'];
$destination=get_option('widgetdir');
      global $wp_filesystem;
      $destination=get_option('widgetdir');
      $unzip=unzip_file($file,$destination);
      $here='here';
      if($unzip==TRUE){
          unlink($file);
      }
      display_msg($unzip);
  }
  function delete_widget(){
            //deletion  process
    global $wp_filesystem;
      $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_POST['w'];
$wdir=get_option('widgetdir');
if(file_exists($wdir .'/' .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     echo $del= $wdir . $toDel[0];
     $wp_filesystem->rmdir($del,true);
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