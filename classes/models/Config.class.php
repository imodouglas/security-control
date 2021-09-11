<?php 

class Config extends Db {
    /** Query Processors */
    protected function singleResult($query){
        if($query->rowCount() > 0){
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        } else {
            return false;
        }
    }


    protected function allResults($query){
        if($query->rowCount() > 0){
            $data = $query->fetchAll();
            return $data;
        } else {
            return false;
        }
    }
}