<?php

// Include router class
include('Route.php');
require_once('service.php');

Route::add('/',function(){
    session_start();
    if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
        include('./static/templates/login.html');
    }
    else {
        include('./static/templates/index.html');
    }
});

Route::add('/logout/([0-9]*)',function($uid){
    $Service = new Service();
    $Service->logout($uid);
});

Route::add('/users',function(){
    $Service = new Service();
    $Service->getUsersInfo();
});

Route::add('/user/([0-9]*)',function($uid){
    $Service = new Service();
    $Service->getUserInfo($uid);
});

Route::add('/login',function(){
    $Service = new Service();
    $Service->login();
},'post');

// Route::add('/login',function(){
// //     include 'login.php';
// //     login();
//     $Service = new Service();
//     $Service->login();
// });

Route::add('/create-users',function(){
    require('table-creator.php');
});
Route::run('/');

