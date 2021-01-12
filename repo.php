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

    public function getAdditionalUserInfo($id) {
        $this->connectDB();
        $result = $this->db->query("SELECT
        id AS 'ID',
        user_agent AS 'User Agent',
        register_time AS 'Register Time',
        login_count AS 'Logins Count'
         FROM users WHERE id = {$id}");
        $row = array();
        while ($res = $result->fetchArray(1)) {
            array_push($row, $res);
        }
        $this->closeDB();
        return $row;
    }

    public function login($userName) {
        $this->connectDB();
        $result = $this->db->query("SELECT * FROM users WHERE name = '{$userName}'");
        $row = array();
        while ($res = $result->fetchArray(1)) {
            array_push($row, $res);
        }
        $this->closeDB();
        return $row[0];
    }

    public function logout($id) {
        $this->connectDB();
        $result = $this->db->exec("UPDATE users
        SET
        last_updated = datetime('now','localtime'),
        login_live = 0
        WHERE id = {$id}");
        return $result;
        $this->closeDB();
    }

    public function updateLoginInfo($id,$login_counter,$userAgent,$ip) {
        $this->connectDB();
        $result = $this->db->exec("
            UPDATE users
            SET
            login_count = {$login_counter},
            login_last = datetime('now','localtime'),
            login_live = 1,
            user_agent = '{$userAgent}',
            user_ip = '{$ip}'
            WHERE id = {$id}
        ");
        //TODO add fallback for errors
        if ($result) {
            //echo 'Amount of updated rows: ', $db->changes();
        }
        //return $result;
        $this->closeDB();
    }

    private function closeDB() {
       $this->db->close();
    }
}