<?php
      require_once "../../global-modules/mysql/mysql.php";

      $mysql = new Mysql('127.0.0.1', 'administracao-dashboard', '3940596849', 'trail_life');

      if(isset($_COOKIE['a_auth'])) {
            $a_token = $_COOKIE['a_auth'];
            
            $sql = 'SELECT id, token FROM usuarios_adm_session WHERE token = ?;';
            $params = array($a_token);
            $result = $mysql::query($sql, $params);

            if ($result->num_rows == 0) {
                  header("Location: http://localhost/trail-life/system/administracao/login/");
                  exit();
            }
      } else {
            echo "ss";
            header("Location: http://localhost/trail-life/system/administracao/login/");
            exit();
      }
?>
<h1>Login</h1>