<?php
/*
    the controller for adding/deleting Widgets for Wordpress Widget Manager
 */
require_once dirname(dirname(__FILE__)) . '/model/widgetAdder.php';
    if (isset($_POST['op'])) {
        $op = $_POST['op'];
    } else {
        $op = $_GET['op'];
    }

    switch ($op) {
        case 'add':
            if (isset($_POST['ufile']) == FALSE)
                add_widget();
            break;
        case 'del':
            delete_widget();
            break;
    }
?>