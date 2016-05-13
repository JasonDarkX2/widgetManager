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
session_start();
    if(isset($_SESSION['errors'])){
        print_r($_SESSION['errors']);
    }else{
       if(isset($_SESSION['deletion'])){
           print_r($_SESSION['deletion']);
           $_SESSION['deletion']=NULL;
       }else{
       autoDetect();
       }
    }
    ?>
</p>
<form id="settingsop" method="POST" action="<?php echo plugins_url('actionScripts/options.php', dirname(__FILE__)); ?>">
    <div class="wm-controls">
        <label for="quickOp">Bulk Action:</label>
        <select name="quickOp">
            <option value="">Select an Action</option>
            <option value="enbwid"> Enable all widgets</option>
            <option value="diswid"> Disable all widgets</option>
            <option value="enbDefault"> Enable default widgets Only</option>
            <option value="disDefault"> Disable default widgets Only</option>
            <option value="enbPlugin"> Enable Plugin widgets Only</option>
            <option value="disPlugin"> Disable Plugin widgets Only</option>
            <option value="disCust">Disable Custom widgets Only</option>
        </select>
        <input type="submit" value="Apply"/>
        <a href="#"> Get more Custom Widgets</a>|<a href="#" id="addWidget"> Add/import new Custom Widgets</a>|<a href="#" id="customWidgetDir"> Change Custom Widgets Directory</a>
    </div>
    <input type="hidden" name="wpdir" value="<?php echo basename(content_url()); ?>" />
    <?php settings_fields('WM-setting'); ?>
    <?php do_settings_sections('WM-setting'); ?>
    <div stle='display:table;'>
        <input type='hidden' name='count' value='$num' id='count'>
        <div class="widget-list">
            <?php
            $widgets = get_widgets_type(get_option('widgetid'), "Default");
            display($widgets, "Default");
            ?>
        </div>
        <div class="widget-list">
            <?php
            $widgets = get_widgets_type(get_option('widgetid'), "Plugin");
            display($widgets, "Plugin");
            ?>
        </div>
        <div class="widget-list">
            <?php
            $widgets = get_widgets_type(get_option('widgetid'), "Custom");
            display($widgets, "Custom");
            ?>
        </div>
        <div style=" display:block; clear:both; text-align:left; vertical-align:bottom;">
               <?php if(WPWM_DEBUG==1){
            include(plugin_dir_path( __FILE__ ) . 'debug.php');
        }
        ?></div>
        <div style="float:right;clear:both; text-align:right; vertical-align:top;"><a href="#">Go to top</a></div>
    </div>
</form>
<div id="dialog" hidden="true">
    <form id="addWidgetForm" method="POST" action="<?php menu_page_url('credentials'); ?>&op=add" enctype= "multipart/form-data">
        <p>Add or Import your Custom widgets below.... </p>
        <input type="file" name="widgetToUpload" id="widgetToUpload" accept=".php,.zip">
        <input type="hidden" id="wpdir" name="wpdir" value="<?php echo basename(content_url()); ?>" />
    </form>
    <form id="customDirForm" method="POST" action="<?php echo plugins_url('actionScripts/settings.php', dirname(__FILE__));?>">
    <input type="hidden" name="wpdir" value="<?php echo basename(content_url());?>" />
    <strong>Plugin Upload Directory:</strong>
    <?php if(get_option('preset-cdwd')==FALSE) : ?>
    <input type="text" name="dir" id="widgetdir" size="100" value="<?php echo str_replace('\\', '/',get_option('widgetdir'));?>">
    <?php else:?>
    <input type="text" name="dir" size="100" id="widgetdir"  disabled value="<?php echo str_replace('\\', '/',get_option('widgetdir'));?>">
    <?php endif;?>
    <p>
    </form>
</div>
<?php

function display($widgets, $type) {
    echo '<div class="widget-header"><div> ' . $type . ' Widgets</div></div>';
    if (count($widgets) == 0) {
        ?>
        <div class="widgets-items">
            <div class="switch-field">
                No&nbsp;<?php echo $type; ?>&nbsp;widgets found
            </div>
        </div>
    <?php
    } else {
        foreach ($widgets as $widget) {
            ?>
            <div class="widgets-items"><strong><?php echo $widget['name']; ?></strong>
                <br/> <?php echo $widget['Description']; ?>
                <div class="switch-field">
                    <input type='hidden' name='widgetid[]' value='<?php echo $widget['key'] ?>' id='widgetId'> 
                    <input type="radio" id="switch_left_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="enable" <?php checked($widget['status'], true); ?>/>
                    <label for="switch_left_<?php echo $widget['key']; ?>">Enable</label>
                    <input type="radio" id="switch_right_<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>" value="disable" <?php checked($widget['status'], false); ?>/>
                    <label for="switch_right_<?php echo $widget['key']; ?>">Disable</label>
                    <br/>
                    <?php if ($type == "Custom") { ?>
                        <a class="deleteWid" href="<?php 
                        $name='delete-'. $widget['key'];
                        $url=menu_page_url('credentials',FALSE) .'&w=' . $widget['key'] . '&op=del'; echo wp_nonce_url($url, $name); ?>" title="delete <?php echo $widget['name']; ?>">Delete Widget</a>       
 <?php }
            ?>

                </div>
            </div>  
        <?php
        }
    }
}

function get_widgets_type($widgets, $types) {
    array_pop($wid = array());
    foreach ($widgets as $widget) {
        if ($widget['type'] == $types) {
            array_push($wid, $widget);
        } else {
            continue;
        }
    }
    usort($wid, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    return $wid;
}
?>

