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
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
