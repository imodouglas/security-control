<?php 

class Visitor extends Config {

   /** Create Visitor */
    protected function create($fname, $address, $visiting, $phone, $created_by){
        $query = $this->conn()->prepare("INSERT INTO visitors (fname, address, visiting, phone, created_at, created_by) VALUES (?,?,?,?,?,?)");
        $query->execute([$fname, $address, $visiting, $phone, time(), $created_by]);
        if($query){
            return $this->conn()->lastInsertId();
        } else { return false; }
    }

    /** Update Visitor Model */
    protected function updateAll($id, $fname, $address, $phone, $visiting, $arrived_at, $departed_at, $status){
        $query = $this->conn()->prepare("UPDATE visitors SET fname=?, address=?, phone=?, visiting=?, arrived_at=?, departed_at=?, status=? WHERE id = ?");
        $query->execute([$id, $fname, $address, $phone, $visiting, $arrived_at, $departed_at, $status, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Get A Data by Email */
    protected function dataByEmail($data){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE email = ?");
        $query->execute([$data]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get A User Data by Id Model */
    protected function dataById($id){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE id = ?");
        $query->execute([$id]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get Visitors Count Model */
    protected function visitorCount($start, $end){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE created_at BETWEEN ? AND ?");
        $query->execute([$start, $end]);
        $data = $query->rowCount();
        return $data;
    }

    /** Get Visitors Model */
    protected function visitors($start, $end){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE created_at BETWEEN ? AND ?");
        $query->execute([$start, $end]);
        $data = $this->allResults($query);
        return $data;
    }

    /** Get User Visitors Count Model */
    protected function userVisitorCount($id, $start, $end){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE visiting = ? AND (created_at BETWEEN ? AND ?)");
        $query->execute([$id, $start, $end]);
        $data = $query->rowCount();
        return $data;
    }

    /** Get User Visitors Model */
    protected function userVisitors($id, $start, $end){
        $query = $this->conn()->prepare("SELECT * FROM visitors WHERE visiting = ? AND (created_at BETWEEN ? AND ?)");
        $query->execute([$id, $start, $end]);
        $data = $this->allResults($query);
        return $data;
    }

    /** Get All Users Model */
    protected function allVisits(){
        $query = $this->conn()->prepare("SELECT * FROM visitors");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }


    /** signin Model */
    protected function signin($id){
        $query = $this->conn()->prepare("UPDATE visitors SET arrived_at = ? WHERE id = ?");
        $query->execute([time(), $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** signout Model */
    protected function signout($id){
        $query = $this->conn()->prepare("UPDATE visitors SET departed_at = ? WHERE id = ?");
        $query->execute([time(), $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Update Status Model */
    protected function updateStatus($data, $status){
        $query = $this->conn()->prepare("UPDATE visitors SET status = ? WHERE id = ?");
        $query->execute([$status, $data]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Delete User */
    protected function delete($id){
        $query = $this->conn()->prepare("DELETE FROM visitors WHERE id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Approve Visitor */
    protected function approveVisitor($visitorId, $userId){
        $query = $this->conn()->prepare("UPDATE visitors SET status = ? WHERE id = ? AND visiting = ?");
        $query->execute(['approved', $visitorId, $userId]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Reject Visitor */
    protected function rejectVisitor($visitorId, $userId){
        $query = $this->conn()->prepare("UPDATE visitors SET status = ? WHERE id = ? AND visiting = ?");
        $query->execute(['rejected', $visitorId, $userId]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


}