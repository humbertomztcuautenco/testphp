<?php
namespace Lib;

class Encrypt {
    public static function crypt($cadena){
  		$crypt = crypt($cadena, '$6$rounds=5000$@SHumTestPhp##@!#%&&(*)-=//23$');
    	return $crypt;
  }
}