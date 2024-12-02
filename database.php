<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'library_system';
    private $username = 'root';
    private $password = '';
    private $pdo = null;

    /**
     * Connect to the database.
     *
     * @return PDO
     */
    public function connect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                    $this->username,
                    $this->password
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database Connection Failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }

    /**
     * Close the connection.
     */
    public function disconnect()
    {
        $this->pdo = null;
    }
}

