<h3 style="border-bottom:green thin solid; padding:10px"> BONUS: N<?php echo number_format(($referral->getReferrals($userId,'ref-bonus') - $referral->getReferrals($userId,'bonus')),2); ?> </h3>
<div class="mb10" style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
    Referral Link: <a href="https://dachafinance.com?ref=<?php echo $userId; ?>">https://dachafinance.com?ref=<?php echo $userId; ?></a>
</div>


<div class="row m0">
    <div class="col-sm-4">
        <div class="header-title-banner p10">
            <h4> REFERRAL BREAKDOWN </h4>
        </div>
        <div class="row ms0" style="margin:10px 0px">
            <div class="col-xs-12" style="padding:0px 5px; width:100%"> 
                <b> TOTAL REFERRALS: </b> 
                <?php echo number_format($referral->getReferrals($userId,'count'));  ?> 
                <hr>
            </div>
            <div class="col-xs-12" style="padding:0px 5px; width:100%"> 
                <b> REFERRAL'S INVESTMENT: </b> 
                N<?php echo number_format($referral->getReferrals($userId,'total'), 2);  ?> 
                <hr>
            </div>
            <div class="col-xs-12" style="padding:0px 5px; width:100%"> 
                <b> REFERRAL'S BONUS: </b> 
                N<?php echo number_format($referral->getReferrals($userId,'ref-bonus'), 2);  ?> 
                <hr>
            </div>
            <div class="col-xs-12" style="padding:0px 5px; width:100%"> 
                <b> BONUS CASHOUTS: </b> 
                N<?php echo number_format($referral->getReferrals($userId,'bonus'), 2);  ?> 
                <hr>
            </div>
            <div class="col-xs-12" style="padding:0px 5px; width:100%"> 
                <b> BONUS BALANCE: </b> 
                N<?php echo number_format(($referral->getReferrals($userId,'ref-bonus') - $referral->getReferrals($userId,'bonus')), 2);  ?> 
                <hr>
            </div>
        </div>

        <div class="row ms0" style="margin:10px 0px">
            <a href="#" class="btn btn-success w100" style="color:#fff" onclick="closeModal4()"> Cashout </a>
        </div>
        <script>
            function closeModal4(){
                $("#ref-cashout").fadeToggle();
            }
        </script>
    </div>

    <div class="col-sm-4">
        <div class="header-title-banner p10">
            <h4> REFERRAL LIST: </h4>
        </div>
        <?php 
            if($referral->getReferrals($userId,'users') == 0){ 
                echo "No referral yet!"; 
            } else { 
                $refs = $referral->getReferrals($userId,'users'); 
                foreach ($refs AS $ref){
        ?>
            <div class="row" style="border-bottom:#ccc thin solid">
                <div class="col-xs-6" style="padding:5px 15px"> <b> <?php echo $ref['first_name']; ?> </b> </div>
                <div class="col-xs-6"  style="padding:5px 15px" align="right">
                    <span style="font-size:12px" class="cm-primary-color"> <?php echo $ref['email']; ?> </span> 
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