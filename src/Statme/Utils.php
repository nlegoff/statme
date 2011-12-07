<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author nico
 */

namespace Statme;

class Utils
{

  public static function json_encode(Array $value, $asObject = true)
  {
    return $asObject ? json_encode($value, JSON_FORCE_OBJECT) : json_encode($value);
  }

  public static function alphaId($len=10)
  {
    $hex = md5("statme" . uniqid("", true));

    $pack = pack('H*', $hex);
    $tmp = base64_encode($pack);

    $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

    $len = max(4, min(128, $len));

    while (strlen($uid) < $len)
      $uid .= gen_uuid(22);

    return substr($uid, 0, $len);
  }

}
