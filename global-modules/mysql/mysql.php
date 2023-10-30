<?php
class Mysql {
    private static $conn;

    private static $host;
    private static $username;
    private static $password;
    private static $database;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        self::$conn = new mysqli(self::$host, $this->username, $this->password, $this->database);

        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    public static function query($sql, $params = array()) {
        $stmt = self::$conn->prepare($sql);

        if ($stmt === false) {
            die("Error in query preparation: " . self::$conn->error);
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
