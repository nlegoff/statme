<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2010 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 *
 * @license     http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link        www.phraseanet.com
 */

namespace Statme\Utils;

/**
 * @example
 *
 * registration process
 * // hash the password
 * $pass_hash = PassHash::hash($_POST['password']);
 *
 * // store all user info in the DB, excluding $_POST['password']
 * // store $pass_hash instead
 *
 *
 * login process
 * // check the password the user tried to login with
 * if (PassHash::check_password($user['pass_hash'], $_POST['password']) {
	* // grant access
 * // ...
 * } else {
	* // deny access
	* // ...
 * }
 *
 */
class Passhash
{

  // blowfish
  private static $algo = '$2a';
  // cost parameter
  private static $cost = '$10';

  // mainly for internal use
  public static function unique_salt()
  {
    return substr(sha1(mt_rand()), 0, 22);
  }

  // this will be used to generate a hash
  public static function hash($password)
  {

    return crypt($password,
            self::$algo .
            self::$cost .
            '$' . self::unique_salt());
  }

  // this will be used to compare a password against a hash
  public static function check_password($hash, $password)
  {

    $full_salt = substr($hash, 0, 29);

    $new_hash = crypt($password, $full_salt);
    
    return ($hash == $new_hash);
  }
  
  public static function crypt($key, $string)
  {
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
  }
  
  public static function decrypt($key, $encrypted)
  {
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
  }

}
