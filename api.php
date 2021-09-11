<?php
    header('Content-Type: application/json');
    session_start();
    require 'includes/env.inc.php';

    // if(!isset($_SESSION['user_session']) || !isset($_SESSION['admin_session'])){
    //     header("Location: ./");
    // }

    spl_autoload_register('autoloader');

    function autoloader($class){
        $dir = array('classes/controllers/', 'classes/models/', 'classes/database/');
        $ext = '.class.php';

        foreach($dir as $dir){
            $path = $dir.$class.$ext;
            if(file_exists($path)){
                include $path;
            }
        }
    }
    

    $user = new UserController();
    $visitor = new VisitorController();
    $mailer = new Mailer;
    

    if(isset($_POST['id'], $_POST['cmd']) && $_POST['cmd'] == "visitor-signin"){
        $data = $visitor->doSignin($_POST['id']);
        echo json_encode($data);
    }


    if(isset($_POST['id'], $_POST['cmd']) && $_POST['cmd'] == "visitor-signout"){
        $data = $visitor->doSignout($_POST['id']);
        echo json_encode($data);
    }