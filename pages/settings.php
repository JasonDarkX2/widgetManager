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
<h1>Settings</h1>
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
                    var_dump($wid);
    ?>
</div>
<?php



    