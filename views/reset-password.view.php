<?php 
    include 'includes/env.inc.php';

    $user = new UserController();
    $pin = new PinController();
    $mailer = new Mailer;

    if(isset($_POST['reset'])){
        $userData = $user->userByEmail($_POST['email']);
        if($user !== false){
            if($pin->checkPin($userData['id']) > 0){
                $_SESSION['tmp_user'] = $userData['id'];
                $newPin = $pin->refreshPin($userData['id']);
            } else {
                $newPin = $pin->setPin($userData['id']);
            }
            $msg = "Hello ".$userData['first_name']."! \r\n\r\nYou have attempted a password reset on your account. Please find your reset pin below:\r\n\r\nPIN: ".$newPin."\r\n\r\nPlease note that this pin will expire in 15 mins.\r\nIf you did not take this action disregard this email or change your password as soon as possible. \r\n\r\nBest regards,\r\nDacha Finance Team";
            $mail = mail($userData['email'], "Dacha Finance password reset pin!", $msg, "FROM: Dacha Finance <info@dachafinance.com>");
            $mail = 1;
            if($mail){
                $_SESSION['step'] = 2;
                header("Location: reset-password");
            }
        } else {
            echo "<script> alert('We couldn't find a user with the given email!'); </script>";
        }
    }

    if(isset($_POST['confirm-pin'])){
        $checkPin = $pin->confirmPin( $_SESSION['tmp_user'], $_POST['pin']);
        if($checkPin > 0){
            $pinData = $pin->getPin( $_SESSION['tmp_user']);
            if($pinData['expires_at'] < time()){
                echo "<script> alert('Pin has expired! Click resend pin to get new pin'); </script>";
            } else {
                $_SESSION['step'] = 3;
                header("Location: reset-password");
            }
        } else {
            echo "<script> alert('Incorrect reset pin!'); </script>";
        }
    }

    if(isset($_POST['update-password'])){
        if($_POST['password1'] == $_POST['password2']){
            if($user->getChangePassword($_SESSION['tmp_user'],$_POST['password1']) == true){
                $userData = $user->getUser($_SESSION['tmp_user']);

                $msg = "Hello ".$userData['first_name']."! \r\n\r\nYour password reset was successful.\r\n\r\nPlease note that this action is irreversible and can only be undone by a new password reset action.\r\nIf you did not take this action please quickly reset password. \r\n\r\nBest regards,\r\nDacha FinanceTeam";
                $mail = mail($userData['email'], "Dacha Finance- Password reset successful!", $msg, "FROM: Dacha Finance<info@dachafinance.com>");
                $mail = 1;
                if($mail){
                    unset($_SESSION['step']);
                    unset($_SESSION['tmp_user']);
                    echo "<script> alert('Password reset successful!'); window.location = './'; </script>";
                }
            } else {
                echo "<script> alert('An error occured!'); </script>";
            }
        } else {
            echo "<script> alert('Password mismatch!'); </script>";
        }
    }

    
?>

<div class="header">
    <!-- <div class="overlay"></div> -->
    <div class="flexBox center-center">
        <div class="container">
            <div class="row" style="padding-top:80px; padding-bottom:80px">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="card-box">
                        <div class="card-box-body" align="center">
                            <div id="reset">
                                <?php if(isset($_SESSION['step']) && $_SESSION['step'] == 1){ ?>
                                    <div class="card-title"> Reset your password </div>
                                    <form method="post" action="reset-password">
                                        <p>
                                            <label> Email: </label>
                                            <input type="email" name="email" class="form-control" required />
                                        </p>
                                        <p>
                                            <input type="submit" name="reset" value="Reset Password" class="btn btn-success form-control" required />
                                        </p>
                                        <p>
                                            Remembered password? <a href="./"> Login </a>
                                        </p>
                                    </form>
                                <?php } else if($_SESSION['step'] == 2){ ?>
                                    <div class="card-title"> Enter Reset Pin </div>
                                    <form method="post" action="reset-password">
                                        <p>
                                            <label> Reset Pin: </label>
                                            <input type="number" name="pin" class="form-control" placeholder="Enter Reset PIN" required />
                                        </p>
                                        <p>
                                            <input type="submit" name="confirm-pin" value="Continue" class="btn btn-success form-control" required />
                                        </p>
                                        <p>
                                            Remembered password? <a href="./"> Login </a>
                                        </p>
                                    </form>
                                <?php } else if($_SESSION['step'] == 3){ ?>
                                    <div class="card-title"> Enter New Password </div>
                                    <form method="post" action="reset-password">
                                        <p>
                                            <label> New Password: </label>
                                            <input type="password" name="password1" class="form-control" placeholder="Enter New Password" required />
                                        </p>
                                        <p>
                                            <label> Confirm Password: </label>
                                            <input type="password" name="password2" class="form-control" placeholder="Confirm New Password" required />
                                        </p>
                                        <p>
                                            <input type="submit" name="update-password" value="Complete Reset" class="btn btn-success form-control" required />
                                        </p>
                                        <p>
                                            Remembered password? <a href="./"> Login </a>
                                        </p>
                                    </form>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
</div>


<script>
    
</script>