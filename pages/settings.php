<?php
/*
 * Settings page for Wordpress Widget Manager plugin
 * Handles the displaying of widget Manager plugin setting options
 * For more information check out: http://JasonDarkX2.com/ 
*/
 ?>
<h1>Settings</h1>
   <?php PermissionChecker(); ?>
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
<a href="#"  id="debug" title=" enable debug mode">Enable debug mode</a>
<?php $s=get_option('widgetid');?>
<div id="debugSection" hidden="true">
<strong>Options:|</strong><a href="#"  id="rwList" title="Show Widget List">Show Registered Widget</a>|
<a href="#"  id="wlist" title="Show Widget List">Show Widget List</a>|<a href="#"  id="custlist" title="Show Custom Widget List">Show Custom Widget List</a>|
<a href="<?php echo plugins_url('actionScripts/debugTool.php', dirname(__FILE__)) ; ?>?op=caw"  id="clearAll" title="Clear All Widget Data">Clear all Widgets Data</a>|
<a href="<?php echo plugins_url('actionScripts/debugTool.php', dirname(__FILE__)) ; ?>?op=cw"  id="clearCust" title="Clear custom Widgets Data">Clear custom Widgets Data</a>|
<a href="#"  id="reload" title="Reload Widgets"> Reload Widgets</a>|
<div id="widgetList" hidden="true">
    <h1>Widget List:</h1>
<?php var_dump($s);?>
</div>
<div id="customw"hidden="true">
<h1> Custom Widgets List:</h1>
<?php $s=get_option('custom-widget');
var_dump($s);?>
</div>
<div id="rWidgetList"hidden="true">
    <h1>Registered Widget List:</h1>
    <?php
    $wid=($GLOBALS['wp_widget_factory']->widgets);
                    //var_dump($wid);
    echo  $wid['wpb_widget']->id ."<ul>";
        foreach($wid as $w){
       echo "<li>$w->name, $w->id</li>";
      
    }
     echo " </ul> ";
                    
                    
                                        $widgets = array_keys( $GLOBALS['wp_registered_widgets'] );
    print '<pre>$widgets = ' . esc_html( var_export( $widgets, TRUE ) ) . '</pre>';
    
    var_dump($GLOBALS['wp_registered_widgets']);
            echo "<div>";
        foreach ( $GLOBALS['wp_registered_widgets'] as $sidebar ) { echo "<h1>" .$sidebar['name'] ."</h1>";}
        echo "</div>";
    ?>
    
</div>
<?php



    