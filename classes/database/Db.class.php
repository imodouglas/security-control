<?php

    class Db {
        private $dbHost = "localhost";
        private $dbName = "easywebs_scontrol";
        private $dbUser = "easywebs_user";
        private $dbPass = "EW0o9i8u7y6t";

        protected function conn(){
            $conn = new PDO('mysql:host='.$this->dbHost.'; dbname='.$this->dbName, $this->dbUser, $this->dbPass);
            return $conn;
        }
    }