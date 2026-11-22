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
        require_once   dirname(__DIR__) .'/model/widgetAdder.php';
        $widgetAdder= new WidgetAdder();
    if (isset($_POST['op'])) {
        $op = $_POST['op'];
    } else {
        $op = $_GET['op'];
    }

    switch ($op) {
        case 'add':
            if (isset($_POST['ufile']) == FALSE)
                $fileName=$_FILES["widgetToUpload"]['name'];
                $proceed=$widgetAdder->add_widget($fileName,$_FILES['widgetToUpload']["tmp_name"]);
            if($proceed==TRUE && !empty($proceed)){
                ?>
               <div class="notfi">Widget uploaded successfully!</div>
               <br>
               <?php
            }
            break;
        case 'del':
             $output=$widgetAdder->delete_widget($_GET['w'],$_GET['wpdir']);
            $_SESSION['deletion'] =$output;
            if(empty($output)){
                ?>
               <div class="notfi"> Widget deleted</div>
               <br>
           <?php
            }
            break;
    }