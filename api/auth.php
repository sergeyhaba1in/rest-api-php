<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applicatinon/json');

include_once '../classes/DataBase.php';
include_once '../classes/Api.php';

$db = new DataBase();
$conn = $db->connect();

$post = new Api($conn);

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm=\'Private Area\'');
    header('HTTP/1.0 401 Unauthorized');

    echo 'Sorry, you need proper crednetials.';

    exit;
} else {
    $post->name = $_SERVER['PHP_AUTH_USER'];
    $post->password = $_SERVER['PHP_AUTH_PW'];

    if ($post->auth()) {
        echo 'You are authorized.';
    } else {
        header('WWW-Authenticate: Basic realm=\'Private Area\'');
        header('HTTP/1.0 401 Unauthorized');

        echo 'Authorization error.';
    }
}
