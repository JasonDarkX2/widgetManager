<?php

/* 
 * setting controller manages options requests for widget manager  
 */

$w = $_POST['wpdir'];
$parse_uri = explode($w, $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$dir = $_POST['dir'];
$presets = $_POST['preset'];