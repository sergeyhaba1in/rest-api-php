<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applicatinon/json');

include_once '../classes/DataBase.php';
include_once '../classes/Api.php';

$db = new DataBase();
$conn = $db->connect();

$post = new Api($conn);

$result = $post->getInfoAll();

$num = $result->rowCount();

if ($num > 0) {
    $postsArr = array();
    $postsArr['data'] = array();

    while ($row = $result->fetch()) {
        extract($row);

        $postItem = array(
            'id' => $id,
            'name' => $name,
            'password' => $password,
            'age' => $age,
        );

        array_push($postsArr['data'], $postItem);
    }

    echo json_encode($postsArr);
} else {
    echo json_encode(
        array('message' => 'No records found.')
    );
}
