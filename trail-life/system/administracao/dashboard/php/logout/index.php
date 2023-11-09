<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      setcookie("a_auth", "", time() - 3600, "/");
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
}
?>