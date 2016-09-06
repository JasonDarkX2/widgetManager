<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once  plugin_dir_path(dirname(__FILE__)).'model/theWidget.php';
class WidgetRetriever{

    public $theWidget;
            function __construct() {
                $this->theWidget=new theWidget();
    }

function get_widgets_type($widgets, $types, $display=FALSE) {
    array_pop($wid = array());
    foreach ($widgets  as $w){
        if ($w['type'] == $types) {
            array_push($wid,$w);
        } else {
            continue;
        }
    }
    usort($wid, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    if($display){
        $this->display_widget($wid, $types);
    }else{
    return $wid;
    }
}
function display_widget($widgets, $type) {
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
                        <br/><a class="deleteWid" href="<?php
                           $name = 'delete-' . $widget['key'];
                           $url = menu_page_url('credentials', FALSE) . '&w=' . $widget['key'] . '&op=del';
                           echo wp_nonce_url($url, $name);
                           ?>" title="delete <?php echo $widget['name']; ?>">Delete Widget</a>       
                       <?php }
                       ?>

                </div>
            </div>  
            <?php
        }
    }
}
}