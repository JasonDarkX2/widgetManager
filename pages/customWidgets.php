<?php
/*
 *customWidgets page for Wordpress Widget Manager plugin
 * Handles the displaying of custom widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
*/
    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
    empty_names();
    $custwid= get_option('custom-widget')?>
<form>
<div id="dialog" hidden="true">
<?php read_file_test();
if(!is_wp_error($output))
            {?>
  <p>Add or Import your Custom widgets below.... </p>
  <form id="addWidget" method="POST" action="<?php echo plugins_url('actionScripts/addwidget.php',__FILE__); ?>" enctype= "multipart/form-data">
  <input type="file" name="widgetToUpload" id="widgetToUpload" accept=".php,.zip">
  <input type="hidden" id="wpdir" name="wpdir" value="<?php echo basename(content_url());?>" />
  </form>
     <?php }?>
  </div>
</form>
    <h2><strong>Custom Widgets Option</strong></h2>
    <?php permissionChecker(); ?>
    <table border="1px;"><tr><th>Custom Widgets</th><th>filename</th><th>Register Custom Widget</th><th>UnRegister Custom Widget</th><th>Extra options</th></tr>
        <form id="settingsop" method="POST" action="<?php echo plugins_url('actionScripts/customWidgetOptions.php', dirname(__FILE__)) ; ?>">
            <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
    <?php 
    if($custwid==''|| empty($custwid)){
        
    }else{
    foreach($custwid as $c):?>
    <tr>
        <?php if(getWidgetClass($c['file'])!=''):?>
        <td><?php echo $c['name'];?></td><td><?php echo $c['file']; ?></td>
        <td>
            <input type='hidden' name='customWidget[]' value='<?php echo  $c['key'] ?>' id='customWidget'> 
            <input type="radio" name="<?php echo$c['key'];?>" <?php checked(1,$c['status'] ); ?> value="true"></td>
        <td><input type="radio" name="<?php echo $c['key'];?>" <?php checked('',$c['status'] ); ?> value="false"></td>
        <td><a class="deleteWid" href="<?php echo plugins_url('actionScripts/cwdelete.php', dirname(__FILE__)) ; ?>?w=<?php echo$c['key']; ?>&wpdir=<?php echo basename(content_url());?>" title="delete <?php echo$c['name']; ?>">Delete Widget</a></td>
      <?php endif;?>
    </tr>
    <?php endforeach; }?>
    <tr><td colspan="5"><a href="#"> Get more Custom Widgets</a>|<a href="#" id="addWidget"> Add/import new Custom Widgets</a></td></tr>
    </table>
    <p id="msg">
       <?php if($custwid==''|| empty($custwid)){
        echo '<div class="errorNotfi"> No custom widgets Found!</div>';
    }?>
    </p>
    <?php if(count($custwid)>0):?>
    <?php if(permissionChecker(true)) :?>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    <?php else:?>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" disabled="true">
    <?php endif;?>
    <?php endif;?>
    </form> 
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
        function read_file_test()
{
  global $wp_filesystem;

  $url = wp_nonce_url("options-general.php?page=demo", "filesystem-nonce");

  if(connect_fs($url, "", get_option('widgetdir')))
  {
    $dir = $wp_filesystem->find_folder(get_option('widgetdir'));
    $file = trailingslashit($dir) . "testwidget.php";

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
?>