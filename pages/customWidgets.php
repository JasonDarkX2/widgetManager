  
<?php 
    $dir=plugin_dir_path( __FILE__ ).'/custom-widgets';
    empty_names();
    $custwid= get_option('custom-widget')?>
<form>
<div id="dialog" hidden="true">
  <p>Add or Import your Custom widgets below.... </p>
  <form id="addWidget" method="POST" action="<?php echo plugins_url('actionScripts/addwidget.php',__FILE__); ?>" enctype= "multipart/form-data">
  <input type="file" name="widgetToUpload" id="widgetToUpload" accept=".php,.zip">
  </form>
  </div>
</form>
    <h2><strong>Custom Widgets Option</strong></h2>
    <h1>Notifications:</h1>
   <p id="msg"></p>
    <table border="1px;"><tr><th>Custom Widgets</th><th>filename</th><th>Register Custom Widget</th><th>UnRegister Custom Widget</th><th>Extra options</th></tr>
        <form id="customswid" method="POST" action="<?php echo plugins_url('actionScripts/customWidgetOptions.php', dirname(__FILE__)) ; ?>">
    <?php 
    if(empty($custwid)==FALSE)
    foreach($custwid as $c):?>
    <tr>
        <?php if(getWidgetClass($c['file'])!=''):?>
        <td><?php echo $c['name'];?></td><td><?php echo $c['file']; ?></td>
        <td>
            <input type='hidden' name='customWidget[]' value='<?php echo  $c['key'] ?>' id='customWidget'> 
            <input type="radio" name="<?php echo$c['key'];?>" <?php checked(1,$c['status'] ); ?> value="true"></td>
        <td><input type="radio" name="<?php echo $c['key'];?>" <?php checked('',$c['status'] ); ?> value="false"></td>
        <td><a class="deleteWid" href="<?php echo plugins_url('cwdelete.php', dirname(__FILE__)) ; ?>?w=<?php echo$c['key']; ?>" title="delete <?php echo$c['name']; ?>">Delete Widget</a></td>
      <?php endif;?>
    </tr>
    <?php endforeach;?>
    <tr><td colspan="5"><a href="#"> Get more Custom Widgets</a>|<a href="#" id="addWidget"> Add/import new Custom Widgets</a></td></tr>
    </table>
    <?php submit_button('save custom widget');?>
    </form> 