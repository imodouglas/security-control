<?php 

class User extends Config {

    /** Login Model */
    protected function login($email, $pword){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $query->execute(array($email, md5($pword)));
        $data = $this->singleResult($query);
        return $data;
    }

    /** Create User Model */
    protected function createUser($fname, $mname, $lname, $email, $phone, $password, $role){
        $query = $this->conn()->prepare("INSERT INTO users (fname, mname, lname, email, phone, password, role, created_at) VALUES (?,?,?,?,?,?,?,?)");
        $query->execute([$fname, $mname, $lname, $email, $phone, md5($password), $role, time()]);
        if($query){
            return $this->conn()->lastInsertId();
        } else {
            return false;
        }
    }

    /** Update User Model */
    protected function updateUser($id, $firstName, $lastName, $email, $phone){
        $query = $this->conn()->prepare("UPDATE users SET fname=?, lname=?, email=?, phone=? WHERE id = ?");
        $query->execute([$firstName, $lastName, $email, $phone, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Get A User Data by Email Model */
    protected function userData($data){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$data]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get A User Data by Id Model */
    protected function userById($id){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get Total Number of Users Model */
    protected function totalUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users");
        $query->execute();
        $data = $query->rowCount();
        return $data;
    }

    /** Get All Users Model */
    protected function allUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }

    /** Check User Password */
    protected function checkPassword($id, $password){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id = ? AND password = ?");
        $query->execute([$id, $password]);
        if($query->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    /** Change User Password */
    protected function changePassword($id, $password){
        $query = $this->conn()->prepare("UPDATE users SET password = ? WHERE id = ?");
        $query->execute([$password, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Update User Status Model */
    protected function updateStatus($data, $status){
        $query = $this->conn()->prepare("UPDATE users SET status = ? WHERE id = ?");
        $query->execute([$status, $data]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Delete User */
    protected function deleteUser($acctNo){
        $query = $this->conn()->prepare("DELETE FROM users WHERE id = ?");
        $query->execute([$acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


}