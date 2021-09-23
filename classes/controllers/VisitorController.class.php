<?php

class VisitorController extends Visitor {

    /** Create User Account */
    public function doCreate($fname, $address, $visiting, $phone, $created_by){
        $result = $this->create($fname, $address, $visiting, $phone, $created_by);
        if($result == false){
            return $result;
        } else {
            return $result;
        }
    }

    /** Delete User Account */
    public function doDelete($id){
        $result = $this->delete($id);
        return $result;
    }

    /** Update User Account */
    public function doUpdateAll($id, $fname, $address, $visiting, $arrived_at, $departed_at, $status){
        return $this->updateAll($id, $fname, $address, $visiting, $arrived_at, $departed_at, $status);
    }


    /** Get Data by ID */
    public function getDataById($id){
        $data = $this->dataById($id);
        return $data;
    }

    /** Get Data by Email */
    public function getDataByEmail($email){
        $data = $this->dataByEmail($email);
        return $data;
    }

    /** Get All Users Count */
    public function getVisitorCount($start, $end){
        $data = $this->visitorCount($start, $end);
        return $data;
    }

    /** Get All Users Data */
    public function getVisitors($start, $end){
        $data = $this->visitors($start, $end);
        return $data;
    }

    /** Get All Visitor Users Count */
    public function getUserVisitorCount($id, $start, $end){
        $data = $this->userVisitorCount($id, $start, $end);
        return $data;
    }

    /** Get All Visitor Users Data */
    public function getUserVisitors($id, $start, $end){
        $data = $this->userVisitors($id, $start, $end);
        return $data;
    }

    /** Signin */
    public function doSignin($id){
        $data = $this->signin($id);
        return $data;
    }

    /** Signout */
    public function doSignout($id){
        $data = $this->signout($id);
        return $data;
    }

    /** Approve Visitor */
    public function doApproveVisitor($visitorId, $userId){
        $data = $this->approveVisitor($visitorId, $userId);
        return $data;
    }


    /** Reject Visitor */
    public function doRejectVisitor($visitorId, $userId){
        $data = $this->rejectVisitor($visitorId, $userId);
        return $data;
    }


}