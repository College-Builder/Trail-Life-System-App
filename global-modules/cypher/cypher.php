<?php
class Cypher {
    public static function encryptString($string, $key) {
        $cipher = "aes-256-cbc"; // You can choose a different cipher if needed
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $encrypted = openssl_encrypt($string, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        $result = base64_encode($iv . $encrypted);

        return $result;
    }

    public static function decryptString($string, $key) {
        $cipher = "aes-256-cbc"; // You should use the same cipher as used for encryption
        $string = base64_decode($string);
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($string, 0, $iv_length);
        $encrypted = substr($string, $iv_length);

        $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }
}
?>
