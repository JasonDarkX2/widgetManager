<?php
/*
 * Settings page for Wordpress Widget Manager plugin
 * Handles the displaying of widget Manager plugin setting options
 * For more information check out: http://JasonDarkX2.com/ 
*/
 ?>
<h1>Settings</h1>
<form id="settingsop" method="POST" action="<?php echo plugins_url('actionScripts/settings.php', dirname(__FILE__));?>">
    <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
    <strong>Plugin Upload Directory:</strong>
    <?php if(get_option('preset-cdwd')==FALSE) : ?>
    <input type="text" name="dir" id="widgetdir" size="100" value="<?php echo str_replace('\\', '/',get_option('widgetdir'));?>">
    <?php else:?>
    <input type="text" name="dir" size="100" id="widgetdir"  disabled value="<?php echo str_replace('\\', '/',get_option('widgetdir'));?>">
    <?php endif;?>
    <p>
        <strong>Preset options</strong>
    <ul>
        <li><input type='hidden' name='preset[]' value='ndw' id='preset'> 
            <input type="checkbox" name="ndw"  value="true" <?php checked(get_option('preset-ndw'),1);?>/>Disable and hide all Default Widgets from Manager.</li>
        
         <li><input type='hidden' name='preset[]' value='cwoff' id='preset' > 
             <input type="checkbox" name="cwoff" id="cwoff"  value="true" <?php checked(get_option('preset-cwoff'),1);?> />Auto Disable all newly added custom widgets.</li>
         <li><input type='hidden' name='preset[]' value='cdwd' id='preset'> 
             <input type="checkbox" name="cdwd" id="cdwd"  value="true"  <?php checked(get_option('preset-cdwd'),1);?>/>Use default Custom Widget Directory. </li>
         <li><input type='hidden' name='preset[]' value='pwm' id='preset'> 
             <input type="checkbox" name="pwm" id="pwm"  value="true" <?php checked(get_option('preset-pwm'),1);?>/> Enable Plugin Widgets Manager</li>
    </ul>
    </p>
<p id="msg"></p>
        <?php
submit_button()?>
</form>
<br/>

<?php



    