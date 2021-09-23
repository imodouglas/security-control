<?php 
    include 'includes/env.inc.php';

    $user = new UserController();
    // $userView = new UserView();
    $mailer = new Mailer;

    if(isset($_POST['email'], $_POST['password'])){
        $result = $user->doLogin($_POST['email'], $_POST['password']);
        if($result !== false){
            if($result['role'] == 'admin'){
                $_SESSION['admin_session'] = $result['id'];
                echo "<script> window.location = '".$rootURL."admin'; </script>";
            } else if($result['role'] == 'security'){
                $_SESSION['security_session'] = $result['id'];
                echo "<script> window.location = '".$rootURL."home'; </script>";
            } else if($result['role'] == 'staff'){
                $_SESSION['user_session'] = $result['id'];
                echo "<script> window.location = '".$rootURL."user'; </script>";
            }
        } else {

        }
    }
    
?>

<div class="header">
    <!-- <div class="overlay"></div> -->
    <div class="flexBox center-center">
        <div class="container">
            <div class="row" style="padding-top:80px; padding-bottom:80px">
                <div class="col-sm-3"></div>
                <div class="col-sm-6" style="padding:15px; border-radius:10px; background: #ffffffE8">
                    <div class="card-box">
                        <div class="card-box-body" align="center">
                            <div id="login">
                                <div class="card-title"> Login to your account </div>
                                <form method="post" action="">
                                    <p>
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required />
                                    </p>
                                    <p>
                                        <label> Password: </label>
                                        <input type="password" name="password" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="login" value="Login" class="btn btn-primary form-control" required />
                                    </p>
                                    <p>
                                        Forgot password? <a href="#" onclick="modal.reset()"> Reset Password </a>
                                    </p>
                                </form>
                            </div>

                            <div id="reset" style="display:none">
                                <div class="card-title"> Reset your password </div>
                                <form method="post" action="reset-password">
                                    <p>
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="reset" value="Reset Password" class="btn btn-primary form-control" required />
                                    </p>
                                    <p>
                                        Remembered password? <a href="#" onclick="modal.login()"> Login </a>
                                    </p>
                                </form>
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
    // function showSignup(){
    //     console.log('done!');
    // }
    const modal = {
        signup() {
            $("#login").hide();
            $("#reset").hide();
            $("#signup").fadeToggle("slow");
        },

        login() {
            $("#signup").hide();
            $("#reset").hide();
            $("#login").fadeToggle("slow");
        },

        reset() {
            $("#signup").hide();
            $("#login").hide();
            $("#reset").fadeToggle("slow");
        }

    };
</script>