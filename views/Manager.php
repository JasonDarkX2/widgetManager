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
    require_once  plugin_dir_path(dirname(__FILE__)).'controllers/widgetRetriever_controller.php';
    $retriever= new WidgetRetriever();
    if (isset($_SESSION['errors'])) {
        print_r($_SESSION['errors']);
        $_SESSION['errors'] = NULL;
    } else {
        if (isset($_SESSION['deletion'])) {
            print_r($_SESSION['deletion']);
            $_SESSION['deletion'] = NULL;
        } else {
              self::$wc->show();
        }
    }
    ?>
</p>
<form id="settingsop" method="POST" action="<?php echo plugins_url('controllers/widgetAction_controller.php', dirname(__FILE__)); ?>">
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
            <option value="enbCust">Enable Custom widgets Only</option>
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
            $retriever->get_widgets_type(get_option('widgetid'), "Default",TRUE);
            ?>
        </div>
        <div class="widget-list">
            <?php
            $retriever->get_widgets_type(get_option('widgetid'), "Plugin",TRUE);
            ?>
        </div>
        <div class="widget-list">
            <?php
           $retriever->get_widgets_type(get_option('widgetid'), "Custom",TRUE);
            ?>
        </div>
        <div style=" display:block; clear:both; text-align:left; vertical-align:bottom;">
            <?php
            if (WPWM_DEBUG == 1) {
                include(plugin_dir_path(dirname(__FILE__) ) . 'debug/debugView.php' );
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
    <form id="customDirForm" method="POST" action="<?php echo plugins_url('controllers/settings_controller.php', dirname(__FILE__)); ?>">
        <strong>Custom Widget Upload Directory:</strong>
        <?php if (get_option('preset-cdwd') == FALSE) : ?>
            <input type="text" name="dir" id="widgetdir" size="80" value="<?php echo str_replace('\\', '/', get_option('widgetdir')); ?>">
        <?php else: ?>
            <input type="text" name="dir" size="80" id="widgetdir"  disabled value="<?php echo str_replace('\\', '/', get_option('widgetdir')); ?>">
        <?php endif; ?>
        <br/>
        <input type='hidden' name='preset[]' value='cdwd' id='preset'> 
        <input type="checkbox" name="cdwd" id="cdwd"  value="true"  <?php checked(get_option('preset-cdwd'), 1); ?>/>Use default Custom Widget Directory.
        <input type="hidden" id="wpdir" name="wpdir" value="<?php echo basename(content_url()); ?>" />
        <p>
    </form>
</div>
<?php include('modal.php') ?>
