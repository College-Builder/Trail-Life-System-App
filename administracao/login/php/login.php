<?php
require_once "../../../global-modules/mysql/mysql.php";
require_once "../../../global-modules/request-handler/request-handler.php";

$mysql = new Mysql('root', '', 'trail_life');

$requestHandler = new RequestHandler();

try {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $usuario = $_POST["usuario"];
      $senha = $_POST["senha"];

      if (!isset($usuario) || !isset($senha)) {
        $status = 400;
        $label = !isset($usuario) ? 'usuario' : 'senha';
        $message = !isset($usuario) ? 'Por favor, forneça um usuário válido.' : 'Por favor, forneça um senha válida.';

        $requestHandler::throwReqFormException($status, $label, $message);
      }

      if (strlen($usuario) < 1 || strlen($senha) < 1) {
        $status = 400;
        $label = strlen($usuario) < 1 ? 'usuario' : 'senha';
        $message = strlen($usuario) < 1 ? 'Por favor, forneça um usuário válido.' : 'Por favor, forneça um senha válida.';

        $requestHandler::throwReqFormException($status, $label, $message);
      }

      $h_usuario = hash('sha512', $usuario);
      $h_senha = hash('sha512', $senha);

      $sql = 'SELECT id, usuario FROM usuarios_adm WHERE usuario = ? AND senha = ?;';
      $params = array($h_usuario, $h_senha);
      $result = $mysql::query($sql, $params);

      if ($result->num_rows == 0) {
        $status = 400;
        $label = 'usuario';
        $message = 'Usuário ou senha errada!';

        $requestHandler::throwReqFormException($status, $label, $message);       
      } else {
        $requestHandler::return200();
      }

  } else {
      $requestHandler::throwReqError(405, 'Method Not Allowed. Please use a POST request.', date('Y-m-d H:i:s'));
  }
} catch (ReqException $e) {
  $requestHandler::handleReqCustomException($e);
} catch (ReqFormException $e) {
  $requestHandler::handleReqCustomException($e);
}
?>
