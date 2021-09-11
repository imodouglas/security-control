<?php 
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $visitor = new VisitorController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

    if(isset($_POST['add-user'])){
        $password = $user->rand_string(8);
        $data = $user->doCreateUser($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['email'], $_POST['phone'], $password, $_POST['role']);
        if($data !== false){
            $msg = "Hello ".$_POST['fname']."\r\n\r\nYour account has been created successfully. Please find below your login details.\r\n\r\nEmail: ".$_POST['email']."\r\nPassword: ".$password."\r\n\r\nBest regards!\r\n$companyName";
            $mail = $mailer->sendMail($companyEmail, $_POST['email'], "Your account has been created!", $msg, $companyName);
            echo "<script> window.location = '".$rootURL."admin/users'; </script>";
        }
    }

?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="row m0">
                    <div class="col-sm-12">
                        <div class="header-title-banner p10">
                            <h4> Users <button class="btn btn-primary btn-sm" title="Add User" onclick="addUser()"><i class="fas fa-plus"></i></button> </h4>
                            <script> 
                                const addUser = () => { $("#add-user").slideToggle(); }
                            </script>
                        </div>
                        <div style="padding-top:10px">
                            <table style="width:100%">
                                <tr>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Name
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Email
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Phone
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Registration Date
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Role
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Action
                                    </th>
                                </tr>
                                <?php foreach($user->getAllUsers() AS $userData){ ?>
                                    <tr>
                                        <td style="padding:10px;border-bottom:#ccc thin solid">
                                            <?php echo $userData['fname']." ".$userData['lname']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $userData['email']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php 
                                                echo $userData['phone']; 
                                            ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo date("d/m/Y (h:ia)", $userData['created_at']); ?>   
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $userData['role']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <button class="btn btn-primary white-color" style="padding: 3px 5px; background:blue" onclick="showUser('<?php echo $userData['id']; ?>')" title="Edit User"> <i class="fas fa-edit"></i> </button>
                                            <button class="btn btn-danger white-color" style="padding: 3px 5px;"  title="Delete User"> <i class="fas fa-trash"></i> </button>
                                            <button class="btn btn-primary white-color" style="padding: 3px 5px; background:#333"  title="Deactivate User"> <i class="fas fa-pause"></i> </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-user" style="display:none">
    <div style="position:fixed; top:0; left:0; width:100%; height:100vh; z-index:10000; background:#000; opacity:0.8"></div>
    <div style="position:fixed; top:20vh; left:0; width:100%; z-index:10010;" align="center">
        <div style="width:90%; max-width:400px; padding:20px; background:#f0f0f0; border:#ccc thin solid; border-radius:3px; box-shadow:#000 0px 0px 8px" align="left">
            <button style="padding:3px 10px; background:#ccc; float:right; margin-top:-10px; margin-right:-10px" onclick="addUser()" > <i class="fa fa-times"></i></button>
            <form method="post" action="">
                <div style="margin-bottom:10px;" class="cm-primary-color" align="center"> <b> ADD A USER! </b> </div>
                <p>
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name*" required>
                </p>
                <p>
                    <input type="text" name="mname" id="mname" class="form-control" placeholder="Middle Name">
                </p>
                <p>
                    <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name*" required>
                </p>
                <p>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email*" required>
                </p>
                <p>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone No.*" required>
                </p>
                <p>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">-- SELECT A ROLE --</option>
                        <option value="admin">Admininstrator</option>
                        <option value="security">Security</option>
                        <option value="staff">Staff</option>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Add User" name="add-user" class="btn btn-primary form-control">
                </p>
            </form>
        </div>
    </div>
</div>