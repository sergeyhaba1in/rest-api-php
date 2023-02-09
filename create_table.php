<?php

require_once 'classes/DataBase.php';

$db = new DataBase();
$conn = $db->connect();

$sql = <<<SQL
    CREATE TABLE inet (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(40) NOT NULL,
        `password` VARCHAR(40) NOT NULL,
        `age` INT NOT NULL
    )
SQL;

$query = $conn->prepare($sql);
$query->execute();
