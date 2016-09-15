<?php
/*
    the controller for adding/deleting Widgets for Wordpress Widget Manager
 */
?>
<div class="wrap">      
    <?php
        require_once  plugin_dir_path(dirname(__FILE__)).'model/widgetAdder.php';
        $widgetAdder= new WidgetAdder();
    if (isset($_POST['op'])) {
        $op = $_POST['op'];
    } else {
        $op = $_GET['op'];
    }

    switch ($op) {
        case 'add':
            if (isset($_POST['ufile']) == FALSE)
                $proceed=$widgetAdder->add_widget($_FILES["widgetToUpload"]['name'],$_FILES['widgetToUpload']["tmp_name"]);
            if($proceed==TRUE && !empty($proceed)){
            header('Location: ' . menu_page_url('widgetM'));
            }
            break;
        case 'del':
             $output=$widgetAdder->delete_widget($_GET['w'],$_GET['wpdir']);
            session_start();
            $_SESSION['deletion'] =$output;
            if(!empty($output)){
            header('Location: ' . menu_page_url('widgetM') . '&del=true');
                
            }
            break;
    }
    ?>
</div>