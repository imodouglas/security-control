<?php 
    
    $invs = $investment->investmentsByStatus($userId, 'active');
    if($invs !== false){
        $invArray = [];
        foreach($invs AS $key => $invs){
            $invArray[$key]['investment'] = $invs;
            $invArray[$key]['plan'] = $plan->getPlan($invs['plan_id']);
        }
        $allInv = json_encode($invArray);
    } else {
        $allInv = json_encode(false);
    }

    if(!isset($payout)){
        $payout = new PayoutController;
    }
    if(!isset($referral)){
        $referral = new ReferralController;
    }

    $walletBalance = ($payout->payoutsTypeSum($userId, 'wallet')['total'] + $payout->payoutsTypeSum($userId, 'bonus')['total']) - $payout->payoutsTypeSum($userId, 'bank')['total'];
    $bonusBalance =($referral->getReferrals($userId,'ref-bonus') - $referral->getReferrals($userId,'bonus'));
    
?>

<div style="margin-bottom: 20px">
    <div class="row m0">
        <div class="col-sm-4">
            <div class="wallet-card-balance">
                <span class="white-color"> WALLET BALANCE </span> <br>
                <span class="balance-text"> N<?php echo number_format($walletBalance,2) ?> </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="wallet-card-investment">
                <span class="white-color"> INVESTMENTS BALANCE </span> <br>
                <span class="balance-text" id="inv-balance"> N0.00 </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="wallet-card-referral">
                <span class="white-color"> REFERRAL BONUS </span> <br>
                <span class="balance-text" id="inv-balance"> N<?php echo number_format($bonusBalance,2) ?> </span>
            </div>
        </div>
    </div>
</div>

<script>
    let investments = <?php echo $allInv; ?>;
    console.log(investments);
    let invCounter = () => {
        // let totalCurrent = 0;
        // let totalPpsec = 0;
        let totalAmount = 0;

        for(let i=0; i < investments.length; i++){
            let start = investments[i].investment.activated_at;
            let end = investments[i].investment.expires_at;
            let now = Date.now() / 1000;
            let roi = parseInt(investments[i].plan.amount) + ((investments[i].plan.amount * investments[i].plan.percentage) / 100);
            let ppsec = roi / (end - start); 
            if(now <= end){
                let current = (now - start) * ppsec;
                let newAmount = current + ppsec;
                totalAmount = totalAmount + newAmount;
            } else {
                totalAmount = roi;
            }
        }

        // totalAmount = totalCurrent + totalPpsec;

        $("#inv-balance").html("N"+number_format(totalAmount.toFixed(2)));

    }

    setInterval(() => {
        invCounter();
    }, 1000);
</script>