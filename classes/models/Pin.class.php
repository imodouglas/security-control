<?php

class Pin extends Config {

    /** Check if user has row in pin table */
    protected function doCheckPin($userID){
        $query = $this->conn()->prepare("SELECT * FROM pins WHERE `user_id` = ?");
        $query->execute([$userID]);
        return $query->rowCount();
    }

    /** Confirm if pin is correct */
    protected function doConfirmPin($userID, $pin){
        $query = $this->conn()->prepare("SELECT * FROM pins WHERE `user_id` = ? AND pin = ?");
        $query->execute([$userID, $pin]);
        return $query->rowCount();
    }

    /** Create a New Pin */
    protected function doSetPin($userID){
        $pin = rand(1111,9999);
        $query = $this->conn()->prepare("INSERT INTO pins (user_id, pin, created_at, expires_at) VALUES (?,?,?,?)");
        $query->execute([$userID, $pin, time(), (time() + (60*15))]);
        if($query){ return $pin; } else { return 0; }
    }

    /** Retreive User Pin */
    protected function doGetPin($userID){
        $query = $this->conn()->prepare("SELECT * FROM pins WHERE `user_id` = ?");
        $query->execute([$userID]);
        if($query->rowCount() > 0){
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return 0;
        }
    }

    /** Refresh Pin */
    protected function doRefreshPin($userID){
        $pin = rand(1111,9999);
        $query = $this->conn()->prepare("UPDATE pins SET pin=?, created_at=?, expires_at=? WHERE `user_id` = ?");
        $query->execute([$pin, time(), (time() + (60*15)), $userID]);
        if($query){ return $pin; } else { return 0; }
    }
    
}