<?php
/*
 * Manager page for Wordpress Widget Manager plugin
 * Handles the displaying of widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
*/
?>
 <h1> Widget Manager</h1>
 <form id="settingsop" method="POST" action="<?php echo  plugins_url('actionScripts/options.php', dirname(__FILE__)); ?>">
     <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
    <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
    <table border='1px' >
        <tr><th> Widgets</th><th>Type</th><th> Enabled/Disabled</th></tr>
    <?php  
    
    $widgets=get_option('widgetid');
    foreach($widgets as $widget):
        if($widget['type']=="Plugin"&& get_option('preset-pwm')==FALSE){
        
            continue;
        }
        if($widget['type']=="Default"&& get_option('preset-ndw')==TRUE){
            continue;
        }
        ?>
        <input type='hidden' name='count' value='$num' id='count'>
 <?php
?>
        <tr>
            <td><input type='hidden' name='widgetid[]' value='<?php echo  $widget['key'] ?>' id='widgetId'> 
                <?php echo '<strong>'. $widget['name'] .'</strong><br/>' . $widget['Description']; ?></td>
            <td><?php echo $widget['type']; ?></td>
            <!--<td><input type="radio" name="<?php echo $widget['key']; ?>" value="enable" <?php  checked(1,$widget['status']); ?> ><?php //echo get_option($widget['key']);?></td>
            <td><input type="radio" name="<?php echo $widget['key'];?>" <?php checked('',$widget['status'] ); ?> value="disable"></td>!-->
            <td>
                <div class="switch-field">
      <div class="switch-title">Set the status of widget:</div>
      <input type="radio" id="switch_left_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="enabled" <?php checked(1,$widget['status']); ?>/>
      <label for="switch_left_<?php echo $widget['key']; ?>">Enable</label>
      <input type="radio" id="switch_right_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="disable" <?php checked('',$widget['status'] ); ?>/>
      <label for="switch_right_<?php echo $widget['key']; ?>">Disable</label>
    </div>
                
            </td>
        </tr>
        <?php endforeach;?>
        <tr>
        <tr>
            <td><strong>Quick Options</strong></td>
            <td colspan="3">
                <?php if(get_option('preset-ndw')==FALSE):?>
                <b>|Enable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="enbDefault">
                <b>|Disable Defaults Widgets Only:</b><input type="radio" name="quickOp" value="disDefault">
                <?php endif;?>
                <b>|Disable all custom widgets:</b><input type="radio" name="quickOp" value="disCust">
                <b>|Enable all Widgets:</b> <input type="radio" name="quickOp" value="enbwid">
                 <b>|Disable all Widgets:</b> <input type="radio" name="quickOp" value="diswid">
            </td>
        </tr>
    </table>
     <p id="msg">
    <?php
    autoDetect();
    ?>
</p>
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </form>
