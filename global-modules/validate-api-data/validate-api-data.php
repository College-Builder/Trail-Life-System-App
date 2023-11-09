<?php
require_once BASE_DIR . "global-modules/mysql/mysql.php";
require_once BASE_DIR . "global-modules/cypher/cypher.php";
require_once BASE_DIR . "global-modules/request-handler/request-handler.php";

class MySqlConn
{
      protected $mysql;

      public function __construct()
      {
            $host = $_ENV["SQL_HOST_GLOBAL_VALIDATE_API_DATA"];
            $user = $_ENV["SQL_USER_GLOBAL_VALIDATE_API_DATA"];
            $password = $_ENV["SQL_PASSWORD_GLOBAL_VALIDATE_API_DATA"];
            $database = $_ENV["SQL_DATABASE_GLOBAL_VALIDATE_API_DATA"];
            $this->mysql = new Mysql($host, $user, $password, $database);
      }
}

class ValidateApiData extends MySqlConn
{
      protected $requestHandler;

      public function __construct()
      {
            parent::__construct();
            $this->requestHandler = new RequestHandler();
      }

      public function validateUserPermission($sessionTable, $userTable, $token, $requiredPermission)
      {
            /*
            if (!(isset($token))) {
                  $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
            }

            $sql = 'SELECT id FROM ' . $sessionTable . ' WHERE token = ?;';
            $params = array($token);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows == 0) {
                  $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
            }
      
            $row = mysqli_fetch_assoc($result);

            $id = $row['id'];

            $sql = 'SELECT id, permissao FROM ' . $userTable . ' WHERE id = ?;';
            $params = array($id);
            $result = $this->mysql->query($sql, $params);

            $row = mysqli_fetch_assoc($result);

            $permissao = $row['permissao'];

            if (!in_array($permissao, $requiredPermission)) {
                  $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
            }

            return $row['id'];
            */
            if (isset($token)) {
                  $id = explode('-', $token)[0];
                  $token = explode('-', $token)[1];

                  $sql = 'SELECT id, token FROM ' . $sessionTable . ' WHERE id = ?;';
                  $params = array($id);
                  $result = $this->mysql->query($sql, $params);

                  while ($row = $result->fetch_assoc()) {
                        $sqlId = $row['id'];
                        $sqlToken = Cypher::decryptStringUsingAES256($row['token'], $_ENV["USUARIOS_ADM_SESSION_TOKEN_CYPHER_KEY"]);

                        if ($sqlToken === $_COOKIE['a_auth']) {
                              $sql = 'SELECT id, permissao FROM ' . $userTable . ' WHERE id = ?;';
                              $params = array($sqlId);
                              $result = $this->mysql->query($sql, $params);

                              $row = mysqli_fetch_assoc($result);

                              $permissao = $row['permissao'];

                              if (!in_array($permissao, $requiredPermission)) {
                                    $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
                              }

                              return $row['id'];
                        }
                  }

                  $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
            } else {
                  $this->requestHandler::throwReqException(403, 'Proibido. Você não tem permissão para acessar este recurso.');
            }
      }

      public function validateId($id, ?string $label = null)
      {
            if (!isset($id) || strlen($id) === 0) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'id', 'Por favor, forneça um id válido.');
            }

            if (!is_numeric($id)) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'id', 'Por favor, forneça um id válido.');
            }
      }

      public function validateNome($nome, ?string $label = null)
      {
            if (!isset($nome) || strlen($nome) === 0) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'nome', 'Por favor, forneça um nome válido.');
            }

            if (strlen($nome) < 5) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'nome', 'Por favor, forneça um nome com mais caracteres.');
            }

            if (strlen($nome) > 100) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'nome', 'Por favor, forneça um nome com menos caracteres.');
            }

            if (!preg_match('/^[a-zA-Z\s]+$/', $nome)) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'nome', 'Por favor, utilize apenas letras.');
            }
      }

      public function validateCelular($celular, ?string $label = null)
      {
            if (!isset($celular) || strlen($celular) === 0) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'celular', 'Por favor, forneça um celular válido.');
            }

            $celular = preg_replace('/[^0-9]/', '', (string) $celular);

            if (!is_numeric($celular)) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'celular', 'Por favor, forneça um celular válido.');
            }

            if (strlen($celular) !== 13) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'celular', 'Por favor, forneça um celular válido.');
            }
      }

      public function validateEmail($email, ?string $label = null)
      {
            if (!isset($email) || strlen($email) === 0) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'email', 'Por favor, forneça um email válido.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'email', 'Por favor, forneça um email válido.');
            }

            if (strlen($email) > 50) {
                  $this->requestHandler->throwReqFormException(400, isset($label) ? $label : 'email', 'Por favor, forneça um email com menos caracteres.');
            }
      }
}

class ValidateCargaData extends ValidateApiData
{
      public function __construct()
      {
            parent::__construct();
      }

      public function validateCliente($cliente)
      {
            if (!isset($cliente) || strlen($cliente) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'cliente', 'Por favor, forneça um cliente válido.');
            }

