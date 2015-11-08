<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$target_dir =plugin_dir_path( __FILE__ ).'custom-widgets/';
//echo $target_dir;
echo $_FILES['widgetToUpload']['name'];
if(!empty($_FILES)){
    
    $target_file = $target_dir . basename($_FILES["widgetToUpload"]['name']);
    $info = new SplFileInfo('foo.zip');
$upload = 1;
if($info->getExtension()==='zip'){
    $upload=0;
    echo 'its a zip';
}
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $upload = 0;
}
if ($upload == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["widgetToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["widgetToUpload"]["name"]). " has been uploaded.";
        $cust=get_option('custom-widget');
        include($target_file); 
        $wid=getWidgetClass($_FILES["widgetToUpload"]["name"]);
        register_widget($wid);
if(empty($cust)==TRUE){
                      $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'file'=>$_FILES["widgetToUpload"]["name"],'status' => true);
                 }else{
                     if(array_key_exists($wid,$cust)==FALSE){
                array_push($cust, $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'file'=>$_FILES["widgetToUpload"]["name"],'status' => true));
                 array_pop($cust);
                     }
                 }
                  update_option('custom-widget',$cust);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
if(empty($_FILES)){
    echo '200';
}
