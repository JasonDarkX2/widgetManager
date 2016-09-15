<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<a href="#"  id="debug" title="Show debug options">Enable debug mode</a>
<?php $s = get_option('widgetid'); ?>
<div id="debugSection" hidden="true">
    <strong>Options:|</strong><a href="#"  id="rwList" title="Show Widget List">Show Registered Widget</a>|
    <a href="#"  id="wlist" title="Show Widget List">Show Widget List</a>|<a href="#"  id="custlist" title="Show Custom Widget List">Show Custom Widget List</a>|
    <a href="<?php echo plugins_url('debug/debugTool.php', dirname(__FILE__)); ?>?op=caw"  id="clearAll" title="Clear All Widget Data">Clear all Widgets Data</a>|
    <a href="<?php echo plugins_url('debug/debugTool.php', dirname(__FILE__)); ?>?op=cw"  id="clearCust" title="Clear custom Widgets Data">Clear custom Widgets Data</a>|
    <a href="#"  id="reload" title="Reload Widgets"> Reload Widgets</a>|<a href="#"  id="cdp" title="Check Directory Permissions">Check Directory Permissions</a>|
    <div id="widgetList" hidden="true">
        <h1>Widget List:</h1>
        <?php var_dump($s); ?>
    </div>
    <div id="customw"hidden="true">
        <h1> Custom Widgets List:</h1>
        <?php $s = get_option('custom-widget');
        var_dump($s);
        ?>
    </div>
    <div id="rWidgetList"hidden="true">
        <h1>Registered Widget List:</h1>
        <?php
        $wid = ($GLOBALS['wp_widget_factory']->widgets);
        //var_dump($wid);
        echo $wid['wpb_widget']->id . "<ul>";
        foreach ($wid as $w) {
            echo "<li>$w->name, $w->id</li>";
        }
        echo " </ul> ";


        $widgets = array_keys($GLOBALS['wp_registered_widgets']);
        print '<pre>$widgets = ' . esc_html(var_export($widgets, TRUE)) . '</pre>';

        var_dump($GLOBALS['wp_registered_widgets']);
        echo "<div>";
        foreach ($GLOBALS['wp_registered_widgets'] as $sidebar) {
            echo "<h1>" . $sidebar['name'] . "</h1>";
        }
        echo "</div>";
        echo"<h1>NOPzE</h1>";
        var_dump($GLOBALS['wp_widget_factory']->widgets);
        ?>
        
    </div>