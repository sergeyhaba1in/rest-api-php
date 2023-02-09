<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applicatinon/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../classes/DataBase.php';
include_once '../classes/Api.php';

$db = new DataBase();
$conn = $db->connect();

$post = new Api($conn);

$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;
$post->name = $data->name;
$post->password = $data->password;
$post->age = $data->age;

if ($post->update()) {
    echo json_encode(array('message' => 'Updated.'));
} else {
    echo json_encode(array('message' => 'Not updated.'));
}
