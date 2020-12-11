<?php

if ( !class_exists( 'Cryptor' ) ) :
Class Cryptor {

  private static $method = 'aes-128-ctr'; // default cipher method if none supplied
  private static $key = 'YouHired2020';

  protected static function iv_bytes()
  {
    return openssl_cipher_iv_length(self::$method);
  }

  public function __construct($key = 'YouHired2020', $method = FALSE)
  {
    if( is_user_logged_in() ) {
      $user = wp_get_current_user();
      $key = $user->roles[0];
    }
    if(!$key) {
      $key = php_uname(); // default encryption key if none supplied
    }
    if(ctype_print($key)) {
      // convert ASCII keys to binary format
      //self::$key = openssl_digest($key, 'sha256', TRUE);
      self::$key = openssl_digest($key, 'sha256', true);
    } else {
      self::$key = $key;
    }
    if($method) {
      if(in_array(strtolower($method), openssl_get_cipher_methods())) {
        self::$method = $method;
      } else {
        die(__METHOD__ . ": unrecognised cipher method: {$method}");
      }
    }
  }

  public static function encrypt($data)
  {
    $iv = openssl_random_pseudo_bytes(self::iv_bytes());
    return bin2hex($iv) . openssl_encrypt($data, self::$method, self::$key, 0, $iv);
  }

  // decrypt encrypted string
  public static function decrypt($data)
  {
    $iv_strlen = 2  * self::iv_bytes();
    if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
      list(, $iv, $crypted_string) = $regs;
      if(ctype_xdigit($iv) && strlen($iv) % 2 == 0) {
        return openssl_decrypt($crypted_string, self::$method, self::$key, 0, hex2bin($iv));
      }
    }
    return FALSE; // failed to decrypt
  }

}

endif;

/* USAGE */
/*
Encrypt
use \Chirp\Cryptor;

$token = "The quick brown fox jumps over the lazy dog.";

$encryption_key = 'CKXH2U9RPY3EFD70TLS1ZG4N8WQBOVI6AMJ5';
$cryptor = new Cryptor($encryption_key);
$crypted_token = $cryptor->encrypt($token);
unset($token);

Decrypt
$encryption_key = 'CKXH2U9RPY3EFD70TLS1ZG4N8WQBOVI6AMJ5';
$cryptor = new Cryptor($encryption_key);

$token = $cryptor->decrypt($crypted_token);

*/

?>