            $sql = 'SELECT id FROM clientes WHERE id = ?;';
            $params = array($cliente);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows !== 1) {
                  $this->requestHandler->throwReqFormException(400, 'cliente', 'Por favor, forneça um cliente válido.');
            }
      }

      public function validateFilial($filial)
      {
            if (!isset($filial) || strlen($filial) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'filial', 'Por favor, forneça uma filial válida.');
            }

            $sql = 'SELECT id FROM filiais WHERE id = ?;';
            $params = array($filial);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows !== 1) {
                  $this->requestHandler->throwReqFormException(400, 'filial', 'Por favor, forneça uma filial válida.');
            }
      }

      public function validateCarga($carga)
      {
            if (!isset($carga) || strlen($carga) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'carga', 'Por favor, forneça um tipo de carga válida.');
            }

            $result = $this->mysql->query("SHOW COLUMNS FROM cargas WHERE Field = 'tipo_carga';");
            $row = $result->fetch_assoc();
            $enum_values = explode("','", substr($row['Type'], 6, -2));

            if (!in_array($carga, $enum_values)) {
                  $this->requestHandler->throwReqFormException(400, 'carga', 'Por favor, forneça um tipo de carga válida.');
            }
      }

      public function validateMotorista($motorista)
      {
            if (!isset($motorista) || strlen($motorista) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'motorista', 'Por favor, forneça um motorista válido.');
            }

            $sql = 'SELECT id, status FROM motoristas WHERE id = ?;';
            $params = array($motorista);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows !== 1) {
                  $this->requestHandler->throwReqFormException(400, 'motorista', 'Por favor, forneça um motorista válido.');
            }

            $row = mysqli_fetch_assoc($result);

            if ($row['status'] !== 'livre') {
                  $this->requestHandler->throwReqFormException(400, 'motorista', 'Por favor, forneça um motorista livre.');
            }
      }
}

class ValidateMotoristaData extends ValidateApiData
{
      public function __construct()
      {
            parent::__construct();
      }

      public function validateRG($rg)
      {
            if (!isset($rg) || strlen($rg) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'rg', 'Por favor, forneça um rg válido.');
            }

            $pattern = '/^\d{2}\.\d{3}\.\d{3}-\d{1}$/';

            if (!preg_match($pattern, $rg)) {
                  $this->requestHandler->throwReqFormException(400, 'rg', 'Por favor, forneça um rg válido.');
            }
      }

      public function validateCPF($cpf)
      {
            if (!isset($cpf) || strlen($cpf) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'cpf', 'Por favor, forneça um cpf válido.');
            }

            $cpf = preg_replace('/[^0-9]/is', '', $cpf);

            if (strlen($cpf) != 11) {
                  $this->requestHandler->throwReqFormException(400, 'cpf', 'Por favor, forneça um cpf válido.');
            }

            if (preg_match('/(\d)\1{10}/', $cpf)) {
                  $this->requestHandler->throwReqFormException(400, 'cpf', 'Por favor, forneça um cpf válido.');
            }

            for ($t = 9; $t < 11; $t++) {
                  for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf[$c] * (($t + 1) - $c);
                  }
                  $d = ((10 * $d) % 11) % 10;
                  if ($cpf[$c] != $d) {
                        $this->requestHandler->throwReqFormException(400, 'cpf', 'Por favor, forneça um cpf válido.');
                  }
            }
      }
}

class ValidateClienteData extends ValidateApiData
{
      public function __construct()
      {
            parent::__construct();
      }

      public function validateEmpresa($empresa)
      {
            if (!isset($empresa) || strlen($empresa) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'empresa', 'Por favor, forneça um nome de empresa válido.');
            }

            if (strlen($empresa) < 5) {
                  $this->requestHandler->throwReqFormException(400, 'empresa', 'Por favor, forneça um nome de empresa com mais caracteres.');
            }

            if (strlen($empresa) > 100) {
                  $this->requestHandler->throwReqFormException(400, 'empresa', 'Por favor, forneça um nome de empresa com menos caracteres.');
            }

            if (!preg_match('/^[A-Za-z0-9\s]+$/', $empresa)) {
                  $this->requestHandler->throwReqFormException(400, 'empresa', 'Por favor, utlize apenas números ou letras.');
            }
      }

      public function validateCnpj($cnpj)
      {
            if (!isset($cnpj) || strlen($cnpj) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'cnpj', '!Por favor, forneça um cnpj válido.');
            }

            $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

            if (strlen($cnpj) != 14)
                  $this->requestHandler->throwReqFormException(400, 'cnpj', '!Por favor, forneça um cnpj válido.');

            if (preg_match('/(\d)\1{13}/', $cnpj))
                  $this->requestHandler->throwReqFormException(400, 'cnpj', '!Por favor, forneça um cnpj válido.');

            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
                  $soma += $cnpj[$i] * $j;
                  $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
                  return false;

            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                  $soma += $cnpj[$i] * $j;
                  $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($cnpj[13] != ($resto < 2 ? 0 : 11 - $resto)) {
                  $this->requestHandler->throwReqFormException(400, 'cnpj', '!Por favor, forneça um cnpj válido.');
            }
      }

      public function validateEstado($estado)
      {
            if (!isset($estado) || strlen($estado) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'estado', 'Por favor, forneça um estado válido.');
            }

            $estados_validos = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO"];

            if (!in_array($estado, $estados_validos)) {
                  $this->requestHandler->throwReqFormException(400, 'estado', 'Por favor, forneça um estado válido.');
            }
      }

      public function validateCidade($cidade)
      {
            if (!isset($cidade) || strlen($cidade) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'cidade', 'Por favor, forneça uma cidade válida.');
            }

            if (strlen($cidade) < 5) {
                  $this->requestHandler->throwReqFormException(400, 'cidade', 'Por favor, forneça uma cidade válida.');
            }

            if (strlen($cidade) > 28) {
                  $this->requestHandler->throwReqFormException(400, 'cidade', 'Por favor, forneça uma cidade válida.');
            }

            if (!preg_match('/^[a-z.\s]+$/i', $cidade)) {
                  $this->requestHandler->throwReqFormException(400, 'cidade', 'Por favor, utlize apenas números ou letras.');
            }
      }

      public function validateRua($rua)
      {
            if (!isset($rua) || strlen($rua) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'rua', 'Por favor, forneça uma rua válida.');
            }

            if (strlen($rua) < 5) {
                  $this->requestHandler->throwReqFormException(400, 'rua', 'Por favor, forneça uma rua válida.');
            }

            if (strlen($rua) > 50) {
                  $this->requestHandler->throwReqFormException(400, 'rua', 'Por favor, forneça uma rua válida.');
            }

            if (!preg_match('/^[a-z.\s]+$/i', $rua)) {
                  $this->requestHandler->throwReqFormException(400, 'cidade', 'Por favor, utlize apenas números ou letras.');
            }
      }

      public function validateNumero($numero)
      {
            if (!isset($numero) || strlen($numero) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'numero', 'Por favor, forneça um numero válido.');
            }

            if (!is_numeric($numero)) {
                  $this->requestHandler->throwReqFormException(400, 'numero', 'Por favor, forneça um numero válido.');
            }

            if (is_string($numero)) {
                  $numero = intval($numero);
            }

            if ($numero <= 0) {
                  $this->requestHandler->throwReqFormException(400, 'numero', 'Por favor, forneça um numero válido.');
            }

            if ($numero > 100000) {
                  $this->requestHandler->throwReqFormException(400, 'numero', 'Por favor, forneça um numero válido.');
            }
      }
}

class ValidateAdminData extends ValidateApiData
{
      public function __construct()
      {
            parent::__construct();
      }

      public function validateUsuario($usuario)
      {
            if (!isset($usuario) || strlen($usuario) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'usuario', 'Por favor, forneça um usuario válido.');
            }

            if (strlen($usuario) < 5) {
                  $this->requestHandler->throwReqFormException(400, 'usuario', 'Por favor, forneça um usuario com mais caracteres.');
            }

            if (strlen($usuario) > 100) {
                  $this->requestHandler->throwReqFormException(400, 'usuario', 'Por favor, forneça um usuario com menos caracteres.');
            }

            if (!preg_match('/^[A-Za-z0-9\s]+$/', $usuario)) {
                  $this->requestHandler->throwReqFormException(400, 'usuario', 'Por favor, utlize apenas números ou letras.');
            }

            $h_usuario = Cypher::encryptStringUsingSHA512($usuario);

            $sql = 'SELECT id FROM usuarios_adm WHERE usuario = ?;';
            $params = array($h_usuario);
            $result = $this->mysql->query($sql, $params);

            if ($result->num_rows !== 0) {
                  $this->requestHandler->throwReqFormException(400, 'usuario', 'Usuário já existe. Por favor, tente utilizar outro nome de usuário.');
            }
      }

      public function validateSenha($senha)
      {
            if (!isset($senha) || strlen($senha) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'senha', 'Por favor, forneça uma senha válida.');
            }

            if (strlen($senha) < 5) {
                  $this->requestHandler->throwReqFormException(400, 'senha', 'Por favor, forneça uma senha com mais caracteres.');
            }

            if (strlen($senha) > 100) {
                  $this->requestHandler->throwReqFormException(400, 'senha', 'Por favor, forneça uma senha com menos caracteres.');
            }
      }

      public function validatePermissao($permissao)
      {
            if (!isset($permissao) || strlen($permissao) === 0) {
                  $this->requestHandler->throwReqFormException(400, 'permissao', 'Por favor, forneça uma permissao válida.');
            }

            if ($permissao !== 'ler' and $permissao !== 'escrever' and $permissao !== 'todas') {
                  $this->requestHandler->throwReqFormException(400, 'permissao', 'Por favor, forneça uma permissao válida.');
            }
      }
}
?>