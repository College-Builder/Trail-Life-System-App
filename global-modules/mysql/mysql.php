<?php
class Mysql {
    private static $host = "127.0.0.1";
    private static $conn;

    private static $username = "root";
    private static $password = "";
    private static $database = "trail_life";

    public function __construct($username, $password, $database) {
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
