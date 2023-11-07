<?php
include './util.php';
?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $authCookie = $_COOKIE['a_auth'];

      if (isset($authCookie)) {
            $sql = 'DELETE FROM usuarios_adm_session WHERE token = ?;';
            $params = array($authCookie);
            $result = $mysql->query($sql, $params);

            setcookie("a_auth", "", time() - 3600, "/");

            $requestHandler::return200();
      } else {
            $requestHandler::return200();
      }
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
}
?>