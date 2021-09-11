<?php 
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $visitor = new VisitorController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="row m0 mb10" style="border-bottom:#ccc thin solid">
                    <div class="col-12 p10">
                        <b> Date: </b> <?php echo date("d M, Y") ?>
                        <br />
                        <b> Time: </b> <?php echo date("h:m a") ?>
                    </div>
                </div>

                <div class="row m0">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> TOTAL USERS </span> <br>
                            <span class="balance-text"> <?php echo number_format($user->getTotalUsers()) ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-referral">
                            <span class="white-color"> VISITS FOR <?php echo strtoupper(date("M Y")); ?> </span> <br>
                            <span class="balance-text" id="vis-balance"> <?php echo number_format($visitor->getVisitorCount(strtotime(date("h:ia F 01 Y")), time())); ?> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

