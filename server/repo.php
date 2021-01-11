<?php

class Repo {
    private $db;

    private function connectDB() {
       $this->db = new SQLite3('users.db');
    }

    public function getAllUsers() {
        $this->connectDB();
        $result = $this->db->query("SELECT id AS 'ID',
        name AS 'User Name',
        login_last AS 'Last Login Time',
        user_ip AS 'User IP',
        last_updated AS 'Last Updated',
        login_live AS 'Is Live'
         FROM users");
        $row = array();
        while ($res = $result->fetchArray(1)) {
            array_push($row, $res);
        }
        $this->closeDB();
        return $row;
    }

    private function closeDB() {
       $this->db->close();
    }
}