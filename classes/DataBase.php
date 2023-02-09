<?php

use PDO;

class DataBase
{
    /**
     * Connect to DB
     *
     * @return PDO on success
     */
    public function connect() : PDO
    {
        $params = [
            'host' => 'sandbox-db',
            'database' => 'test',
            'user' => 'root',
            'pass' => '123',
        ];

        $db = new PDO("mysql:host={$params['host']};dbname={$params['database']};charset=utf8", $params['user'], $params['pass'], [
            // use exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // get arrays
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // better prevention against SQL injections
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $db;
    }
}
