<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $authCookie = $_COOKIE['a_auth'];

      if (!isset($authCookie)) {
            return;
      } 

      $sql = 'DELETE FROM usuarios_adm_session WHERE token = ?;';
      $params = array($authCookie);
      $result = $mysql->query($sql, $params);

      setcookie("a_auth", "", time() - 3600, "/");
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
}
?>