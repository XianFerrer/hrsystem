<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'hrm_db';

    public function connection() {
        $conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
}
?>