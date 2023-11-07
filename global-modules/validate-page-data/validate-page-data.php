<?php
require_once BASE_DIR . "global-modules/mysql/mysql.php";

class ValidatePageData
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

      public function validatePageAuth()
      {
            if (isset($_COOKIE['a_auth'])) {
                  $sql = 'SELECT id, token FROM usuarios_adm_session WHERE token = ?;';
                  $params = array($_COOKIE['a_auth']);
                  $result = $this->mysql->query($sql, $params);

                  if ($result->num_rows == 0) {
                        header("Location: /system/administracao/login/");
                        exit();
                  }
            } else {
                  header("Location: /system/administracao/login/");
                  exit();
            }
      }
}
?>