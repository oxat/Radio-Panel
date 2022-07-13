<?php
namespace Vendor;

class Database {
    /**
     * Default PDO options
     * @var array
     */
    private $options  = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false
    ];
    /**
     * Cache var
     */
    private $link;
    /**
     * Cache var
     */
    private $result;

    public function __construct() {
        try {
            if (!defined('DATABASE_USER') || !defined('DATABASE_PASS') || !defined('DATABASE_HOST') ||  !defined('DATABASE_NAME')) {
                throw Exception('Missing DB connection fields.');
            } else if (!defined('DATABASE_DRIVER') || !defined('DATABASE_CHARSET')) {
                throw Exception('Missing DB driver and/or charset.');
            }
            $conn  = DATABASE_DRIVER . ':';
            $conn .= 'host=' . DATABASE_HOST . ';';
            $conn .= 'dbname=' . DATABASE_NAME . ';';
            $conn .= 'charset=' . DATABASE_CHARSET . ';';
            $this->link = new \PDO($conn, DATABASE_USER, DATABASE_PASS, $this->options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Execute an query
     * 
     * @param  string $string [Query string]
     * @return mixed
     */
    public function query(string $string) {
        $this->result = $this->link->query($string);
        return $this->result;
    }

    /**
     * Fetch values on the database
     * 
     * @param  string $string [Query string]
     * @return mixed
     */
    public function fetch_array(string $string) {
        $this->query($string);
        $result = $this->result->fetchAll();
        return empty($result) ? array() : $result;
    }

    /**
     * Insert data to the database
     * 
     * @param  string $table [Table name]
     * @param  array $values [Fields and values]
     * @return mixed
     */
    public function insert(string $table, array $values) {
        $keys    = implode(", ", array_keys($values));
        $addAsks = substr(str_repeat("?, ", count($values)), 0, -2);
        $prepare = $this->link->prepare("INSERT INTO {$table} ({$keys}) VALUES ({$addAsks})");
        $prepare->execute(array_values($values));
        return $prepare;
    }

    /**
     * Update data in the database
     * 
     * @param  string $table [Table name]
     * @param  array $values [Fields and values]
     * @param  array $where [Where to update]
     * @return mixed
     */
    public function update(string $table, array $values, array $where) {
        list($keysC, $whereC) = [null, null];
        foreach ($values as $k => $v) {
            $keysC .= "{$k} = ?, ";
        }
        foreach ($where as $k => $v) {
            $whereC .= "{$k} = '{$v}' AND ";
        }
        list($keys, $where, $values) = [
            substr($keysC, 0, -2),
            substr($whereC, 0, -5),
            array_values($values),
        ];
        $prepare  = $this->link->prepare("UPDATE {$table} SET {$keys} WHERE {$where}");
        $prepare->execute(array_values($values));
        return $prepare;
    }

    /**
     * Search data in the database
     * 
     * @param  string $table [Table name]
     * @param  array $values [Field and value]
     * @return mixed
     */
    public function search(string $table, array $values) {
        if (count($values) < 2) {
            return false;
        }
        $result = $this->fetch_array("SELECT * FROM {$table} WHERE {$values[0]} LIKE '%{$values[1]}%'");
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    /**
     * Count rows of the table
     * 
     * @param  string $table [Table name]
     * @return integer
     */
    public function rowCount(string $table) {
        $result = $this->fetch_array("SELECT * FROM {$table}");
        return count($result);
    }

    /**
     * Count tables from the database
     * 
     * @return integer
     */
    public function tablesCount() {
        $result = $this->fetch_array("SHOW TABLES");
        return count($result);
    }

    /**
     * Get the last inserted
     * 
     * @return integer
     */
    public function lastInsertId() {
        return $this->link->lastInsertId();
    }
}
