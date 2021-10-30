<!-- The Modal -->
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
 <?php 
 $url = plugins_url( '/controllers/widgetAdder_controller.php',  dirname(__FILE__));
 //var_dump($url);
  //$credentials=request_filesystem_credentials($url); ?>
    <p></p>
  </div>
</div>