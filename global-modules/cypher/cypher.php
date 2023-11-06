<?php
class Cypher
{
    public static function encryptStringUsingSHA512($string)
    {
        $hash = hash('sha512', $string);
        return $hash;
    }

    public static function encryptStringUsingAES256($string, $key)
    {
        $cipher = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $encrypted = openssl_encrypt($string, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        $result = base64_encode($iv . $encrypted);

        return $result;
    }

    public static function decryptStringUsingAES256($string, $key)
    {
        $cipher = "aes-256-cbc";
        $string = base64_decode($string);
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($string, 0, $iv_length);
        $encrypted = substr($string, $iv_length);

        $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }
}
?>