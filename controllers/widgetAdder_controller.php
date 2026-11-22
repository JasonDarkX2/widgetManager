<?php
/*
    the controller for adding/deleting Widgets for Wordpress Widget Manager
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="wrap">      
   <?php
require_once dirname(__DIR__) . '/model/widgetAdder.php';
$widgetAdder = new WidgetAdder();

// Check both POST (AJAX) and GET (standard link fallback)
$op = $_POST['op'] ?? $_GET['op'] ?? '';

switch ($op) {
    case 'add':
        if (!isset($_POST['ufile']) && !empty($_FILES['widgetToUpload']['name'])) {
            $fileName = $_FILES['widgetToUpload']['name'];
            $proceed = $widgetAdder->add_widget($fileName, $_FILES['widgetToUpload']['tmp_name']);
            if ($proceed) {
                echo '<div class="notfi">Widget uploaded successfully!</div><br>';
            }
        }
        break;

    case 'del':
        // Read from POST first, fall back to GET, and sanitize
        $widget = sanitize_file_name($_POST['w'] ?? $_GET['w'] ?? '');
        $wpdir  = sanitize_text_field($_POST['wpdir'] ?? $_GET['wpdir'] ?? '');

        // CRITICAL: Abort if $widget is empty so the parent folder isn't deleted
        if (empty($widget)) {
            wp_die('Error: Missing widget name.');
        }

        $output = $widgetAdder->delete_widget($widget, $wpdir);
        $_SESSION['deletion'] = $output;

        if (empty($output)) {
            echo '<div class="notfi">Widget deleted</div><br>';
        }
        break;
}