<?php

/*
 *  WwidgetAdder model class handles the adding and deletion of custom class widgets 
 */

class WidgetAdder{
    
        function __construct() {
        
    }
    function connect_fs($url, $method, $context, $fields = null) {
    global $wp_filesystem;
    if (false === ($credentials = request_filesystem_credentials($url, $method, false, $context, $fields))) {
        return false;
    }

    //check if credentials are correct or not.
    if (!WP_Filesystem($credentials) || $_POST['password'] == NULL) {
        request_filesystem_credentials($url, $method, true, $context, $fields);
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
    if (self::connect_fs($url, "POST", get_option('widgetdir'), $form_fields)) {
        //deletion  process
        global $wp_filesystem;
        $custwid = get_option('custom-widget');
        $widgets = get_option('widgetid');
        $widgetid = $widgetId;
        $wdir = get_option('widgetdir');
        if (file_exists($wdir . '/' . $custwid[$widgetid]['file']) === TRUE) {
            $toDel = explode("/", $custwid[$widgetid]['file']);
            $del = $wdir . $toDel[0];
           return self::display_msg($wp_filesystem->rmdir($del, true), TRUE);
        }
    } else {
        
    }
}

function add_widget($fileName, $tempName) {
    $dest = wp_upload_dir();
    if ($fileNameame == null) {
        $name = $_SESSION['name'];
    }
    if ($_POST['file'] == null) {
                $zipDestination = $dest['basedir'] . '/'. $fileName;
        move_uploaded_file($tempName, $zipDestination);
        $_POST['file'] =  $zipDestination;
        $_POST['name'] = $fileName;
        $form_fields = array('file','name');
    }
    if (self::connect_fs('', "POST", get_option('widgetdir'), $form_fields)) {
        $destination = get_option('widgetdir') . $fileName;
        $file = $_POST['file'];
        $unzip = unzip_file($file, $destination);
        if (is_wp_error($unzip)) {
            $_SESSION['errors'] = ' <div class="errorNotfi">' . $unzip->get_error_message() . '</div>';
        } else {
            $_SESSION['errors'] = NULL;
        }
        unlink($file);
           return TRUE;
    }
    $_SESSION['name']=NULL;
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
        <div><a href="<?php menu_page_url('cwop') ?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM') ?>">Return to Widgets Manager</a></div>
    <?php } else { ?>
        <div class="errorNotfi"> Unable to perform action</div>
        <div><a href="<?php menu_page_url('cwop') ?>">Return to Custom Widgets Options</a>|<a href="<?php menu_page_url('widgetM') ?>">Return to Widgets Manager</a></div>
        <?php
    }
}
}

?>