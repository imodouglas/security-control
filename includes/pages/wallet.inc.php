<?php if($account->getAccount($userId) == false){ ?>
    <div class="header-danger-banner p10 mb10">
        Please add your bank account details to enable cashout. <button class="btn btn-success" onclick='account.add()'>Setup Bank Account</button>
    </div>
<?php } else { ?>
    <div class="p10 mb10" style="background:#f0f0f0; border-bottom:#ccc 2px solid">
        Cash out to bank account <button class="btn btn-success" onclick='walletCashout()'>Cashout!</button>
    </div>
<?php } ?>


<div class="row m0">
    <div class="col-sm-4">
        <div class="header-title-banner p10">
            <h4> Payouts To Wallet </h4>
        </div>
        <?php if($payout->getUserPayoutsType($userId,'wallet') == false){ ?>
            <p class="p10"> No payout to wallet yet! </p>
        <?php } else {  
            foreach ($payout->getUserPayoutsType($userId,'wallet') AS $payoutData){ 
                if($payoutData['status'] == 'pending'){
                    $color = 'red';
                } else {
                    $color = 'green';
                }
        ?>
            <div class="row m0 p10 mb10 investment-card-item">
                <div class="col-12">
                    <p> <?php echo "Withdrew N".number_format($payoutData['amount'],2)." to ".$payoutData['type']." <br> <b> Date: </b> ".date("d M, Y", $payoutData['created_at'])."<br><b style='font-size:13px'>Status: <span style='color:".$color."'>".ucfirst($payoutData['status'])."</span> </b>"; ?> </p>
                </div>
            </div>
        <?php } } ?>
    </div>

    <div class="col-sm-4">
        <div class="header-title-banner p10">
            <h4> Payouts To Bank </h4>
        </div>
        <?php if($payout->getUserPayoutsType($userId,'bank') == false){ ?>
            <p class="p10"> No payout to Bank yet! </p>
        <?php } else {  
            foreach ($payout->getUserPayoutsType($userId,'bank') AS $payoutData){ 
                if($payoutData['status'] == 'pending'){
                    $color = 'red';
                } else {
                    $color = 'green';
                }
        ?>
            <div class="row m0 p10 mb10 investment-card-item">
                <div class="col-12 p10">
                    <p> <?php echo "Withdrew N".number_format($payoutData['amount'],2)." to ".$payoutData['type']." <br> <b> Date: </b> ".date("d M, Y", $payoutData['created_at'])."<br><b style='font-size:13px'>Status: <span style='color:".$color."'>".ucfirst($payoutData['status'])." </span> </b>"; ?> </p>
                </div>
            </div>
        <?php } } ?>
    </div>

    <div class="col-sm-4">
        <div class="header-title-banner p10">
            <h4> Your Account Details </h4>
        </div>
        <div class="p10">
            <?php if($account->getAccount($userId) == false){ ?>
                Please add your bank account details to enable cashout. <button class="btn btn-success" onclick='account.add()'>Setup Bank Account</button>
            <?php } else { $acctData = $account->getAccount($userId); ?>
                
                <div class="row m0 investment-card-item">
                    <div class="col-6 p5" align="left">
                        <b> Bank </b>
                    </div>
                    <div class="col-6 p5">
                        <?php echo $acctData['bank']; ?>
                    </div>
                </div>

                <div class="row m0 investment-card-item">
                    <div class="col-6 p5" align="left">
                        <b> Account Name </b>
                    </div>
                    <div class="col-6 p5">
                        <?php echo $acctData['account_name']; ?>
                    </div>
                </div>

                <div class="row m0 investment-card-item">
                    <div class="col-6 p5" align="left">
                        <b> Account No. </b>
                    </div>
                    <div class="col-6 p5">
                        <?php echo $acctData['account_no']; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include 'includes/modals/wallet-modals.inc.php'; ?>

<script>
    let walletCashout = () => {
        $("#cashout").slideToggle("slow");
    }
</script>