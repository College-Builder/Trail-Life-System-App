<?php
require_once BASE_DIR . "global-modules/mysql/mysql.php";
require_once BASE_DIR . "global-modules/cypher/cypher.php";

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
            $token = $_COOKIE['a_auth'];

            if (isset($token)) {
                  $id = explode('-', $token)[0];
                  $token = explode('-', $token)[1];

                  $sql = 'SELECT id, token FROM usuarios_adm_session WHERE id = ?;';
                  $params = array($id);
                  $result = $this->mysql->query($sql, $params);

                  while ($row = $result->fetch_assoc()) {
                        $sqlToken = Cypher::decryptStringUsingAES256($row['token'], $_ENV["USUARIOS_ADM_SESSION_TOKEN_CYPHER_KEY"]);

                        if ($sqlToken === $_COOKIE['a_auth']) {
                              return;
                        }
                  }

                  header("Location: https://collegebuilder.easyvirtual.net/trail-life/s/system/administracao/login/");
                  exit();
            } else {
                  header("Location: https://collegebuilder.easyvirtual.net/trail-life/s/system/administracao/login/");
                  exit();
            }
      }
}
?>
