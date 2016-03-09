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
<?php
delete_file();
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
  function delete_file()
{
  global $wp_filesystem;

  $url = wp_nonce_url(plugins_url('actionScripts/customWidgetOptions.php', dirname(__FILE__)), "filesystem-nonce");
  $form_fields = array("wpdir");
  if(connect_fs($url, "GET", get_option('widgetdir'), $form_fields))
  {
      echo"Hello There!";
  }
}