<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $payout = new PayoutController();
    $account = new AccountController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    
    function sumInvestments($investments, $plan){
        $sum = 0;
        if(is_array($investments)){
            foreach ($investments AS $inv){
                $amount = $plan->getPlan($inv['plan_id'])['amount'];
                $sum = $sum + $amount;
            }
        }
        return $sum;
    }

    function sumPayouts($payouts, $payout){
        $sum = 0;
        if(is_array($payouts)){
            foreach ($payouts AS $pay){
                $sum = $sum + $pay['amount'];
            }
        }
        return $sum;
    }
?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="row" style="margin:0; margin-bottom:20px">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> TOTAL PAYOUTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format(($payout->payoutsSumStatus("pending")['total'] + $payout->payoutsSumStatus("complete")['total']),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($payout->payoutsStatus("pending", "count") + $payout->payoutsStatus("complete", "count")); ?> Payouts  </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-balance">
                            <span class="white-color"> PENDING PAYOUTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format(($payout->payoutsSumStatus("pending")['total']),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($payout->payoutsStatus("pending", "count")); ?> Payouts  </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-complete">
                            <span class="white-color"> COMPLETE PAYOUTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format(($payout->payoutsSumStatus("complete")['total']),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($payout->payoutsStatus("complete", "count")); ?> Payouts  </span>
                        </div>
                    </div>
                </div>

                <div class="mb10 p10 header-title-banner" style="margin-top:10px">
                    <h3 class="m0"> Payouts </h3>
                </div>

                <div style="padding-top:10px">
                    <?php if($payout->allPayoutsByType('bank') == false) { echo "No payouts yet"; } else { ?>
                        <table style="width:100%">
                            <tr>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                    Name
                                </th>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                    Amount
                                </th>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                    Bank
                                </th>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                    Request Date
                                </th>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                    Status
                                </th>
                                <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid" align='center'>
                                    Action
                                </th>
                            </tr>
                            <?php 
                                foreach($payout->allPayoutsByType('bank') AS $pay){ 
                                    $userInfo = $user->getUser($pay['user_id']);
                                    $accountInfo = $account->getAccount($pay['user_id']);
                            ?>
                                <tr>
                                    <td style="padding:10px;border-bottom:#ccc thin solid">
                                        <?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?>
                                    </td>
                                    <td style="padding:10px; border-bottom:#ccc thin solid">
                                        <?php echo number_format($pay['amount'],2); ?>
                                    </td>
                                    <td style="padding:10px; border-bottom:#ccc thin solid">
                                        <?php echo $accountInfo['bank']." (".$accountInfo['account_no'].")"; ?>
                                    </td>
                                    <td style="padding:10px; border-bottom:#ccc thin solid">
                                        <?php echo date("d/M/Y - h:ia", $pay['created_at']); ?>   
                                    </td>
                                    <td style="padding:10px; border-bottom:#ccc thin solid">
                                        <?php echo $pay['status']; ?>   
                                    </td>
                                    <td style="padding:10px; border-bottom:#ccc thin solid">
                                        <?php if($pay['status'] == "pending"){ ?>
                                            <button class="btn btn-success" style="padding:2px 5px" onclick="payout.update(<?php echo $pay['id']; ?>, 'complete')"> <i class="fas fa-check" title="Mark as Complete"></i> </button>
                                        <?php } else if($pay['status'] == "complete"){ ?>
                                            <button class="btn btn-danger" style="padding:2px 8px" onclick="payout.update(<?php echo $pay['id']; ?>, 'pending')"> <i class="fas fa-times"  title="Mark as Pending"></i> </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const payout = {
        update(payoutId,status) {
            let formData = "id="+payoutId+"&status="+status+"&cmd=payout-complete";
            $.post("../api.php", formData, (data)=>{
                if(data == true){
                    location.reload();
                } else {
                    alert("An error occured! Please try again.");
                }
            });
        }
    }
</script>