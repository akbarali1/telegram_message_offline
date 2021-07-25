<?php
ob_start();
session_start([
    'cookie_lifetime' => 86400,
]);
// PASSWORD ga md5da ikki marta heshlangan parolni yozing
// echo md5(md5("buparol"));
define('PASSWORD', '7b00f8fc9bd0b49025a4c5e09b8ebed3');
define('MAIN_DIR', '..');
define('ACCESS_IP', '');

function getClientIP()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        return  $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER["REMOTE_ADDR"];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    return '';
}

if (empty(ACCESS_IP) === false && ACCESS_IP != getClientIP()) {
    die('Your IP address is not allowed to access this page.');
}

if (empty($_SESSION['login'])) {
    if (!$loginpage) {
        header('Location: ./login.php');
        exit;
    }
}
