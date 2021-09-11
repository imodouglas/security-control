<?php

class UserController extends User {

    /** Login function */
    public function doLogin($uname, $pword){
        $data = $this->login($uname, $pword);
        return $data;
    }

    /** Create User Account */
    public function doCreateUser($fname, $mname, $lname, $email, $phone, $password, $role){
        $result = $this->createUser($fname, $mname, $lname, $email, $phone, $password, $role);
        if($result == false){
            return $result;
        } else {
            return $result;
        }
    }

    /** Delete User Account */
    public function doDeleteUser($id){
        $result = $this->deleteUser($id);
        return $result;
    }

    /** Update User Account */
    public function doUpdateUser($id, $firstName, $lastName, $email, $phone){
        return $this->updateUser($id, $firstName, $lastName, $email, $phone);
    }

    /** Change Password */
    public function getChangePassword($id, $password){
        return $this->changePassword($id, md5($password));
    }

    /** Check Password */
    public function getCheckPassword($id, $password){
        return $this->checkPassword($id, md5($password));
    }

    /** Update User Status */
    public function getUpdateStatus($id, $status){
        $data = $this->updateStatus($id, $status);
        return $data;
    }


    /** Get Users Data by ID */
    public function getUser($id){
        $data = $this->userById($id);
        return $data;
    }

    /** Get Users Data by Email */
    public function userByEmail($email){
        $data = $this->userData($email);
        return $data;
    }

    /** Get All Users Count */
    public function getTotalUsers(){
        $data = $this->totalUsers();
        return $data;
    }

    /** Get All Users Data */
    public function getAllUsers(){
        $data = $this->allUsers();
        return $data;
    }

    public function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

}