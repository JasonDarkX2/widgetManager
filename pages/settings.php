<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
echo '<h1>Settings</h1>';
echo '<a href="#"  id="debug" title=" enable debug mode">Enable debug mode</a>';
$s=get_option('custom-widget');
echo '<div id="debug">';
echo "<b>DEBUG Section:</b>";
var_dump($s);
echo "<h1>widgets</h1>";

echo '</div>';
//update_option('widgetid', "");
//update_option('custom-widget', "");

    