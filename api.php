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
    

    if(isset($_POST['visitor'], $_POST['user'], $_POST['cmd']) && $_POST['cmd'] == "accept-visitor"){
        $uData = $user->getUser($_POST['user']);
        if($userSession == $uData['id']){
            $data = $visitor->doApproveVisitor($_POST['visitor'], $_POST['user']);
            $vData = $visitor->getDataById($_POST['visitor']);
            $officer = $user->getUser($vData['created_by']);
            $msg = "Hello ".$officer['fname']."\r\nPlease allow ".$vData['fname']." in to see me, and I approve of this visit.\r\n\r\nBest Regards,\r\n".$uData['fname']." ".$uData['lname'];
            $mailer->sendMail($uData['email'], $officer['email'], "Visit accepted!", $msg, $uData['fname']." ".$uData['lname']);
        } else {
            $data = false;
        }
        echo json_encode($data);
    }


    if(isset($_POST['visitor'], $_POST['user'], $_POST['cmd']) && $_POST['cmd'] == "reject-visitor"){
        $uData = $user->getUser($_POST['user']);
        if($userSession == $uData['id']){
            $data = $visitor->doRejectVisitor($_POST['visitor'], $_POST['user']);
            $vData = $visitor->getDataById($_POST['visitor']);
            $officer = $user->getUser($vData['created_by']);
            $msg = "Hello ".$officer['fname']."\r\nPlease do not allow ".$vData['fname']." in, and I do not approve of this visit.\r\n\r\nBest Regards,\r\n".$uData['fname']." ".$uData['lname'];
            $mailer->sendMail($uData['email'], $officer['email'], "Visit rejected!", $msg, $uData['fname']." ".$uData['lname']);
        } else {
            $data = false;
        }
        echo json_encode($data);
    }