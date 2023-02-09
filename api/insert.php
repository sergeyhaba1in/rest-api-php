<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applicatinon/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../classes/DataBase.php';
include_once '../classes/Api.php';

$db = new DataBase();
$conn = $db->connect();

$post = new Api($conn);

$data = json_decode(file_get_contents("php://input"));

$post->name = $data->name;
$post->password = $data->password;
$post->age = $data->age;

if ($post->insert()) {
    echo json_encode(['message' => 'Record inserted to DB']);
} else {
    echo json_encode(['message' => 'Record not inserted DB.']);
}
