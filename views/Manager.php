<?php
/*
 * Manager page for Wordpress Widget Manager plugin
 * Handles the displaying of widgets and their options
 * For more information check out: http://JasonDarkX2.com/ 
 */
?>

    <div class="pure-g">
        <div class="pure-u-1" style="text-align: center;">
        <h1> Widget Manager</h1>
        </div>
        <div class="pure-u-1" style="text-align: center;">
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
                        //self::$wc->show();
                    }
                }
                ?>
            </p>
        </div>
        <form id="settingsop" method="POST"  action="<?php echo plugins_url('controllers/widgetAction_controller.php', dirname(__FILE__)); ?>">
            <input type="hidden" name="wpdir" value="<?php echo basename(content_url()); ?>" />
            <?php settings_fields('WM-setting'); ?>
            <?php do_settings_sections('WM-setting'); ?>
        <!-- Panel#1 !-->
        <div class=" pure-u-1 pure-u-xl-1-3 pure-u-md-1" id="widget-panel">
            <p class="widget-panelHeader">
                <label class=" header switch">
                    <input type="checkbox" name="Default" <?php checked(get_option('defaultStatus'), true);?>>
                    <span class="header slider round"></span>
                </label>
                Default Widgets
                <?php
                $retriever->getCount(get_option('widgetid'), "Default");
                ?>
            </p>
            <div class="pure-u-1 widget-list">
                <?php
                $retriever->get_widgets_type(get_option('widgetid'), "Default",TRUE);
                ?>
            </div>

        </div><!-- End Panel#1 !-->
        <!-- Panel#2 !-->
        <div class="pure-u-1 pure-u-xl-1-3 pure-u-md-1" id="widget-panel">
            <p class="widget-panelHeader">
                <label class=" header switch">
                    <input type="checkbox" name="Plugin" <?php checked(get_option('pluginStatus'), true);?>>
                    <span class="header slider round"></span>
                </label>
                Plugin Widgets
                <?php
                $retriever->getCount(get_option('widgetid'), "Plugin");
                ?>
            </p>
            <div class=" pure-u-1 widget-list">
                <?php
                $retriever->get_widgets_type(get_option('widgetid'), "Plugin",TRUE);
                ?>
            </div>
        </div><!-- End Panel#2 !-->

        <!-- Panel#3 !-->
        <div class="pure-u-1 pure-u-xl-1-3 m1 pure-u-md-1" id="widget-panel" >
            <p class="widget-panelHeader">
                <label class=" header switch">
                    <input type="checkbox" name="Cust" <?php checked(get_option('custStatus'), true);?>>
                    <span class="header slider round"></span>
                </label>
                Custom Widgets
                <?php
                $retriever->getCount(get_option('widgetid'), "Custom");
                ?>

            </p>
            <div class=" pure-u-1 widget-list">
                <?php
                $retriever->get_widgets_type(get_option('widgetid'), "Custom",TRUE);
                $retriever->widgetItem();
                ?>
            </div>
        </div>
            <div style=" display:block; clear:both; text-align:left; vertical-align:bottom;">
                <?php
                if (WPWM_DEBUG == 1) {
                    include(plugin_dir_path(dirname(__FILE__) ) . 'debug/debugView.php' );
                }
                ?></div>

    </div>
        </div><!-- End Panel#3 !-->
        </form>

    <div class="pure-u-1 centeredText"><a href="#" title="Go to Top"> Go to Top</a>
</div>
    </div><!-- end of grid!-->


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
