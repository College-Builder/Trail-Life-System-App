<?php
class ReqException extends Exception {
  private $customData;

  public function __construct($customData) {
    $this->customData = $customData;
    parent::__construct($customData['message'], 0, null);
  }

  public function getCustomData() {
    return $this->customData;
  }
}

class ReqFormException extends Exception {
  private $customData;

  public function __construct($customData) {
    $this->customData = $customData;
    parent::__construct($customData['message'], 0, null);
  }

  public function getCustomData() {
    return $this->customData;
  }
}

class RequestHandler {
    public static function return200() {
        http_response_code(200);
    }

    public static function throwReqException($status, $message) {
        $data = array(
            'status' => $status,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
        );

        throw new ReqException($data);
    }

    public static function throwReqFormException($status, $label, $message) {
        $data = array(
            'status' => $status,
            'label' => $label,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
        );

        throw new ReqFormException($data);
    }

    public static function handleCustomException($e) {
        $data = $e->getCustomData();

        http_response_code($data['status']);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>
