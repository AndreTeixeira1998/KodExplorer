<?php

/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*------
* String class encryption and decryption;
* One-time pad; and effective timing of decryption
* Can be used for encryption & key dynamically generated
* Demo:
* Encryption: echo Mcrypt :: encode ( 'abc', '123');
* Decryption: echo Mcrypt :: decode ( '9f843I0crjv5y0dWE_-uwzL_mZRyRb1ynjGK4I_IACQ', '123');
*/

class Mcrypt{
    public $default_key = 'a!takA:dlmcldEv,e';
	
	/**
	* Character encryption, one-time pad, can be timed to decrypt effective
	*
	* @param String $ string description or ciphertext
	* @param String $ operation operation (encode | decode)
	* @param String $ key key
	* @param Int $ expiry ciphertext is valid, the unit s, 0 is permanent
	* @return String after the original treatment or after treatment base64_encode ciphertext
	 */
	public static function encode($string,$key = '', $expiry = 3600){
		$ckey_length = 4;
		$key = md5($key ? $key : $this->default_key); //Decryption key
		$keya = md5(substr($key, 0, 16));		 //For data integrity verification  
		$keyb = md5(substr($key, 16, 16));		 //Changes for generating ciphertext (initialization vector IV)
		$keyc = substr(md5(microtime()), - $ckey_length);
		$cryptkey = $keya . md5($keya . $keyc);  
		$key_length = strlen($cryptkey);
		$string = sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string . $keyb), 0, 16) . $string;
		$string_length = strlen($string);

		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		$box = range(0, 255);	
		// Disrupt key book, increasing randomness
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}	
		// Encryption and decryption, key derived from the key book XOR, then into character
		$result = '';
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		$result = $keyc . str_replace('=', '', base64_encode($result));
		$result = str_replace(array('+', '/', '='),array('-', '_', '.'), $result);
		return $result;
	}

	/**
	* Character encryption, one-time pad, can be timed to decrypt effective
	*
	* @param String $ string description or ciphertext
	* @param String $ operation operation (encode | decode)
	* @param String $ key key
	* @param Int $ expiry ciphertext is valid, the unit s, 0 is permanent
	* @return String after the original treatment or after treatment base64_encode ciphertext
	 */
	public static function decode($string,$key = '')
	{
		$string = str_replace(array('-', '_', '.'),array('+', '/', '='), $string);
		$ckey_length = 4;
		$key = md5($key ? $key : $this->default_key); //Decryption key
		$keya = md5(substr($key, 0, 16));		 //For data integrity verification  
		$keyb = md5(substr($key, 16, 16));		 //Changes for generating ciphertext (initialization vector IV)
		$keyc = substr($string, 0, $ckey_length);

		$cryptkey = $keya . md5($keya . $keyc);  
		$key_length = strlen($cryptkey);
		$string = base64_decode(substr($string, $ckey_length));
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);
		$rndkey = array();	
		for($i = 0; $i <= 255; $i++) {	
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		// Disrupt key book, increasing randomness
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		// Encryption and decryption, key derived from the key book XOR, then into character
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp; 
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		} 
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
		&& substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
		) {
			return substr($result, 26);
		} else {
			return '';
		} 
	}
}
