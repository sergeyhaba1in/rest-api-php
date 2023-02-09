<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applicatinon/json');

include_once '../classes/DataBase.php';
include_once '../classes/Api.php';

$db = new DataBase();
$conn = $db->connect();

$post = new Api($conn);

$post->name = isset($_GET['name']) ? $_GET['name'] : die();

$post->readSingle();

$postArr= array(
    'id' => $post->id,
    'name' => $post->name,
    'password' => $post->password,
    'age' => $post->age,
);

print_r(json_encode($postArr));
