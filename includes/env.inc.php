<?php

    $companyName = "Security Control";
    $companyPhone = "08012345678";
    $companyEmail = "info@securitycontrol.com";
    $rootURL = "http://security-control.ew/";


    if(isset($_SESSION['user_session'])){
        $userSession = $_SESSION['user_session'];
    } else if(isset($_SESSION['admin_session'])){
        $userSession = $_SESSION['admin_session'];
    } else if(isset($_SESSION['security_session'])){
        $userSession = $_SESSION['security_session'];
    }

?>