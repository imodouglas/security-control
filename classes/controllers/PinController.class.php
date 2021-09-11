<?php 

class PinController extends Pin {

    /** Check if user has row in pin table */
    public function checkPin($userID){
        return $this->doCheckPin($userID);
    }

    /** Confirm if pin is correct */
    public function confirmPin($userID, $pin){
        return $this->doConfirmPin($userID, $pin);
    }

    /** Create a New Pin */
    public function setPin($userID){
        return $this->doSetPin($userID);
    }

    /** Retreive User Pin */
    public function getPin($userID){
        return $this->doGetPin($userID);
    }

    /** Refresh Pin */
    public function refreshPin($userID){
        return $this->doRefreshPin($userID);
    }

}