<?php

include('repo.php');

class Service {

    function __construct(){}

    public function getUsersInfo() {
        $repo = new Repo();
        $results = $repo->getAllUsers();
        $myJSON = json_encode($results);
        echo $myJSON;
    }

    public function getUserInfo($id) {
        $repo = new Repo();
        $results = $repo->getAddUserInfo($id);
        $myJSON = json_encode($results);
        echo $myJSON;
    }

    public function login() {
        session_start();
        $inputJSON = file_get_contents('php://input');
        $postResult = json_decode( $inputJSON );
        header('Content-Type: application/json');
        $userName = trim($postResult->name);
        $userPassword = trim($postResult->password);

        $repo = new Repo();
        $results = $repo->login($userName);
        $id=$results['id'];
        $password = $results['password'];
        $login_counter = $results['login_count'];

        if ($id!="") {
            if ($password==$userPassword) {
                $_SESSION["login"]=$userName;
                //TODO add md5 for user password
                setcookie("user_name", $userName, time() + (86400 * 30), "/");
                setcookie("user_id", $id, time() + (86400 * 30), "/");
                $this->updateUserInfo($id,$login_counter);
                echo json_encode('{"ok":"Wellcome"}');
            }
            else {
                //TODO add errors to constants
                echo json_encode('{"err":"Wrong Password"}');
            }
        }
        else{
            echo json_encode('{"err":"User not exist"}');
        }
    }

    public function logout($id) {
        session_start();
        $id = (int)$id;
        $repo = new Repo();
        $results = $repo->logout($id);

        if ($results) {
            unset($_COOKIE['user_name']);
            unset($_COOKIE['user_id']);
            setcookie('user_name', null, -1, '/');
            setcookie('user_id', null, -1, '/');
            echo json_encode('{"ok":"Logged Out"}');
        }
        else {
            echo json_encode('{"err":"Something went wrong"}');
        }

        unset($_SESSION["login"]);
        session_destroy();
    }

    public function updateUserInfo($id,$login_counter) {
        $login_counter = (int)$login_counter;
        ++$login_counter;
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $this->get_client_ip();
        $repo = new Repo();
        $results = $repo->updateLoginInfo($id,$login_counter,$userAgent,$ip);
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