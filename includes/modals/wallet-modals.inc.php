<?php 
    if(isset($_POST['ref-cashout'])){
        if($_POST['amount'] <= ($referral->getReferrals($userId,'ref-bonus') - $referral->getReferrals($userId,'bonus'))){
            $result = $payout->doAddPayout($userId,"bonus",$_POST['amount'],"complete");
        } else {
            $result = 0;
        }

		if($result > 0){ 
			echo "<script> alert('Cashout request initiated. You will be credited shortly!'); window.location = 'referrals'; </script>"; 
		} else {
			echo "<script> alert('Insufficient funds!'); window.location = 'referrals'; </script>";
		}
	}

    if(isset($_POST['wallet-cashout'])){
        if($_POST['amount'] <= $walletBalance){
            $result = $payout->doAddPayout($userId,"bank",$_POST['amount'],"pending");
        } else {
            $result = 0;
        }

		if($result > 0){ 
			echo "<script> alert('Cashout request initiated. You will be credited shortly!'); window.location = 'wallet'; </script>"; 
		} else {
			echo "<script> alert('Insufficient funds!'); window.location = 'wallet'; </script>";
		}
	}
?>


<div class="modal-overlay" id="modal-overlay"></div>
<div class="modal-container" id="add-bank-modal" align="center">
    <div class="modal-card">
        <div class="p10" style="border-bottom:#333 thin solid">
            <b> ADD YOUR BANK ACCOUNT DETAILS </b>
            <span class="clickable" style="float:right" title="Close" onclick="account.close()"> [x] </span>
        </div>
        <form id="add-account" action="" method="post">
            <div class="p10">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userId; ?>" />
                <input type="hidden" name="cmd" id="userid" value="add-account" />
                <select name="bank" id="bank" class="form-control" required>
                    <option value="Access Bank">Access Bank</option>
                    <option value="Citibank">Citibank</option>
                    <option value="Diamond">Diamond Bank</option>
                    <option value="Ecobank">Ecobank</option>
                    <option value="Fidelity">Fidelity Bank</option>
                    <option value="First">First Bank</option>
                    <option value="irst City Monument">First City Monument Bank (FCMB)</option>
                    <option value="Guaranty Trust">Guaranty Trust Bank (GTB)</option>
                    <option value="Heritage">Heritage Bank</option>
                    <option value="Keystone">Keystone Bank</option>
                    <option value="Polaris">Polaris Bank</option>
                    <option value="Providus">Providus Bank</option>
                    <option value="Stanbic IBTC">Stanbic IBTC Bank</option>
                    <option value="Standard Chartered">Standard Chartered Bank</option>
                    <option value="Sterling">Sterling Bank</option>
                    <option value="Suntrust">Suntrust Bank</option>
                    <option value="Union">Union Bank</option>
                    <option value="UBA">United Bank for Africa (UBA)</option>
                    <option value="Unity">Unity Bank</option>
                    <option value="Wema">Wema Bank</option>
                    <option value="Zenith">Zenith Bank</option>
                </select>
            </div>
            <div class="p10">
                <input type="text" name="acctName" class="form-control" placeholder="Account Name" id="account-name" required />
            </div>
            <div class="p10">
                <input type="number" name="acctNo" class="form-control" placeholder="Account No" id="account-no" required />
            </div>
            <div class="p10" align="center">
                <button type="submit" id='acct-submit' class="btn btn-success form-control"> Add Account </button>
            </div>
        </form>
    </div>
</div>

<div id="cashout" style="display:none">
    <div style="position:fixed; top:0; left:0; width:100%; height:100vh; z-index:10000; background:#000; opacity:0.8"></div>
    <div style="position:fixed; top:20vh; left:0; width:100%; z-index:10010;" align="center">
        <div style="width:90%; max-width:400px; padding:20px; background:#f0f0f0; border:#ccc thin solid; border-radius:3px; box-shadow:#000 0px 0px 8px" align="left">
            <button style="padding:3px 10px; background:#ccc; float:right; margin-top:-10px; margin-right:-10px" onclick="walletCashout()" > <i class="fa fa-times"></i></button>
            <form method="post" action="">
                <div style="margin-bottom:10px;" class="cm-primary-color" align="center"> <b> CASHOUT TO BANK ACCOUNT! </b> </div>
                <?php if($account->getAccount($userId) == false){ echo "<div align='center'> You haven't setup you wallet yet. <br><br> <a href='referral' style='color:#fff' class='btn btn-success'> Setup Now! </a> </div>"; } else { ?>
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom:5px;"></div>
                        <div class="col-xs-12" style="padding:0px 5px; width:100%" align="center"> 
                            <b> WALLET BALANCE: </b> 
                            <h3 style="color:green"> N<?php echo number_format($walletBalance, 2);  ?>  </h3>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px; padding-top:10px; border-top:#ccc thin solid" align="center">
                        <div class="col-sm-12" style="padding:10px">
                            <label> Amount in N: </label>
                            <input type="number" name="amount" class="form-control" />
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" name="wallet-cashout" class="btn btn-success w100" value="Cashout" /> 
                        </div>
                        <div style="font-size:14px; color:red; width:100%" align="center"> Cashouts are made to your bank account </div>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>


<div id="ref-cashout" style="display:none">
    <div style="position:fixed; top:0; left:0; width:100%; height:100vh; z-index:10000; background:#000; opacity:0.8"></div>
    <div style="position:fixed; top:20vh; left:0; width:100%; z-index:10010;" align="center">
        <div style="width:90%; max-width:400px; padding:20px; background:#f0f0f0; border:#ccc thin solid; border-radius:3px; box-shadow:#000 0px 0px 8px" align="left">
            <button style="padding:3px 10px; background:#ccc; float:right; margin-top:-10px; margin-right:-10px" onclick="closeModal4()" > <i class="fa fa-times"></i></button>
            <form method="post" action="">
                <div style="margin-bottom:10px;" class="cm-primary-color"> <b> CASHOUT FROM BONUS WALLET! </b> </div>
                <?php if($account->getAccount($userId) == false){ echo "<div align='center'> You haven't setup you wallet yet. <br><br> <a href='referral' style='color:#fff' class='btn btn-success'> Setup Now! </a> </div>"; } else { ?>
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom:5px;"></div>
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
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px; padding-top:10px; border-top:#ccc thin solid" align="center">
                        <div class="col-sm-12" style="padding:10px">
                            <label> Amount in N: </label>
                            <input type="number" name="amount" class="form-control" />
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" name="ref-cashout" class="btn btn-primary w100" value="Cashout" /> 
                        </div>
                        <div style="font-size:14px; color:red; width:100%" align="center"> Cashouts are made to your wallet </div>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<script>
    const account = {
        add() {
            $("#modal-overlay").fadeToggle('fast');
            $("#add-bank-modal").fadeToggle('fast');
        },

        close(){
            $("#modal-overlay").slideUp('fast');
            $("#add-bank-modal").slideUp('fast');
        }
    }

    $("#add-account").submit((e) => {
        e.preventDefault();
        let form_data = $("#add-account").serialize();
        $.post('api.php', form_data, function(data){
            if(data == true){
                location.reload();
            } else {
                console.log(data);
            }
        });
    });
</script>