<?php
class DBConnection {
    private $host = 'localhost'; // Database host
    private $user = 'root';      // Your MySQL database user
    private $pass = '';          // Your MySQL database password
    private $dbname = 'hrm_system'; // Your database name
    private $conn;

    public function connect() {
        // Create the connection
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            // Optionally, log the error to a file or monitoring system
            error_log("Database connection failed: " . $this->conn->connect_error);
            return false; // Return false or handle the error
        }

        // If you wish to set charset (recommended for utf-8)
        $this->conn->set_charset("utf8");

        return $this->conn;
    }

    // Optional function to close the connection
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
