<?php

class Api
{
    private $conn;
    public $id;
    public $name;
    public $password;
    public $age;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Show all records from DB
     *
     * @return PDOStatement
     */
    public function getInfoAll() : PDOStatement
    {
        $sql = <<<SQL
            SELECT *
            FROM inet
        SQL;

        $query = $this->conn->prepare($sql);
        $query->execute();

        return $query;
    }

    /**
     * Show one record from DB
     *
     * @return void
     */
    public function getInfoOne() : void
    {
        $sql = <<<SQL
            SELECT
            id, name, password, age
            FROM inet
            WHERE name = ?
        SQL;

        $query = $this->conn->prepare($sql);

        $query->bindParam(1, $this->name);

        $query->execute();

        $row = $query->fetch();

        $this->id = $row['id'];
        $this->password = $row['password'];
        $this->age = $row['age'];
    }

    /**
     * Insert record to DB
     *
     * @return bool
     */
    public function insert() : bool
    {
        $sql = <<<SQL
            INSERT INTO inet
            (name, password, age)
            VALUES (:name, :password, :age)
        SQL;

        $query = $this->conn->prepare($sql);

        $users = [
            'name' => $this->name,
            'password' => $this->password,
            'age' => $this->age,
        ];

        $this->bind($query, $users)->execute();

        return true;
    }

    /**
     * Update record in DB by id
     *
     * @return bool
     */
    public function update() : bool
    {
        $sql = <<<SQL
            UPDATE inet
            SET name = :name,
            password = :password,
            age = :age
            WHERE id = :id
        SQL;

        $query = $this->conn->prepare($sql);

        $users = [
            'name' => $this->name,
            'password' => $this->password,
            'age' => $this->age,
            'id' => $this->id,
        ];

        $this->bind($query, $users)->execute();

        return true;
    }

    /**
     * Delete record in DB by username
     *
     * @return bool
     */
    public function delete() : bool
    {
        $sql = <<<SQL
            DELETE FROM inet
            WHERE name = :name
        SQL;

        $query = $this->conn->prepare($sql);

        $users = [
            'name' => $this->name,
        ];

        $this->bind($query, $users)->execute();

        return true;
    }

    /**
     * Authentication by username and password
     *
     * @return bool
     */
    public function auth(): bool
    {
        $sql = <<<SQL
            SELECT name, password
            FROM inet
            WHERE
            name = :name
        SQL;

        $query = $this->conn->prepare($sql);

        $query->bindParam(1, $this->name);
        $query->execute();

        $row = $query->fetch();

        if (!$row || $row['password'] !== $this->password) {
            return false;
        }

        return true;
    }

    /**
     * Variable to PDO type
     *
     * @param  mixed  $value
     *
     * @return int PDO type
     */
    public function typeToParam(mixed $value): int
    {
        switch ($type = gettype($value)) {
            case 'boolean':
                return PDO::PARAM_BOOL;

            case 'integer':
                return PDO::PARAM_INT;

            case 'NULL':
                return PDO::PARAM_NULL;

            case 'string':
                return PDO::PARAM_STR;

            default:
                throw new Exception("unsupported type - {$type}");
        }
    }

    /**
     * Bind values to PDO statement
     *
     * @param  PDOStatement $statement
     * @param  array        $data
     *
     * @return PDOStatement
     */
    public function bind(PDOStatement $statement, array $data): PDOStatement
    {
        foreach ($data as $key => $value) {
            $statement->bindValue($key, $value, $this->typeToParam($value));
        }

        return $statement;
    }
}
