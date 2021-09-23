<?php 
    include 'includes/env.inc.php';

    $userId = $userSession;
    $user = new UserController();
    $visitor = new VisitorController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

    if(!isset($_POST['show-date'])){
        $start = strtotime("12:00am ".date("F d Y"));
        $end = time();
    } else {
        $start = strtotime("12:00am ".date("F d Y", strtotime($_POST['date'])));
        $end = strtotime("11:59pm ".date("F d Y", strtotime($_POST['date'])));
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
                            <?php echo $visitor->getUserVisitorCount($userId, strtotime("12:00am ".date("F d Y")), time()); ?>
                        </div>
                    </div>
                </div>

                <div class="row m0">
                    <div class="col-sm-12">
                        <div class="row m0 header-title-banner p10">
                            <div class="col-sm-6">
                                <div>
                                    <h4> My Visitors <?php if(!isset($_POST['show-date'])){ echo "TODAY"; } else { echo "For ". date("d M, Y", strtotime($_POST['date'])); } ?> </h4>
                                </div>
                            </div>
                            <div class="col-sm-6" align="right">
                                <div>
                                    <form action="" method="post">
                                        View Specific Date: 
                                        <input type="date" name="date" id="" style="padding:3px 10px; border:#ccc thin solid; border-radius:5px">
                                        <input type="submit" value="Go" name="show-date" class="btn btn-primary btn-sm">
                                    </form>
                                </div>
                            </div>
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
                                    if($visitor->getUserVisitors($userId, $start, $end) !== false){
                                        foreach($visitor->getUserVisitors($userId, $start, $end) AS $vData){ 
                                            $visiting = $user->getUser($vData['visiting']);
                                ?>
                                    <tr>
                                        <td style="padding:10px;border-bottom:#ccc thin solid">
                                            <?php echo $vData['fname']; if($vData['status'] == "approved"){ echo " <i class='fas fa-check-circle' style='color:green'></i>"; } ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $vData['address']; ?>
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
                                                <button class="btn btn-success white-color" style="padding: 3px 5px" onclick="approve('<?php echo $vData['id']; ?>', '<?php echo $userId; ?>')" title="Accept"> <i class="fas fa-thumbs-up"></i> </button>
                                                <button class="btn btn-danger white-color" style="padding: 3px 5px" onclick="reject('<?php echo $vData['id']; ?>', '<?php echo $userId; ?>')" title="Reject"> <i class="fas fa-thumbs-down"></i> </button>
                                            <?php } ?>
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

<script>
    const approve = (visitorId, userId) =>{
        let formData = "visitor="+visitorId+"&user="+userId+"&cmd=accept-visitor"
        console.log(formData)
        $.post("./api.php", formData, function(data){
            console.log(data);
            if(data == true){
                window.location = "user";
            }
        })
    }

    const reject = (visitorId, userId) =>{
        let formData = "visitor="+visitorId+"&user="+userId+"&cmd=reject-visitor"
        console.log(formData)
        $.post("./api.php", formData, function(data){
            console.log(data);
            if(data == true){
                window.location = "user";
            }
        })
    }
</script>