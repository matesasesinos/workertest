<?php

namespace Ma\Worker\Shared;

use PDO;
use PDOException;

final class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    private $pdo;

    public function __construct($host, $username, $password, $dbname, $charset = 'utf8')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->charset = $charset;

        $this->connect();
    }

    private function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    // Execute a custom query with optional parameters
    public function query($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    // Retrieve and return the first row from a query result as an associative array
    public function get($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retrieve and return all rows from a query result as an array of associative arrays
    public function getAll($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert data into a table
    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($query, $data);
    }

    // Update data in a table based on a condition
    public function update($table, $data, $condition)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $set = implode(', ', $set);
        $query = "UPDATE $table SET $set WHERE $condition";
        return $this->query($query, $data);
    }

    // Delete rows from a table based on a condition
    public function delete($table, $condition, $params = [])
    {
        $query = "DELETE FROM $table WHERE $condition";
        return $this->query($query, $params);
    }

    // Search for rows in a table based on a column value using a LIKE condition
    public function search($table, $column, $value)
    {
        $value = '%' . $value . '%';
        $query = "SELECT * FROM $table WHERE $column LIKE :value";
        return $this->getAll($query, [':value' => $value]);
    }

    // Retrieve and return a single row from a table based on a condition
    public function find($table, $condition, $params = [])
    {
        $query = "SELECT * FROM $table WHERE $condition";
        return $this->get($query, $params);
    }

    // Perform a bulk insert of data into a table
    public function insertBulk($table, $data)
    {
        if (empty($data)) {
            return false;
        }

        $keys = implode(', ', array_keys($data[0])); // Get column names from the first element
        $values = [];

        foreach ($data as $row) {
            $placeholders = array_fill(0, count($row), '?');
            $values[] = '(' . implode(', ', $placeholders) . ')';
        }

        $query = "INSERT INTO $table ($keys) VALUES " . implode(', ', $values);

        $stmt = $this->pdo->prepare($query);

        $index = 1;
        foreach ($data as $row) {
            foreach ($row as $value) {
                $stmt->bindValue($index, $value);
                $index++;
            }
        }

        return $stmt->execute();
    }
}
