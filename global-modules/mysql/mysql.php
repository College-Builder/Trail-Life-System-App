<?php
class Mysql
{
    private $conn;
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = array())
    {
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die("Error in query preparation: " . $this->conn->error);
        }

        if (!empty($params)) {
            $types = "";
            $values = array();

            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= "i"; // Integer
                } elseif (is_double($param)) {
                    $types .= "d"; // Double
                } else {
                    $types .= "s"; // String
                }

                $values[] = $param;
            }

            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();

        return $stmt->get_result();
    }
}
?>