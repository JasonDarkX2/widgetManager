<?php

/*
 * action script for Wordpress Widget Manager plugin
 * Currently obsolete, pending deletion
 * For more information check out: http://JasonDarkX2.com/ 
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
     echo "here";
    $file=$_POST['ufile'];
    chmod($file,0777);
    var_dump($file);
    global $wp_filesystem;
    $destination=get_option('widgetdir');
      $unzip=unzip_file($file,$destination);
      var_dump($unzip);
      if(is_wp_error( $unzip )){
          echo' <div class="errorNotfi>' . $unzip->get_error_message() .'</div>';
      }
      unlink($file);
      
      }
  function delete_widget(){
            //deletion  process
    global $wp_filesystem;
    $args=array($_POST['hostname'],$_POST['username'], $_POST['password'],$_POST['conntection_type']);
      $custwid= get_option('custom-widget');
  $widgets= get_option('widgetid');
$widgetid=$_POST['w'];
$wdir=get_option('widgetdir');
if(file_exists($wdir .'/' .$custwid[$widgetid]['file'])===TRUE){
     $toDel=explode("/",$custwid[$widgetid]['file']);
     echo $del= $wdir . $toDel[0];
     $result=$wp_filesystem->rmdir($del,true);
     display_msg($result);
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