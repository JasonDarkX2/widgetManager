<?php
require_once  plugin_dir_path(dirname(__FILE__)).'model/theWidget.php';
class WidgetRetriever{

    public $theWidget;
            function __construct() {
                $this->theWidget=new theWidget();
    }
/**
 *  gets and return an array of widget objects based on type. 
 * @param array $widgets - the widget list 
 * @param string $types - the type of widgets to look for.
 * @param vollean $display - TRUE displays the list FALSE just returns arraylist 
 * @return array
 */
function get_widgets_type($widgets, $types, $display=FALSE) {
    $wid = array();
    array_pop($wid);
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
/**
 *  display  the widget list in HTML markup  
 * @param array $widgets
 * @param string $type
 */
function display_widget($widgets, $type) {
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

            <div class=" pure-u-xl-8-24 m1  pure-u-sm-1 pure-u-1 widgets-items">
                <strong><?php echo $widget['name'];?></strong>
                <br/>
                <?php echo $widget['Description']; ?>
                <br/>
                <label class="widget-wrap switch">
                    <input type="checkbox" id="<?php echo $widget['key']; ?>" name="<?php echo $widget['key']; ?>"<?php checked($widget['status'], true); ?>/>
                    <span class="slider round"></span>
            </label>
                <?php if ($type == "Custom") { ?>
                    <br/><a class="deleteWid" href="<?php
                    $name = 'delete-' . $widget['key'];
                    $url = menu_page_url('credentials', FALSE) . '&w=' . $widget['key'] . '&op=del';
                    // modal version
                    //$url = plugins_url( '/controllers/widgetAdder_controller.php',  dirname(__FILE__)) . '?w=' . $widget['key'] . '&op=del';
                    echo wp_nonce_url($url, $name);
                    ?>" title="delete <?php echo $widget['name']; ?>">Delete</a>
                <?php }
                ?>
            </div>
            <?php
        }
    }
}
function getCount($widgetId, $type) {
    $widgets=self::get_widgets_type($widgetId,$type,False);
    $numEnabled=0;
    foreach ($widgets as $i){
        if($i['status']==true) {
            $numEnabled++;
            }
    }
    echo '(<span name="activeNum" id="'.$type. 'Num">'.$numEnabled. '</span>/'. count($widgets). ')';

}
function widgetItem(){?>
        <a href="#" id="addWidget" class=" pure-u-1 widgets-items">
        <div class="widget-wrap">
            <div class="circle"></div>
            <p class="bold">
                <?php echo "Add/import new Custom Widgets";?>
            </p>
            </div>
        </a>


<?php }


}