<?php
/*
 * Manager page for Wordpress Widget Manager plugin
 * Handles the displaying of widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
*/
?>
 <h1> Widget Manager</h1>
      <p id="msg">
    <?php
    autoDetect();
    ?>
</p>
 <form id="settingsop" method="POST" action="<?php echo  plugins_url('actionScripts/options.php', dirname(__FILE__)); ?>">
     <div class="wm-controls">
         <a href="#"> Enable all widgets</a>
         <a href="#"> Disable all widgets</a>
         <a href="#"> Enable default widgets Only</a>
         <a href="#"> Disable default widgets Only</a>
         <a href="#"> Enable Plugin widgets Only</a>
         <a href="#"> Disable Plugin widgets Only</a>
         <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></div>
     <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
      <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
     <div stle='display:table;'>
         <input type='hidden' name='count' value='$num' id='count'>
<div class="widget-list">
     <?php
     $widgets=get_widgets_type(get_option('widgetid'),"Default");
display($widgets, "Default");
 ?>
 </div>
     <div class="widget-list">
     <?php
     $widgets=get_widgets_type(get_option('widgetid'),"Plugin");
     display($widgets, "Plugin");
 ?>
             </div>
<div class="widget-list">
     <?php
     $widgets=get_widgets_type(get_option('widgetid'),"Custom");       
display($widgets,"Custom");
 ?>
             </div>     
     
 </div>           
    </form>
  <?php
 function display($widgets,$type){
     echo '<div class="widget-header"><div> '. $type . ' Widgets</div></div>';
     foreach($widgets as $widget){?>
 <div class="widgets-items"><strong><?php echo $widget['name'];?></strong>
     <br/> <?php echo $widget['Description'];?>
     <div class="switch-field">
      <input type='hidden' name='widgetid[]' value='<?php echo  $widget['key'] ?>' id='widgetId'> 
      <input type="radio" id="switch_left_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="enable" <?php checked($widget['status'],true); ?>/>
      <label for="switch_left_<?php echo $widget['key']; ?>">Enable</label>
      <input type="radio" id="switch_right_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="disable" <?php checked($widget['status'],false ); ?>/>
      <label for="switch_right_<?php echo $widget['key']; ?>">Disable</label>
    </div>
     </div>  
<?php }
 }
 function get_widgets_type($widgets,$types){
     array_pop($wid=array());
     foreach($widgets as $widget){
                 if($widget['type']==$types){
            array_push($wid, $widget);
        }else{
            continue;
        }
     }
     usort($wid, function($a, $b) {
    return strcmp($a['name'], $b['name']);
});
     return $wid;
 }
 
 ?>
    
 
     <!--<table>
        <tr>
            <td><strong>Quick Options</strong></td>
            <td colspan="1">
                <?php if(get_option('preset-ndw')==FALSE):?>
                <b>|Enable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="enbDefault">
                <b>|Disable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="disDefault">
                <?php endif;?>
                <b>|Disable all custom widgets:</b><input type="radio" name="quickOp" value="disCust">
                <b>|Enable all Widgets:</b> <input type="radio" name="quickOp" value="enbwid">
                 <b>|Disable all Widgets:</b> <input type="radio" name="quickOp" value="diswid">
                 </td>
        </tr>
    </table>!-->

 