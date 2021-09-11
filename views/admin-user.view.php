<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    $sc_user_id = trim($_SERVER['REQUEST_URI'], "/dashboard/admin/user/");
    $sc_user = $user->getUser($sc_user_id);

?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="p10 header-gray-banner" style="margin-top:10px; margin-bottom:20px">
                    <h3 class="m0"> <?php echo $sc_user['fname']." ".$sc_user['lname']." Summary" ?> </h3>
                </div>
            </div>
        </div>
    </div>
</div>