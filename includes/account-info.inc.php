<div style="margin:0; padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid; width:100%" class="row">
    <div class="col-sm-4" align="center">
        <strong> <?php echo $user['fname']." ".$user['lname']; ?> </strong> - <?php echo $user['acctNo']; ?>
    </div>
    <div class="col-sm-4" align="center">
        <!-- <strong>Account No: </strong> <?php echo $userData['acctNo']; ?> -->
    </div>
    <div class="col-sm-4" align="center">
        <strong>Balance: </strong> <?php echo "N".number_format($account['balance'],2); ?>
    </div>
</div>