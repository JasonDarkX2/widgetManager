<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.95
Author URI:http://www.jasondarkx2.com/ 
*/ 
?>
 <h1> Widget Manager</h1>

 <form id="settingsop" method="POST" action="<?php echo  plugins_url('actionScripts/options.php', dirname(__FILE__)); ?>">
     <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
    <?php settings_fields( 'WM-setting' ); ?>
    <?php do_settings_sections( 'WM-setting' ); ?>
    <table border='1px' >
        <tr><th> Widgets</th><th>Type</th><th> Enabled</th><th>Disabled</th></tr>
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
                <?php echo $widget['name']; ?></td>
            <td><?php echo $widget['type']; ?></td>
            <td><input type="radio" name="<?php echo $widget['key']; ?>" value="enable" <?php  checked(1,$widget['status']); ?> ><?php //echo get_option($widget['key']);?></td>
            <td><input type="radio" name="<?php echo $widget['key'];?>" <?php checked('',$widget['status'] ); ?> value="disable"></td>
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
