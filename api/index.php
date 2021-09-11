<?php
    header('Content-Type: application/json');
    session_start();
    require '../includes/env.inc.php';

    spl_autoload_register('autoloader');

    function autoloader($class){
        $dir = array('../classes/controllers/', '../classes/models/', '../classes/views/', '../classes/database/');
        $ext = '.class.php';

        foreach($dir as $dir){
            $path = $dir.$class.$ext;
            if(file_exists($path)){
                include $path;
            }
            
        }
    }
    

    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $payout = new PayoutController();
    $account = new AccountController();

    if(isset($_POST['userid'], $_POST['plan'], $_POST['cmd']) && $_POST['cmd'] == "make-investment"){
        $planData = $plan->getPlan($_POST['userid']);
        if($planData !== false) {
            $expires = strtotime('+'.$planData['days'].' days');
            $result = $investment->doAddInvestment($_POST['userid'], $_POST['plan'], $expires);
            if($result == true){
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(false);
        } 
    }

    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "data"){
        $data = [];
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            $userData = $user->getUser($inv['user_id']);
            $data['investment'] = $inv;
            $data['plan'] = $plan;
            $data['user'] = $userData;
            // echo json_encode($plan->getPlan($inv['plan_id']));
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }

    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "confirm"){
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            $expires = strtotime('+'.$plan['days'].' days');
            $invUp = $investment->doUpdateInvestmentStatus($inv['id'], 'active', time(), $expires);
            if($invUp !== false){
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(false);
        }
    }


    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "complete"){
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            $payout = addPayout($_SESSION['user_session'], "Investment To Wallet", $plan['amount'], "complete");
            if($payout == true){
                $invUp = $investment->doUpdateInvestmentStatus($inv['id'], 'complete', $inv['activated_at'], $inv['expires_at']);
                echo json_encode($invUp);
            } else {
                echo json_encode(false);    
            }
        } else {
            echo json_encode(false);
        }
    }


    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "delete"){
        $result = $investment->doDeleteInvestment($_POST['investment']);
        if($result == true){
            echo json_encode(true);
        } else {
            echo json_encode(false);
        } 
    }

    if(isset($_POST['cmd']) && $_POST['cmd'] == "add-account"){
        $result = $account->doAddAccount($_POST['userid'], $_POST['bank'], $_POST['acctName'], $_POST['acctNo']);
        if($result == true){
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }