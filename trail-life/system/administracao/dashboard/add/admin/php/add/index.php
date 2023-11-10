<?php include './util.php' ?>
<?php
try {
      if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $requestHandler::throwReqException(405, 'Método Não Permitido. Por favor, utilize uma requisição POST.');
      }

      $headers = getallheaders();
      $authorizationHeader = $headers['Authorization'];

      $usePermission = array('todas');
      $user = $validateApiDate->validateUserPermission($authorizationHeader, $usePermission);

      $email = isset($_POST['email']) ? trim($_POST['email']) : null;
      $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
      $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : null;
      $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;
      $confirmeSenha = isset($_POST['confirme-senha']) ? trim($_POST['confirme-senha']) : null;
      $permissao = isset($_POST['permissao']) ? trim($_POST['permissao']) : null;

      $validateAdminData->validateEmail($email);
      $validateAdminData->validateNome($nome);
      $validateAdminData->validateUsuario($usuario);
      $validateAdminData->validateSenha($senha);

      if ($senha !== $confirmeSenha) {
            $requestHandler::throwReqFormException(400, 'confirme-senha', 'Por favor, verifique se a senha e a confirmação de senha são idênticas.');
      }

      $validateAdminData->validatePermissao($permissao);

      $h_email = Cypher::encryptStringUsingAES256($email, $_ENV["USUARIOS_ADM_EMAIL_CYPHER_KEY"]);
      $h_usuario = Cypher::encryptStringUsingSHA512($usuario);
      $h_senha = Cypher::encryptStringUsingSHA512($senha);

      $sql = 'INSERT INTO usuarios_adm (email, nome, usuario, senha, permissao) values (?, ?, ?, ?, ?);';
      $params = array($h_email, $nome, $h_usuario, $h_senha, $permissao);
      $result = $mysql->query($sql, $params);
} catch (ReqException $e) {
      $requestHandler::handleCustomException($e);
} catch (ReqFormException $e) {
      $requestHandler::handleCustomException($e);
}
?>