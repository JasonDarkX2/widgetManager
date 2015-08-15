<?php
/*
Plugin Name: Wordpress Widget Manager
Plugin URI: https://github.com/JasonDarkX2/Wordpress-WidgetManager
Description:Simply a Wordpress Plugin dedicated to help easily manage custom and default Wordpress widgets
Author:Jason Dark X2
version: 0.1
Author URI:http://www.jasondarkx2.com/ 
*/ 
?>
<?php
class WMOptions
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Widget manager', 
            'manage_options', 
            'widget-Manager', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Widget Manager</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections( 'widget-Manager' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'Active_widgets', // ID
            'Active widgets', // Title
            array( $this, 'acive_widget_callback' ), // Callback
            'widget-Manager' // Page
        );
        
        add_settings_section(
            'Available', // ID
            'Available widgets', // Title
            array( $this, 'available_Widgets_callback' ), // Callback
            'widget-Manager' // Page
        );
          

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['acive_widgets'] ) )
            $new_input['acive_widgets'] = sanitize_text_field( $input['acive_widgets'] );

        if( isset( $input['available Widgets'] ) )
            $new_input['available Widgets'] = sanitize_text_field( $input['available Widgets'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function acive_widget_callback()
    {

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function available_Widgets_callback()
    {
    $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
    $wvalue=esc_html( var_export( $widgets, TRUE) );?> 
    <table border="1px">
        <tr><th><input type="checkbox" name="select all" onclick="selectall()"></th><th> Widgets</th><th> Enabled</th><th>Disabled</th></tr>
    <?php foreach($widgets as $widget):?>

        <tr>
            <td><input type="checkbox" name="<?php echo $widget; ?>" value="<?php echo $widget; ?>"></td>
            <td><?php echo $widget; ?></td>
            <td><input type="radio" name="<?php echo $widget; ?>" value="enable"></td>
            <td><input type="radio" name="<?php echo $widget;?>" value="disable"></td>
        </tr>
    <?php endforeach;?>
    <?php echo "</table>";
   }
}

?>