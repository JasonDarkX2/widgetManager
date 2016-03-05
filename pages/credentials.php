<?php

/*
Plugin Name: Filesystem API
Plugin URI: http://www.JasonDarkX2.com
Description: A sample plugin to demonstrate Filesystem API
Version: 1.0
Author: JasondarkX2
 * 
*/
?>
      <div class="wrap">
         <h1>Demo</h1>
         <form method="post">
          <?php
            $output = "";

            if(isset($_POST["file-data"]))
            {
              $output = write_file_demo($_POST["file-data"]);
            }
            else
            {
              $output = read_file_demo();
            }

            if(!is_wp_error($output))
            {
            	?>
            		<textarea name="file-data"><?php echo $output; ?></textarea>
		          	<?php wp_nonce_field("filesystem-nonce"); ?>
		          	<br>
		          	<input type="submit">
            	<?php
            }
            else
            {
              echo $output->get_error_message();
            }
          ?>
         </form>
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
  if(!WP_Filesystem($credentials)) 
  {
    request_filesystem_credentials($url, $method, true, $context);
    return false;
  }

  return true;
}

function write_file_demo($text)
{
  global $wp_filesystem;

  $url = wp_nonce_url("options-general.php?page=demo", "filesystem-nonce");
  $form_fields = array("file-data");

  if(connect_fs($url, "", get_option('widgetdir'), $form_fields))
  {
    $dir = $wp_filesystem->find_folder(get_option('widgetdir'));
    $file = trailingslashit($dir) . "testwidget.php";
    $wp_filesystem->put_contents($file, $text, FS_CHMOD_FILE);

    return $text;
  }
  else
  {
    return new WP_Error("filesystem_error", "Cannot initialize filesystem");
  }
}

function read_file_demo()
{
  global $wp_filesystem;

  $url = wp_nonce_url("options-general.php?page=demo", "filesystem-nonce");

  if(connect_fs($url, "", WP_PLUGIN_DIR . "/filesystem/filesystem-demo"))
  {
    $dir = $wp_filesystem->find_folder(WP_PLUGIN_DIR . "/filesystem/filesystem-demo");
    $file = trailingslashit($dir) . "demo.txt";

    if($wp_filesystem->exists($file))
    {
      $text = $wp_filesystem->get_contents($file);
      if(!$text)
      {
        return "";
      }
      else
      {
        return $text;
      }
    } 
    else
    {
      return new WP_Error("filesystem_error", "File doesn't exist");      
    } 
  }
  else
  {
    return new WP_Error("filesystem_error", "Cannot initialize filesystem");
  }
}