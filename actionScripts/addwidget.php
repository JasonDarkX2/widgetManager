<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
//$target_dir =plugin_dir_path( __FILE__ ).'custom-widgets/';
 $target_dir=plugin_dir_path(dirname(__FILE__)) . 'custom-widgets/';
 $target_file = $target_dir . basename($_FILES["widgetToUpload"]['name']);
if(!empty($_FILES)){
    $info = new SplFileInfo($_FILES["widgetToUpload"]["name"]);
$upload = 1;
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $upload = 0;
}
if ($upload == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if($info->getExtension()==='zip'){
    $upload=0;
    $zip = new ZipArchive;
$res = $zip->open($_FILES["widgetToUpload"]["tmp_name"]);
if ($res === TRUE) {
    if($zip->numFiles>=1){
    for( $i = 0; $i < $zip->numFiles; $i++ ){ 
    $stat = $zip->statIndex( $i ); 
    $target_file= $target_dir.  $stat['name']; 
}

    }
     $zip->extractTo($target_dir);
      $zip->close();
      $wid=getWidgetClass($stat['name']);
      add_new($target_file,$wid,$stat['name']);
} else {
        echo "Sorry, there was an error uploading your file.";
    }
}
else{
    $target_file = $target_dir . basename($_FILES["widgetToUpload"]['name']);
    if (move_uploaded_file($_FILES["widgetToUpload"]["tmp_name"], $target_file)) {
        $wid=getWidgetClass($_FILES["widgetToUpload"]["name"]);
        echo "The file ". basename( $_FILES["widgetToUpload"]["name"]). " has been uploaded.";
        $wid=getWidgetClass($_FILES["widgetToUpload"]["name"]);
        add_new($target_file,$wid,  basename( $_FILES["widgetToUpload"]["name"]));
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
}
function add_new($target_file,$wid,$file){
     $cust=get_option('custom-widget');
            include($target_file); 
        register_widget($wid);
if(empty($cust)==TRUE){
                      $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'file'=>$file,'status' => true);
                 }else{
                     if(array_key_exists($wid,$cust)==FALSE){
                array_push($cust, $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'file'=>$file,'status' => true));
                 array_pop($cust);
                     }
                 }
                  update_option('custom-widget',$cust);
}
