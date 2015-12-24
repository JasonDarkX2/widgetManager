<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );
$dir=$_POST['dir'];
if($dir!=NULL){
update_option('widgetdir',$dir);
}else{
    $default=plugin_dir_path(__FILE__) . 'custom-widgets/';
    update_option('widgetdir',$default);
}
