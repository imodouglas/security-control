<?php 
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="row m0">
                    <div class="col-sm-12">
                        <div class="header-title-banner p10">
                            <h4> Investment </h4>
                        </div>
                        <div style="padding-top:10px">
                            <table style="width:100%">
                                <tr>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Investor
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Plan / Amount
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Creation Date
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Activation Date
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Status
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Action
                                    </th>
                                </tr>
                                <?php 
                                    foreach($investment->getTotalInvestments("data") AS $investment){ 
                                        $userInfo = $user->getUser($investment['user_id']);
                                        $planInfo = $plan->getPlan($investment['plan_id']);
                                ?>
                                    <tr>
                                        <td style="padding:10px;border-bottom:#ccc thin solid">
                                           <a href="user/<?php echo $userInfo['id']; ?>" rel="noopener noreferrer"> <?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?> </a>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $planInfo['name']." Plan (".$planInfo['amount'].")"; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo date("d/m/Y - h:ia", $investment['created_at']); ?>   
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo date("d/m/Y - h:ia", $investment['activated_at']); ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $investment['status']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <button class="btn btn-primary" style="padding:5px 8px; font-size:10px" title="View Investment Investment" onclick="showInvestment(<?php echo $userInfo['id']; ?>)"> <i class="fas fa-eye"></i> </button>
                                            <?php if($investment['status'] == "pending"){ ?>
                                                <button class="btn btn-success" style="padding:5px 8px; font-size:10px" title="Activate Investment" onclick="activateInvestment(<?php echo $investment['id']; ?>)"> <i class="fas fa-play"></i> </button>
                                                <button class="btn btn-danger" style="padding:5px 8px; font-size:10px" title="Delete Investment" onclick="deleteInvestment(<?php echo $investment['id']; ?>)"> <i class="fas fa-times"></i> </button>
                                            <?php } else if($investment['status'] == "active"){ ?>
                                                <button class="btn btn-dark" style="padding:5px 8px; font-size:10px" title="Stop Investment" onclick="deactivateInvestment(<?php echo $investment['id']; ?>)"> <i class="fas fa-stop"></i> </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const showInvestment = (userId) =>{
        window.location ="investments/"+userId;
    }

    const activateInvestment = (id) => {
        let formData = "investment="+id+"&cmd=confirm";
        $.post("../api.php", formData, function(result){
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
        $.post("../api.php", formData, (result)=>{
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