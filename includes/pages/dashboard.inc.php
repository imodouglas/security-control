<div class="row m0">
    <div class="col-sm-12">
        <?php if($investment->getInvestments($userId, 'count') == 0){ ?>
            <div class="p10" style="border-bottom: #333 thin solid">
                No Investment Yet. <button class="btn btn-success" onclick="invest()"> Purchase A Plan </button>
            </div>
        <?php } else { ?>
            <div class="p10 mb10 header-title-banner">
                <h3 class="m0">Your Latest Investments <button class="btn btn-success" onclick="invest()"> Purchase A Plan </button> </h3>
            </div>
        <?php } ?>
    </div>

    <?php
        if($investment->getLatestInvestments($userId, 'count') > 0){
            foreach($investment->getLatestInvestments($userId, 'result') AS $investment){
                $planData = $plan->getPlan($investment['plan_id']);
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
                            echo date("d M, Y", $investment['created_at']);
                        ?> 
                    </div>
                </div>
                <div class="row m0 investment-card-item">
                    <div class="col-6 p5" align="left">
                        <b> Activation Date </b>
                    </div>
                    <div class="col-6 p5">
                        <?php 
                            if($investment['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $investment['created_at']); }
                        ?> 
                    </div>
                </div>
                <div class="row m0 investment-card-item">
                    <div class="col-6 p5" align="left">
                        <b> Completion Date </b>
                    </div>
                    <div class="col-6 p5">
                        <?php 
                            if($investment['status'] == "pending"){ echo "Not Set"; } else { echo date("d M, Y", $investment['expires_at']); }
                        ?> 
                    </div>
                </div>
                <?php if($investment['status'] == "pending"){ ?>
                    <div class="p5">
                        <button class="btn btn-success form-control" onclick="investment.activate(<?php echo $investment['id']; ?>)">Activate Plan</button>
                    </div>
                    <div class="p5">
                        <button class="btn btn-danger form-control" onclick="investment.delete(<?php echo $investment['id'] ?>)">Cancel Plan</button>
                    </div>
                <?php } else if($investment['status'] == "active"){ ?>
                    <?php if(time() > $investment['expires_at']){ ?>
                        <div class="row m0 mb10">
                            <div class="col-12" align="center">
                                Investment Complete! Click the Complete button to send earnings to your wallet.
                                <!-- <form action="api.php" method="post">
                                    <input type="hidden" name="cmd" value="complete">
                                    <input type="hidden" name="investment" value="<?php echo $invest['id']; ?>">
                                    <input type="submit" value="complete">
                                </form> -->
                                <button class="btn btn-dark form-control" onclick="investment.complete(<?php echo $investment['id']; ?>)">Complete!</button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="row m0 mb10 header-title-banner" style='border-bottom:#ccc thin solid'>
                        <div class="col-6 p5" align="left">
                            <b style="color:green"> Current Income </b>
                        </div>
                        <div class="col-6 p5" id="counter-<?php echo $investment['id'] ?>" style="color:red"></div>
                        <script>
                            setInterval(() => {
                                let start = <?php echo $investment['activated_at']; ?>;
                                let end = <?php echo $investment['expires_at']; ?>;
                                let now = Date.now() / 1000;
                                let roi = <?php echo $roi; ?>;
                                let ppsec = roi / (end - start); 
                                if(now <= end){
                                    let current = (now - start) * ppsec;
                                    let newAmount = current + ppsec;
                                    $("#counter-"+<?php echo $investment['id'] ?>).html("N"+number_format(newAmount.toFixed(2))); 
                                } else {
                                    $("#counter-"+<?php echo $investment['id'] ?>).html("N"+number_format(roi)); 
                                }
                            }, 1000);
                        </script>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } } ?>
</div>

<script>
    
</script>