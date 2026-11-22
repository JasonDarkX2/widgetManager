<?php

/*
 *  WwidgetAdder model class handles the adding and deletion of custom class widgets 
 */

class WidgetAdder{
    
        function __construct() {
        
    }
    
    function connect_fs($url, $method, $context, $fields = null) {
    global $wp_filesystem;

    // Ensure filesystem functions are loaded
    if ( ! function_exists( 'request_filesystem_credentials' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    $credentials = request_filesystem_credentials( $url, $method, false, $context, $fields );
    if ( false === $credentials ) {
        return false;
    }

    // Only prompt again if WP_Filesystem() actually fails to initialize
    if ( ! WP_Filesystem( $credentials ) ) {
        //request_filesystem_credentials( $url, $method, true, $context, $fields );
        return false;
    }

    return true;
}

function delete_widget($widgetId,$wpDir) {

    $_POST['wpdir'] = $wpDir;
    $_POST['w'] = $widgetId;
    $form_fields = array('wpdir', 'w');
    $nonce = $_REQUEST['_wpnonce'];
    $name = 'delete-' . $_GET['w'];
    if (wp_verify_nonce($nonce, $name) == 2) {
        die();
        header('Location: ' . menu_page_url('widgetM') . '&del=true');
    }
    //$url=plugin_dir_path(dirname(__FILE__)) . 'controllers/deli.php?widgetId='.$widgetId;
    if (self::connect_fs('', "", get_option('widgetdir'), $form_fields)) {
        //deletion  process
        global $wp_filesystem;
        $custwid = get_option('custom-widget');
        $widgets = get_option('widgetid');
        $widgetid = $widgetId;
        $wdir = get_option('widgetdir');
        if (file_exists($wdir . '/' . $custwid[$widgetid]['file']) === TRUE) {
            $toDel = explode("/", $custwid[$widgetid]['file']);
            $del = $wdir . $toDel[0];
           if($wp_filesystem->rmdir($del, true)){
               return TRUE;
           }
        }
    } else {
    }
}

function add_widget($fileName, $tempName) {
    $dest = wp_upload_dir();
    $form_fields = array('file', 'name');

    if ($fileName == null && isset($_SESSION['name'])) {
        $fileName = $_SESSION['name'];
    }

    // 1. Validate file extension on initial upload
    if (empty($_POST['file'])) {
        $safeFileName = sanitize_file_name($fileName);
        $fileExt = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));

        if (!in_array($fileExt, array('zip', 'php'), true)) {
            $_SESSION['errors'] = ' <div class="errorNotfi">Invalid file type. Only .zip and .php files are allowed.</div>';
            return FALSE;
        }

        $stagedDestination = trailingslashit($dest['basedir']) . $safeFileName;
        move_uploaded_file($tempName, $stagedDestination);
        $stagedDestination = str_replace('\\', '/', $stagedDestination); // slash correction if necessary

        $_POST['file'] = $stagedDestination;
        $_POST['name'] = $safeFileName;
    }

    // 2. Connect to WordPress Filesystem and process the file
    if (self::connect_fs('', '', get_option('widgetdir'), $form_fields)) {
        global $wp_filesystem;

        $file        = $_POST['file'];
        $storedName  = $_POST['name'];
        $fileExt     = strtolower(pathinfo($storedName, PATHINFO_EXTENSION));
        $widgetDir   = trailingslashit(get_option('widgetdir'));
        $destination = $widgetDir . $storedName;

        // 3. Check if the file or folder already exists before unzipping or moving
        if ($wp_filesystem->exists($destination)) {
            $_SESSION['errors'] = ' <div class="errorNotfi">A widget named "' . esc_html($storedName) . '" already exists.</div>';
            
            if (file_exists($file)) {
                unlink($file);
            }
            
            $_SESSION['name'] = NULL;
            return FALSE;
        }

        if ($fileExt === 'zip') {
            $result = unzip_file($file, $destination);

            if (is_wp_error($result)) {
                $_SESSION['errors'] = ' <div class="errorNotfi">' . $result->get_error_message() . '</div>';
                if (file_exists($file)) {
                    unlink($file);
                }
                $_SESSION['name'] = NULL;
                return FALSE;
            } else {
                $_SESSION['errors'] = NULL;
            }
        } elseif ($fileExt === 'php') {
            // Set 3rd param to false so it does not overwrite existing files
            $moved = $wp_filesystem->move($file, $destination, false);

            if (!$moved) {
                $_SESSION['errors'] = ' <div class="errorNotfi">Failed to move the PHP widget file to the widget directory.</div>';
                if (file_exists($file)) {
                    unlink($file);
                }
                $_SESSION['name'] = NULL;
                return FALSE;
            } else {
                $_SESSION['errors'] = NULL;
            }
        }

        // Remove the staged temporary file if it still exists
        if (file_exists($file)) {
            unlink($file);
        }

        $_SESSION['name'] = NULL;
        return TRUE;
    }

    $_SESSION['name'] = NULL;
    return FALSE;
}

function display_msg($output, $del) {
    if ($del) {
        $msgType = "Deleted";
    }
    if ($output == true) {
        return '<div class="notfi">Successfully ' . $msgType . ' </div>';
    } else if (is_wp_error($output) && $output != NULL) {
        ?>
        <div class="errorNotfi"><?php $output->get_error_message(); ?></div>
    <?php } else { ?>
        <div class="errorNotfi"> Unable to perform action</div>
        <?php
    }
}
}