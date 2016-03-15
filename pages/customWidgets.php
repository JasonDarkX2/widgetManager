<?php
/*
 *customWidgets page for Wordpress Widget Manager plugin
 * Handles the displaying of custom widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
*/
?>
<form>
<div id="dialog" hidden="true">
  <p>Add or Import your Custom widgets below.... </p>
  <form id="addWidget" method="POST" action="<?php echo plugins_url('actionScripts/addwidget.php',__FILE__); ?>" enctype= "multipart/form-data">
  <input type="file" name="widgetToUpload" id="widgetToUpload" accept=".php,.zip">
  <input type="hidden" id="wpdir" name="wpdir" value="<?php echo basename(content_url());?>" />
  </form>
  </div>
</form>
    <h2><strong>Custom Widgets Option</strong></h2>
    <?php permissionChecker();?>
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
        <td><a class="deleteWid" href="<?php menu_page_url( 'credentials' ); //for reference->plugins_url('actionScripts/cwdelete.php', dirname(__FILE__)) ; ?>?w=<?php echo$c['key']; ?>&wpdir=<?php echo basename(content_url());?>" title="delete <?php echo$c['name']; ?>">Delete Widget</a></td>
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
