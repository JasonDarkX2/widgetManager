<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 ?>
<h1>Settings</h1>
<a href="#"  id="debug" title=" enable debug mode">Enable debug mode</a>
<?php $s=get_option('widgetid');?>
<div id="debugSection" hidden="true">
<strong>Options:|</strong><a href="#"  id="wlist" title="Show Widget List">Show Widget List</a>|<a href="#"  id="custlist" title="Show Custom Widget List">Show Custom Widget List</a>|
<a href="#"  id="clearAll" title="Clear">Clear all Widgets Data</a>|<a href="#"  id="clearCust" title="Clear">Clear custom Widgets Data</a>
<div id="widgetList" hidden="true">
    <h1>DEBUG Section:</h1>
<?php var_dump($s);?>
</div>
<div id="customw"hidden="true">
<h1> custom widgets</h1>
<?php $s=get_option('widgetid');
var_dump($s);?>
</div>
<?php//update_option('widgetid', "");
//update_option('custom-widget', "");

    