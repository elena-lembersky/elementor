<?php

class Service {
    public function getUsersInfo() {

        $db = new SQLite3('users.db');
        $results = $db->query("SELECT * FROM users");

        $row = array();
        $i = 0;

        while ($res = $results->fetchArray(SQLITE3_ASSOC)) {
            if(!isset($res['id'])) continue;
              $row[$i]['ID'] = $res['id'];
              $row[$i]['User Name'] = $res['name'];
              $row[$i]['Last Login Time'] = $res['login_last'];
              $row[$i]['User IP'] = $res['user_ip'];
              $row[$i]['Last Updated'] = $res['last_updated'];
              $row[$i]['Is Live'] = $res['login_live'];
              $i++;
        }
        $myJSON = json_encode($row);
        echo $myJSON;
        $db->close();
    }

    public function getUserInfo($id) {
        $db = new SQLite3('users.db');
        $results = $db->query("SELECT * FROM users WHERE id = {$id}");
        $row = array();
        $i = 0;
        while ($res = $results->fetchArray(SQLITE3_ASSOC)) {
            if(!isset($res['id'])) continue;
              $row[$i]['ID'] = $res['id'];
              $row[$i]['User Agent'] = $res['user_agent'];
              $row[$i]['Register Time'] = $res['register_time'];
              $row[$i]['Logins Count'] = $res['login_count'];
              $i++;
        }
        if ($row) {
            echo json_encode($row);
        }
        else {
            echo json_encode('{"err":"Something went wrong"}');
        }
        $db->close();
    }

    public function login() {
       session_start();
       $inputJSON = file_get_contents('php://input');
       $postResult = json_decode( $inputJSON );
       header('Content-Type: application/json');

       $sql ="SELECT * FROM users WHERE name = '{$postResult->name}'";
       $db = new SQLite3('users.db');
       $results = $db->query($sql);

       while ($res = $results->fetchArray(SQLITE3_ASSOC)) {
          $id=$res['id'];
          $username=$res["name"];
          $password=$res['password'];
          $login_counter=$res['login_count'];
       }

        if ($id!="") {
            if ($password==$postResult->password) {
                $_SESSION["login"]=$username;
                //TODO add md5
                setcookie("user_name", $username, time() + (86400 * 30), "/");
                setcookie("user_id", $id, time() + (86400 * 30), "/");
                $this->updateUserInfo($id,$login_counter);
                echo json_encode('{"ok":"Wellcome"}');
            }
            else {
                echo json_encode('{"err":"Wrong Password"}');
            }
        }
        else{
            echo json_encode('{"err":"User not exist"}');
        }

        $db->close();
    }

    public function logout($id) {
        session_start();
        $id = (int)$id;
        $db = new SQLite3('users.db');

        $sql ="
        UPDATE users
        SET
        last_updated = datetime('now','localtime'),
        login_live = 0
        WHERE id = {$id}";
        $query = $db->exec($sql);
        if ($query) {
            unset($_COOKIE['user_name']);
            unset($_COOKIE['user_id']);
            setcookie('user_name', null, -1, '/');
            setcookie('user_id', null, -1, '/');
            echo json_encode('{"ok":"Logged Out"}');
        }
        else {
            echo json_encode('{"err":"Something went wrong"}');
        }
        $db->close();
        unset($_SESSION["login"]);
        session_destroy();
    }

    public function updateUserInfo($id,$login_counter) {
        $login_counter = (int)$login_counter;
        ++$login_counter;
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $this->get_client_ip();
        $db = new SQLite3('users.db');
        $sql ="
        UPDATE users
        SET
        login_count = {$login_counter},
        login_last = datetime('now','localtime'),
        login_live = 1,
        user_agent = '{$userAgent}',
        user_ip = '{$ip}'
        WHERE id = {$id}";
        $query = $db->exec($sql);
        if ($query) {
            //echo 'Amount of updated rows: ', $db->changes();
        }
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}