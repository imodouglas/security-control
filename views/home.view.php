<?php 
    include 'includes/env.inc.php';

    $userId = $userSession;
    $user = new UserController();
    $visitor = new VisitorController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

    if(isset($_POST['add-visitor'])){
        $userEmail = $user->getUser($_POST['visiting'])['email'];
        // echo "<script> alert('".$userEmail."'); </script>";
        $data = $visitor->doCreate($_POST['fname'], $_POST['address'], $_POST['visiting'], $_POST['phone'], $userId);
        if($data !== false){
            $msg = "Hi!\r\n\r\nYou have a visitor with the following details.\r\n\r\nName: ".$_POST['fname']."\r\nAddress: ".$_POST['address']."\r\nPhone No.: ".$_POST['phone']."\r\n\r\nPlease login to your dashboard on ".$rootURL." to accept or deny. \r\n\r\n$companyName Team!";
            $mail = $mailer->sendMail($userData['email'], $userEmail, "Hello! You have a visitor.", $msg, $userData['fname']." ".$userData['lname']);
            if($mail !== false){
                echo "<script> alert('Visitor added!'); window.location='".$rootURL."home' </script>";
            }
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
                <div class="row m0 mb10">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <b> TODAY'S DATE: </b> <br>
                            <?php echo date("F d, Y"); ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-complete">
                            <b> TIME: </b> <br>
                            <?php echo date("h:i a"); ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-complete">
                            <b> TOTAL VISITS TODAY: </b> <br>
                            <?php echo $visitor->getVisitorCount(strtotime("12:00am ".date("F d Y")), time()); ?>
                        </div>
                    </div>
                </div>

                <div class="row m0">
                    <div class="col-sm-12">
                        <div class="header-title-banner p10">
                            <h4> Today's Visitors <button class="btn btn-primary btn-sm" title="Add User" onclick="addVisitor()"><i class="fas fa-plus"></i></button> </h4>
                            <script> 
                                const addVisitor = () => { $("#add-visitor").slideToggle(); }
                            </script>
                        </div>
                        <div style="padding-top:10px">
                            <table style="width:100%">
                                <tr>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Name
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Address
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Visiting
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Entered At
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Exited At
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Action
                                    </th>
                                </tr>
                                <?php 
                                    if($visitor->getVisitors(strtotime("12:00am ".date("F d Y")), time()) !== false){
                                        foreach($visitor->getVisitors(strtotime("12:00am ".date("F d Y")), time()) AS $vData){ 
                                            $visiting = $user->getUser($vData['visiting']);
                                ?>
                                    <tr>
                                        <td style="padding:10px;border-bottom:#ccc thin solid">
                                            <?php echo $vData['fname']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $vData['address']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php 
                                                echo $visiting['fname']." ".$visiting['lname']; 
                                            ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php 
                                                if(isset($vData['arrived_at'])){
                                                    echo date("h:ia", $vData['arrived_at']); 
                                                } else {
                                                    echo "Awaiting entrance";
                                                }
                                            ?>   
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php 
                                                if(isset($vData['departed_at'])){
                                                    echo date("h:ia", $vData['departed_at']); 
                                                } else {
                                                    echo "Awaiting exit";
                                                }
                                            ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php 
                                                if(!isset($vData['arrived_at'])){
                                            ?>
                                                <button class="btn btn-primary white-color" style="padding: 3px 5px" onclick="signin('<?php echo $vData['id']; ?>')" title="Signin"> <i class="fas fa-sign-in-alt"></i> </button>
                                            <?php } else if(!isset($vData['departed_at'])) { ?>
                                                <button class="btn btn-danger white-color" style="padding: 3px 5px" onclick="signout('<?php echo $vData['id']; ?>')" title="Signout"> <i class="fas fa-sign-out-alt"></i> </button>
                                            <?php }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-visitor" style="display:none">
    <div style="position:fixed; top:0; left:0; width:100%; height:100vh; z-index:10000; background:#000; opacity:0.8"></div>
    <div style="position:fixed; top:20vh; left:0; width:100%; z-index:10010;" align="center">
        <div style="width:90%; max-width:400px; padding:20px; background:#f0f0f0; border:#ccc thin solid; border-radius:3px; box-shadow:#000 0px 0px 8px" align="left">
            <button style="padding:3px 10px; background:#ccc; float:right; margin-top:-10px; margin-right:-10px" onclick="addVisitor()" > <i class="fa fa-times"></i></button>
            <form method="post" action="">
                <div style="margin-bottom:10px;" class="cm-primary-color" align="center"> <b> ADD A VISITOR! </b> </div>
                <p>
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name*" required>
                </p>
                <p>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                </p>
                <p>
                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone No.*" required>
                </p>
                <p>
                    <select name="visiting" id="visiting" class="form-control">
                        <option value="">-- WHOM TO SEE --</option>
                        <?php 
                            if($user->getAllUsers() !== false){
                                foreach($user->getAllUsers() AS $staff){
                                    echo "<option value='".$staff['id']."'> ".$staff['fname']." ".$staff['lname']." </option>";
                                }
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Add Visitor" name="add-visitor" class="btn btn-primary form-control">
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    const signin = (x) =>{
        let formData = "id="+x+"&cmd=visitor-signin"
        console.log(formData)
        $.post("./api.php", formData, function(data){
            if(data == true){
                window.location = "home";
            }
        })
    }

    const signout = (x) =>{
        let formData = "id="+x+"&cmd=visitor-signout"
        console.log(formData)
        $.post("./api.php", formData, function(data){
            if(data == true){
                window.location = "home";
            }
        })
    }
</script>