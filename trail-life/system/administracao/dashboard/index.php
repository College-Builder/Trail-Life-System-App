<?php
      define('BASE_DIR', '/opt/lampp/htdocs/');

      require BASE_DIR .'vendor/autoload.php';
      require_once BASE_DIR . "global-modules/mysql/mysql.php";

      $dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
      $dotenv->load();

      $host=$_ENV["SQL_HOST_ADMINISTRACAO_DASHBOARD"];
      $user=$_ENV["SQL_USER_ADMINISTRACAO_DASHBOARD"];
      $password=$_ENV["SQL_PASSWORD_ADMINISTRACAO_DASHBOARD"];
      $database=$_ENV["SQL_DATABASE_ADMINISTRACAO_DASHBOARD"];

      if(isset($_COOKIE['a_auth'])) {
            $mysql = new Mysql($host, $user, $password, $database);

            $a_token = $_COOKIE['a_auth'];
            
            $sql = 'SELECT id, token FROM usuarios_adm_session WHERE token = ?;';
            $params = array($a_token);
            $result = $mysql::query($sql, $params);

            if ($result->num_rows == 0) {
                  header("Location: http://localhost/trail-life/system/administracao/login/");
                  exit();
            }
      } else {
            header("Location: http://localhost/trail-life/system/administracao/login/");
            exit();
      }
?>
