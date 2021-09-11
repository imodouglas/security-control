<div class="modal-overlay" id="invest-overlay"></div>
<div class="modal-container" id="invest-modal" align="center">
    <div class="modal-card">
        <div class="p10" style="border-bottom:#333 thin solid">
            <b> SELECT AN INVESTMENT PLAN </b>
            <span class="clickable" style="float:right" title="Close" onclick="closeInvest()"> [x] </span>
        </div>
        <form id="make-investment" action="" method="post">
            <div class="p10">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userId; ?>" />
                <input type="hidden" name="cmd" id="userid" value="make-investment" />
                <select name="plan" id="plan" class="form-control" required>
                    <?php 
                        foreach ($plan->getPlans('active') AS $plan){
                            echo "<option value='".$plan['id']."'>".$plan['name']." - N".number_format($plan['amount'])." for ".$plan['percentage']."% in ".$plan['days']." days </option>";
                        }
                    ?>
                </select>
            </div>
            <div class="p10" align="center">
                <button type="submit" id='inv-submit' class="btn btn-success form-control"> Continue &nbsp;<i class="fas fa-arrow-right"></i> </button>
            </div>
        </form>
    </div>
</div>

<script>
    const closeInvest = () => {
        $("#invest-overlay").slideUp('fast');
        $("#invest-modal").slideUp('fast');
    }

    $("#make-investment").submit((e) => {
        e.preventDefault();
        $("#inv-submit").html("<i class='fas fa-spinner fa-spin'></i> &nbsp;Please wait...")
        $.post('api.php', $("#make-investment").serialize(), function(data){
            console.log(data);
            if(data == true){
                alert("Investment Done! Make payment to activate.");
                window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
            } else {
                alert("An error occured! Please try again.");
                $("#inv-submit").html("Continue &nbsp;<i class='fas fa-arrow-right'></i>")
            }
        });

        // console.log($("#make-investment").serialize());
    });
</script>