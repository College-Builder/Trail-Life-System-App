<?php
require_once BASE_DIR . "global-modules/mysql/mysql.php";

class ValidateApiData
{
      private $host;
      private $user;
      private $password;
      private $database;
      private $mysql;

      public function __construct()
      {
            $this->host = $_ENV["SQL_HOST_GLOBAL_VALIDATE_API_DATA"];
            $this->user = $_ENV["SQL_USER_GLOBAL_VALIDATE_API_DATA"];
            $this->password = $_ENV["SQL_PASSWORD_GLOBAL_VALIDATE_API_DATA"];
            $this->database = $_ENV["SQL_DATABASE_GLOBAL_VALIDATE_API_DATA"];
            $this->mysql = new Mysql($this->host, $this->user, $this->password, $this->database);
      }

      public function validateUserPermission($sessionTable, $userTable, $token, $requiredPermission)
      {
            $sql = 'SELECT id FROM ' . $sessionTable . ' WHERE token = ?;';
            $params = array($token);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows == 0) {
                  return false;
            }

            $id = ($row = mysqli_fetch_assoc($result)) ? $row['id'] : "";
            
            $sql = 'SELECT id, permissao FROM ' . $userTable . ' WHERE id = ?;';
            $params = array($id);
            $result = $this->mysql->query($sql, $params);

            $permissao = ($row = mysqli_fetch_assoc($result)) ? $row['permissao'] : "";

            if (!in_array($permissao, $requiredPermission)) {
                  return false;
            }

            return true;
      }

      public function validateEmail($email)
      {
            if (!isset($email) || empty($email)) {
                  return false;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  return false;
            }

            return true;
      }
}
?>