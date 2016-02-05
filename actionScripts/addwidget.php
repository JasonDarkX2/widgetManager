<?php
/*
 * Addwidget action script for Wordpress Widget Manager  plugin
 * handles the adding of custom widgets
 * For more information check out: http://JasonDarkX2.com/ 
*/ 
$w=$_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
 $target_dir=  get_option('widgetdir');
 $target_file = $target_dir . '/' . basename($_FILES["widgetToUpload"]['name']);
if(!empty($_FILES)){
    $info = new SplFileInfo($_FILES["widgetToUpload"]["name"]);
$upload = 1;
$errorMsg='<div class="errorNotfi">Sorry, there was an error uploading your file.</div>';
    if($info->getExtension()==='zip'){
    $zip = new ZipArchive;
$res = $zip->open($_FILES["widgetToUpload"]["tmp_name"]);
if ($res === TRUE) {
    if($zip->numFiles>=1){
    for( $i = 0; $i < $zip->numFiles; $i++ ){ 
    $stat = $zip->statIndex( $i ); 
    $target_file= $target_dir . '/' .   $stat['name']; 
}
if (file_exists($target_file)==TRUE) {
    $errorMsg='<div class="errorNotfi">Sorry, file already exists.</div>';
    $upload = 0;
}
    }
}
if($upload==1){
     $zip->extractTo($target_dir);
      $zip->close();
      $wid=getWidgetClass($stat['name']);
      add_new($target_file,$wid,$stat['name']);   
       echo '<div class="notfi"> Extracted the file '. basename( $_FILES["widgetToUpload"]["name"]). " and successfully uploaded " . $stat["name"].".</div>";
} else {
        echo $errorMsg;
    }
}
else{
    if (file_exists($target_file)==TRUE) {
    $errorMsg='<div class="errorNotfi">Sorry, file already exists.</div>';
    $upload = 0;
}
    if($upload==1){
    if (move_uploaded_file($_FILES["widgetToUpload"]["tmp_name"], $target_file)) {
        $wid=getWidgetClass($_FILES["widgetToUpload"]["name"]);
        echo '<div class="notfi">The file '. basename( $_FILES["widgetToUpload"]["name"]). " has been uploaded.</div>";
        $wid=getWidgetClass($_FILES["widgetToUpload"]["name"]);
        add_new($target_file,$wid,  basename( $_FILES["widgetToUpload"]["name"]));
    } 
    }else {
         echo $errorMsg;
    }
}
}
function add_new($target_file,$wid,$file){
     $cust=get_option('custom-widget');
     $wList=get_option('widgetid');
     $status=true;
     if(get_option('preset-cwoff')){
         $status=false;
     }
            include($target_file); 
        register_widget($wid);
if(empty($cust)==TRUE){
                      $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid), 'Description'=>get_description($wid),'file'=>$file,'status' => $status);
                 }else{
                     if(array_key_exists($wid,$cust)==FALSE){
                array_push($cust, $cust[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'file'=>$file,'status' => true));
                 array_pop($cust);
                     }
                 }
                 if(array_key_exists($wid,$wList)==FALSE){
                      array_push($wList, $wList[$wid]=array('key'=>$wid,'class'=>$wid,'name'=> get_name($wid),'Description'=>get_description($wid), 'type'=>'Custom','status' => $status));
                      array_pop($wList);
                 }
                  update_option('widgetid', $wList);
                  update_option('custom-widget',$cust);
}
