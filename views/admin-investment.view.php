<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    $inv_user_id = trim($_SERVER['REQUEST_URI'], "/dashboard/admin/investments/");
    $inv_user = $user->getUser($inv_user_id);
?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="p10 header-gray-banner" style="margin-top:10px; margin-bottom:20px">
                    <h3 class="m0"> <?php echo $inv_user['first_name']." ".$inv_user['last_name']." Investments" ?> </h3>
                </div>

                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">completed</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <!-- ACTIVE INVESTMENTS -->
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                            <h3 class="m0">Active Investments</h3>
                        </div>

                        <div class="row m0">
                            <?php
                                if($investment->investmentsByStatus($inv_user_id, 'active') !== false){
                                    foreach($investment->investmentsByStatus($inv_user_id, 'active') AS $invest){
                                        $planData = $plan->getPlan($invest['plan_id']);
                                        $roi = $planData['amount'] + (($planData['amount'] * $planData['percentage'])/100);
                            ?>
                                <div class="col-sm-4 p10 mb10">
                                    <div class="investment-card" align="center">
                                        <h3><?php echo $planData['name'] ?></h3>

                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Amount </b>
                                            </div>
                                            <div class="col-6 p5">
                                                N<?php echo number_format($planData['amount']); ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Expected ROI </b>
                                            </div>
                                            <div class="col-6 p5">
                                                N<?php echo number_format($roi)." (".$planData['percentage']."%)"; ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Duration </b>
                                            </div>
                                            <div class="col-6 p5">
                                                <?php echo number_format($planData['days'])." days"; ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Creation Date </b>
                                            </div>
                                            <div class="col-6 p5">
                                                <?php 
                                                    echo date("d M, Y", $invest['created_at']);
                                                ?> 
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Activation Date </b>
                                            </div>
                                            <div class="col-6 p5">
                                                <?php 
                                                    if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['created_at']); }
                                                ?> 
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Completion Date </b>
                                            </div>
                                            <div class="col-6 p5">
                                                <?php 
                                                    if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['expires_at']); }
                                                ?> 
                                            </div>
                                        </div>
                                        <?php if($invest['status'] == "pending"){ ?>
                                            <div class="p5">
                                                <button class="btn btn-success form-control" onclick="investment.activate(<?php echo $invest['id']; ?>)">Activate Plan</button>
                                            </div>
                                            <div class="p5">
                                                <button class="btn btn-danger form-control" onclick="investment.delete(<?php echo $invest['id'] ?>)">Cancel Plan</button>
                                            </div>
                                        <?php } else if($invest['status'] == "active"){ ?>
                                            <div class="row m0 mb10 header-title-banner" style='border-bottom:#ccc thin solid'>
                                                <div class="col-6 p5" align="left">
                                                    <b style="color:green"> Current Income </b>
                                                </div>
                                                <div class="col-6 p5" id="counter-<?php echo $invest['id'] ?>" style="color:red"></div>
                                                <script>
                                                    setInterval(() => {
                                                        let start = <?php echo $invest['activated_at']; ?>;
                                                        let end = <?php echo $invest['expires_at']; ?>;
                                                        let now = Date.now() / 1000;
                                                        let roi = <?php echo $roi; ?>;
                                                        let ppsec = roi / (end - start); 
                                                        if(now <= end){
                                                            let current = (now - start) * ppsec;
                                                            let newAmount = current + ppsec;
                                                            $("#counter-"+<?php echo $invest['id'] ?>).html("N"+number_format(newAmount.toFixed(2))); 
                                                        } else {
                                                            $("#counter-"+<?php echo $invest['id'] ?>).html("N"+number_format(roi));
                                                        }
                                                    }, 1000);
                                                </script>
                                            </div>
                                            <?php if(time() > $invest['expires_at']){ ?>
                                                <div class="row m0 mb10">
                                                    <div class="col-12" align="center">
                                                        Investment Complete! Click the Complete button to send earnings to your wallet.
                                                        <form action="api.php" method="post">
                                                            <input type="hidden" name="cmd" value="complete">
                                                            <input type="hidden" name="investment" value="<?php echo $invest['id']; ?>">
                                                            <input type="submit" value="complete">
                                                        </form>
                                                        <button class="btn btn-dark form-control" onclick="investment.complete(<?php echo $invest['id']; ?>)">Complete!</button>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } } else { echo "No active investment!"; } ?>
                        </div>
                    </div>

                    <!-- PENDING INVESTMENTS -->
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                                <h3 class="m0">Pending Investments </h3>
                            </div>

                            <div class="row m0">
                                <?php
                                    if($investment->investmentsByStatus($inv_user_id, 'pending') !== false){
                                        foreach($investment->investmentsByStatus($inv_user_id, 'pending') AS $invest){
                                            $planData = $plan->getPlan($invest['plan_id']);
                                            $roi = $planData['amount'] + (($planData['amount'] * $planData['percentage'])/100);
                                ?>
                                    <div class="col-sm-4 p10 mb10">
                                        <div class="investment-card" align="center">
                                            <h3><?php echo $planData['name'] ?></h3>

                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Amount </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['amount']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Expected ROI </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($roi)." (".$planData['percentage']."%)"; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Duration </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php echo number_format($planData['days'])." days"; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Creation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        echo date("d M, Y", $invest['created_at']);
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Activation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['created_at']); }
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Completion Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['expires_at']); }
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="p5">
                                                <button class="btn btn-success form-control" onclick="activateInvestment(<?php echo $invest['id']; ?>)">Activate Plan</button>
                                            </div>
                                            <div class="p5">
                                                <button class="btn btn-danger form-control" onclick="deleteInvestment(<?php echo $invest['id'] ?>)">Cancel Plan</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                                    } else {
                                        echo "No pending investment";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- COMPLETED INVESTMENTS -->
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                                <h3 class="m0">Completed Investments </h3>
                            </div>

                            <div class="row m0">
                                <?php
                                    if($investment->investmentsByStatus($inv_user_id, 'complete') !== false){
                                        foreach($investment->investmentsByStatus($inv_user_id, 'complete') AS $invest){
                                            $planData = $plan->getPlan($invest['plan_id']);
                                            $roi = $planData['amount'] + (($planData['amount'] * $planData['percentage'])/100);
                                ?>
                                    <div class="col-sm-4 p10 mb10">
                                        <div class="investment-card" align="center">
                                            <h3><?php echo $planData['name'] ?></h3>

                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Amount </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['amount']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Expected ROI </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($roi)." (".$planData['percentage']."%)"; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Duration </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php echo number_format($planData['days'])." days"; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Creation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        echo date("d M, Y", $invest['created_at']);
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Activation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['created_at']); }
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Completion Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        if($invest['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $invest['expires_at']); }
                                                    ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                                    } else {
                                        echo "No complete investment";
                                    }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const activateInvestment = (id) => {
        let formData = "investment="+id+"&cmd=confirm";
        $.post("../../api.php", formData, function(result){
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }

    const deactivateInvestment = (id) => {
        let formData = "investment="+id+"&cmd=pending";
        $.post("../../api.php", formData, (result)=>{
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }
    
    const deleteInvestment = (id) => {
        let formData = "investment="+id+"&cmd=delete";
        $.post("../api.php", formData, (result)=>{
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }
</script>