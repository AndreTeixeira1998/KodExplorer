<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

/**
 * Loading classes from the class catalog; controller; model catalog to find class
 */
function _autoload($className){
	if (file_exists(CLASS_DIR . strtolower($className) . '.class.php')) {
		require_once(CLASS_DIR . strtolower($className) . '.class.php');
	} else if (file_exists(CONTROLLER_DIR . strtolower($className) . '.class.php')) {
		require_once(CONTROLLER_DIR . strtolower($className) . '.class.php');
	} else if (file_exists(MODEl_DIR . strtolower($className) . '.class.php')) {
		require_once(MODEl_DIR . strtolower($className) . '.class.php');
	} else {
		// error code;
	} 
}
/**
 * Generate model objects
 */
function init_model($model_name){
	if (!class_exists($model_name.'Model')) {
		$model_file = MODEL_DIR.$model_name.'Model.class.php';
		require_once ($model_file);
		
		if(!is_file($model_file)){
			return false;
		}
	}
	$reflectionObj = new ReflectionClass($model_name.'Model');
	$args = func_get_args();
	array_shift($args);
	return $reflectionObj -> newInstanceArgs($args);
}
/**
 * Production controller objects
 */
function init_controller($controller_name){
	if (!class_exists($controller_name)) {
		$model_file = CONTROLLER_DIR.$controller_name.'.class.php';
		if(!is_file($model_file)){
			return false;
		}
		require_once ($model_file);
	}
	$reflectionObj = new ReflectionClass($controller_name);
	$args = func_get_args();
	array_shift($args);
	return $reflectionObj -> newInstanceArgs($args);
}

/**
 * Load class
 */
function load_class($class){
	$filename = CLASS_DIR.$class.'.class.php';
	if (file_exists($filename)) {
		require($filename);
	}else{
		pr($filename.' is not exist',1);
	}
}
/**
 * Loading library
 */
function load_function($function){
	$filename = FUNCTION_DIR.$function.'.function.php';
	if (file_exists($filename)) {
		require($filename);
	}else{
		pr($filename.' is not exist',1);
	}
}
/**
 * Converts a text string
 */
function mystr($str){
	$from = array("\r\n", " ");
	$to = array("<br/>", "&nbsp");
	return str_replace($from, $to, $str);
} 

// Remove extra spaces and carriage return characters
function strip($str){
	return preg_replace('!\s+!', '', $str);
} 

/**
 * Get precise time
 */
function mtime(){
	$t= explode(' ',microtime());
	$time = $t[0]+$t[1];
	return $time;
}
/**
 * Filtering HTML
 */
function clear_html($HTML, $br = true){
	$HTML = htmlspecialchars(trim($HTML));
	$HTML = str_replace("\t", ' ', $HTML);
	if ($br) {
		return nl2br($HTML);
	} else {
		return str_replace("\n", '', $HTML);
	} 
} 

/**
 * Converts obj depth into array
 * 
* @param $ Obj to convert data may also be an array of objects may also be a general data type
  * @return Array || generic data types
 */
function obj2array($obj){
	if (is_array($obj)) {
		foreach($obj as &$value) {
			$value = obj2array($value);
		} 
		return $obj;
	} elseif (is_object($obj)) {
		$obj = get_object_vars($obj);
		return obj2array($obj);
	} else {
		return $obj;
	} 
} 

/**
 * Time difference calculating
 * 
 * @param char $pretime 
 * @return char 
 */
function spend_time(&$pretime){
	$now = microtime(1);
	$spend = round($now - $pretime, 5);
	$pretime = $now;
	return $spend;
} 

function check_code($code){
	header("Content-type: image/png");
	$fontsize = 18;$len = strlen($code);
    $width = 70;$height=27;
    $im = @imagecreatetruecolor($width, $height) or die("create image error!");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    imagefill($im, 0, 0, $background_color);  
    for ($i = 0; $i < 2000; $i++) {//Get random colors            
        $line_color = imagecolorallocate($im, mt_rand(180,255),mt_rand(160, 255),mt_rand(100, 255));
        imageline($im,mt_rand(0,$width),mt_rand(0,$height), //Draw a straight line
            mt_rand(0,$width), mt_rand(0,$height),$line_color);
        imagearc($im,mt_rand(0,$width),mt_rand(0,$height), //Videos arc
            mt_rand(0,$width), mt_rand(0,$height), $height, $width,$line_color);
    }
    $border_color = imagecolorallocate($im, 160, 160, 160);   
    imagerectangle($im, 0, 0, $width-1, $height-1, $border_color);//Draw a rectangle, border color 200,200,200

    for ($i = 0; $i < $len; $i++) {//Write random string
        $current = $str[mt_rand(0, strlen($str)-1)];
        $text_color = imagecolorallocate($im,mt_rand(30, 140),mt_rand(30,140),mt_rand(30,140));
        imagechar($im,10,$i*$fontsize+6,rand(1,$height/3),$code[$i],$text_color);
    }
    imagejpeg($im);//Shown in Figure
    imagedestroy($im);//Destruction Photos
}

/**
 * Returns the current floating-point type of time in seconds; mainly used when debugging a program with time
 * 
 * @return float 
 */
function microtime_float(){
	list($usec, $sec) = explode(' ', microtime());
	return ((float)$usec + (float)$sec);
}
/**
 * Calculation of N-th root
 * @param  $num 
 * @param  $root 
 */
function croot($num, $root = 3){
	$root = intval($root);
	if (!$root) {
		return $num;
	} 
	return exp(log($num) / $root);
} 

function add_magic_quotes($array){
	foreach ((array) $array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		} 
	} 
	return $array;
} 
// An escape string
function add_slashes($string){
	if (!$GLOBALS['magic_quotes_gpc']) {
		if (is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = add_slashes($val);
			} 
		} else {
			$string = addslashes($string);
		} 
	} 
	return $string;
} 

/**
 * hex to binary
 */
if (!function_exists('hex2bin')) {
	function hex2bin($hexdata)	{
		return pack('H*', $hexdata);
	}
}

/**
 * Dimensional array sorted according to the specified key,
 * 
* @param $ Keys based on a key
  * @param $ Type Ascending Descending
  * @return Array $ array = array (
  * Array ( 'name' => 'mobile phone', 'brand' => 'Nokia', 'price' => 1050),
  * Array ( 'name' => 'watch', 'brand' => 'Casio', 'price' => 960)
  *); $ Out = array_sort ($ array, 'price');
 */
function array_sort($arr, $keys, $type = 'asc'){
	$keysvalue = $new_array = array();
	foreach ($arr as $k => $v) {
		$keysvalue[$k] = $v[$keys];
	} 
	if ($type == 'asc') {
		asort($keysvalue);
	} else {
		arsort($keysvalue);
	} 
	reset($keysvalue);
	foreach ($keysvalue as $k => $v) {
		$new_array[$k] = $arr[$k];
	} 
	return $new_array;
} 
/**
* Through the array, $ callback call for each element, if the return value is not a false value, simply return the return value;
  * If every $ callback returns a false value, the final returns false
 * 
 * @param  $array 
 * @param  $callback 
 * @return mixed 
 */
function array_try($array, $callback){
	if (!$array || !$callback) {
		return false;
	} 
	$args = func_get_args();
	array_shift($args);
	array_shift($args);
	if (!$args) {
		$args = array();
	} 
	foreach($array as $v) {
		$params = $args;
		array_unshift($params, $v);
		$x = call_user_func_array($callback, $params);
		if ($x) {
			return $x;
		} 
	} 
	return false;
} 
// Seeking more arrays and set
function array_union(){
	$argsCount = func_num_args();
	if ($argsCount < 2) {
		return false;
	} else if (2 === $argsCount) {
		list($arr1, $arr2) = func_get_args();

		while ((list($k, $v) = each($arr2))) {
			if (!in_array($v, $arr1)) $arr1[] = $v;
		} 
		return $arr1;
	} else { // Array merge three or more
		$arg_list = func_get_args();
		$all = call_user_func_array('array_union', $arg_list);
		return array_union($arg_list[0], $all);
	} 
}
// Remove array item n
function array_get($arr,$index){
   foreach($arr as $k=>$v){
       $index--;
       if($index<0) return array($k,$v);
   }
}

function show_tips($message){
	echo<<<END
<html>
	<style>
	#msgbox{border: 1px solid #ddd;border: 1px solid #eee;padding: 30px;border-radius: 5px;background: #f6f6f6;
	font-family: 'Helvetica Neue', "Microsoft Yahei", "微软雅黑", "STXihei", "WenQuanYi Micro Hei", sans-serif;
	color:888;font-size:13px;margin:0 auto;margin-top:10%;width: 400px;font-size: 16;color:#666;}
	#msgbox #title{padding-left:20px;font-weight:800;font-size:25px;}
	#msgbox #message{padding:20px;}
	</style>
	<body>
	<div id="msgbox">
	<div id="title">tips</div>
	<div id="message">$message</div>
	</body>
</html>
END;
	exit;
} 
/**
* AJAX request data package returned
  * @params {Int} return status code, usually 0 for normal
  * @params {Array} return data sets
 */
function show_json($data,$code = true,$info=''){
	$use_time = mtime() - $GLOBALS['config']['app_startTime'];
	$result = array('code' => $code,'use_time'=>$use_time,'data' => $data);
	if ($info != '') {
		$result['info'] = $info;
	}
	header("X-Powered-By: kodExplorer.");
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($result);
	exit;
} 

/**
* Simple template conversion, according to the configuration is used to obtain the list: 
* Parameters: cute1: first cut string, cute2 second cutting string, 
* arraylist to be treated string, $ this marked the current item, $ this_str when the replacement item marker. 
* $ Tpl after filling with static templates ({0} left after cutting the representative value {1} on behalf of the right value after cutting, {this} represents the current value of the item is filled) 
* Examples: * $ arr = "default = light blue (default) = 5 | mac = mac marine = 6 | mac1 = mac1 ocean = 7 "; 
* $ tpl =" <li class = 'list {this}' theme = '{0}'> {1} _ {2 } </ li> \ n "; 
* echo getTplList ( '|', '=', $ arr, $ tpl, 'mac'), '<br/>';
 */
function getTplList($cute1, $cute2, $arraylist, $tpl,$this,$this_str=''){
	$list = explode($cute1, $arraylist);
	if ($this_str == '') $this_str ="this";
	$html = '';
	foreach ($list as $value) {
		$info = explode($cute2, $value);
		$arr_replace = array();	
		foreach ($info as $key => $value) {
			$arr_replace[$key]='{'.$key .'}';
		}
		if ($info[0] == $this) {
			$temp = str_replace($arr_replace, $info, $tpl);
			$temp = str_replace('{this}', $this_str, $temp);
		} else {
			$temp = str_replace($arr_replace, $info, $tpl);
			$temp = str_replace('{this}', '', $temp);
		}
		$html .= $temp;
	} 
	return $html;
} 

//Get current url address
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] 
					== '443' ? 'https://' : 'http://';
	$php_self   = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info  = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 
				$php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/**
* Remove the HTML code HTML tags, plain text is returned
  * String @param string $ document to be processed
  * @return String
 */
function html2txt($document){
	$search = array ("'<script[^>]*?>.*?</script>'si", // Remove javascript
		"'<[\/\!]*?[^<>]*?>'si", // Remove HTML tags
		"'([\r\n])[\s]+'", // Remove blank characters
		"'&(quot|#34);'i", // Replace HTML entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e"); // As PHP code runs
	$replace = array ("",
		"",
		"",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)");
	$text = preg_replace ($search, $replace, $document);
	return $text;
} 

// Get Content Article
function match($content, $preg){
	$preg = "/" . $preg . "/isU";
	preg_match($preg, $content, $result);
	return $result[1];
} 
// Get Content, Get a number of pages of information. The results in the 1,2,3 ......
function match_all($content, $preg){
	$preg = "/" . $preg . "/isU";
	preg_match_all($preg, $content, $result);
	return $result;
} 

/**
 * Get utf8 string of specified length
 * 
 * @param string $string 
 * @param int $length 
 * @param string $dot 
 * @return string 
 */
function get_utf8_str($string, $length, $dot = '...'){
	if (strlen($string) <= $length) return $string;

	$strcut = '';
	$n = $tn = $noc = 0;

	while ($n < strlen($string)) {
		$t = ord($string[$n]);
		if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1;
			$n++;
			$noc++;
		} elseif (194 <= $t && $t <= 223) {
			$tn = 2;
			$n += 2;
			$noc += 2;
		} elseif (224 <= $t && $t <= 239) {
			$tn = 3;
			$n += 3;
			$noc += 2;
		} elseif (240 <= $t && $t <= 247) {
			$tn = 4;
			$n += 4;
			$noc += 2;
		} elseif (248 <= $t && $t <= 251) {
			$tn = 5;
			$n += 5;
			$noc += 2;
		} elseif ($t == 252 || $t == 253) {
			$tn = 6;
			$n += 6;
			$noc += 2;
		} else {
			$n++;
		} 
		if ($noc >= $length) break;
	} 
	if ($noc > $length) {
		$n -= $tn;
	} 
	if ($n < strlen($string)) {
		$strcut = substr($string, 0, $n);
		return $strcut . $dot;
	} else {
		return $string ;
	} 
} 

/**
* String interception, support Chinese and other coding
  *
  * @param String $ str string to be converted
  * @param String $ start start position
  * @param String $ length intercept length
  * @param String $ charset encoding format
  * @param String $ suffix truncated character display
  * @return String
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true){
	if (function_exists("mb_substr")) {
		$i_str_len = mb_strlen($str);
		$s_sub_str = mb_substr($str, $start, $length, $charset);
		if ($length >= $i_str_len) {
			return $s_sub_str;
		} 
		return $s_sub_str . '...';
	} elseif (function_exists('iconv_substr')) {
		return iconv_substr($str, $start, $length, $charset);
	} 
	$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("", array_slice($match[0], $start, $length));
	if ($suffix) return $slice . "…";
	return $slice;
} 

function web2wap(&$content){
	$search = array ("/<img[^>]+src=\"([^\">]+)\"[^>]+>/siU",
		"/<a[^>]+href=\"([^\">]+)\"[^>]*>(.*)<\/a>/siU",
		"'<br[^>]*>'si",
		"'<p>'si",
		"'</p>'si",
		"'<script[^>]*?>.*?</script>'si", // Remove javascript
		"'<[\/\!]*?[^<>]*?>'si", // Remove HTML tags
		"'([\r\n])[\s]+'", // Remove blank characters
		); // As PHP code runs
	$replace = array ("#img#\\1#/img#",
		"#link#\\1#\\2#/link#",
		"[br]",
		"",
		"[br]",
		"",
		"",
		"",
		);
	$text = preg_replace ($search, $replace, $content);
	$text = str_replace("[br]", "<br/>", $text);
	$img_start = "<img src=\"" . $publish_url . "automini.php?src=";
	$img_end = "&amp;pixel=100*80&amp;cache=1&amp;cacheTime=1000&amp;miniType=png\" />";
	$text = preg_replace ("/#img#(.*)#\/img#/isUe", "'$img_start'.urlencode('\\1').'$img_end'", $text);
	$text = preg_replace ("/#link#(.*)#(.*)#\/link#/isU", "<a href=\"\\1\">\\2</a>", $text);
	while (preg_match("/<br\/><br\/>/siU", $text)) {
		$text = str_replace('<br/><br/>', '<br/>', $text);
	} 
	return $text;
} 

/**
* Get the name of the variable
  * Eg hello = "123" Get string ss
 */
function get_var_name(&$aVar){
	foreach($GLOBALS as $key => $var) {
		if ($aVar == $GLOBALS[$key] && $key != "argc") {
			return $key;
		} 
	} 
} 
// Variable debugging ------------------- -----------------
/**
  * Formatted output variable, or an object
  *
 * @param mixed $var 
 * @param boolean $exit 
 */
function pr($var, $exit = false){
	ob_start();
	$style = '<style>
	pre#debug{margin:10px;font-size:14px;color:#222;font-family:Consolas ;line-height:1.2em;background:#f6f6f6;border-left:5px solid #444;padding:5px;width:95%;word-break:break-all;}
	pre#debug b{font-weight:400;}
	#debug #debug_str{color:#E75B22;}
	#debug #debug_keywords{font-weight:800;color:00f;}
	#debug #debug_tag1{color:#22f;}
	#debug #debug_tag2{color:#f33;font-weight:800;}
	#debug #debug_var{color:#33f;}
	#debug #debug_var_str{color:#f00;}
	#debug #debug_set{color:#0C9CAE;}</style>';
	if (is_array($var)) {
		print_r($var);
	} else if (is_object($var)) {
		echo get_class($var) . " Object";
	} else if (is_resource($var)) {
		echo (string)$var;
	} else {
		echo var_dump($var);
	} 
	$out = ob_get_clean(); //Buffered output to the $ out variable	
	$out = preg_replace('/"(.*)"/', '<b id="debug_var_str">"' . '\\1' . '"</b>', $out); //Highlight the string variable
	$out = preg_replace('/=\>(.*)/', '=>' . '<b id="debug_str">' . '\\1' . '</b>', $out); //Highlight => value behind
	$out = preg_replace('/\[(.*)\]/', '<b id="debug_tag1">[</b><b id="debug_var">' . '\\1' . '</b><b id="debug_tag1">]</b>', $out); //Highlight variable
	$from = array('    ', '(', ')', '=>');
	$to = array('  ', '<b id="debug_tag2">(</i>', '<b id="debug_tag2">)</b>', '<b id="debug_set">=></b>');
	$out = str_replace($from, $to, $out);

	$keywords = array('Array', 'int', 'string', 'class', 'object', 'null'); //Keyword highlighting
	$keywords_to = $keywords;
	foreach($keywords as $key => $val) {
		$keywords_to[$key] = '<b id="debug_keywords">' . $val . '</b>';
	} 
	$out = str_replace($keywords, $keywords_to, $out);
	$out = str_replace("\n\n", "\n", $out);
	echo $style . '<pre id="debug"><b id="debug_keywords">' . get_var_name($var) . '</b> = ' . $out . '</pre>';
	if ($exit) exit; //True exit
} 

/**
* Debug output variable value of an object.
  * Any number of parameters (variables of any type)
 * 
 * @return echo 
 */
function debug_out(){
	$avg_num = func_num_args();
	$avg_list = func_get_args();
	ob_start();
	for($i = 0; $i < $avg_num; $i++) {
		pr($avg_list[$i]);
	} 
	$out = ob_get_clean();
	echo $out;
	exit;
} 

/**
* $ From ~ take a random number in the range of $ to
  *
  * @param $ From the lower limit
  * @param $ To limit
 * @return unknown_type 
 */
function rand_from_to($from, $to){
	$size = $from - $to; //Numerical interval
	$max = 30000; //maximum
	if ($size < $max) {
		return $from + mt_rand(0, $size);
	} else {
		if ($size % $max) {
			return $from + random_from_to(0, $size / $max) * $max + mt_rand(0, $size % $max);
		} else {
			return $from + random_from_to(0, $size / $max) * $max + mt_rand(0, $max);
		} 
	} 
} 

/**
* Generates a random string that can be used to automatically generate a default password length 6 alphanumerical
  *
  * @param String $ len length
  * @param String $ type string type: 0 2 1 Digital uppercase letters lowercase letters 4 3 Chinese
  * Other mixed (removed easily confused characters and numbers oOLl 01) to alphanumeric
  * @param String $ addChars extra character
 * @return string 
 */
function rand_string($len = 4, $type='check_code'){
	$str = '';
	switch ($type) {
		case 0://Case in English
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			break;
		case 1://digital
			$chars = str_repeat('0123456789', 3);
			break;
		case 2://uppercase letter
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 3://Lower case letters
			$chars = 'abcdefghijklmnopqrstuvwxyz';
			break;
		default: 
			// Default removed easily confused character oLOl and numbers 01, to add a parameter use addChars
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
			break;
	} 
	if ($len > 10) { // String is too long to repeat a certain number of digits
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	} 
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for($i = 0; $i < $len; $i ++) {
			$str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		} 
	} 
	return $str;
} 

/**
 * Automatic password generation
 */
function make_password(){
	$temp = '0123456789abcdefghijklmnopqrstuvwxyz'.
			'ABCDEFGHIJKMNPQRSTUVWXYZ~!@#$^*)_+}{}[]|":;,.'.time();
	for($i=0;$i<10;$i++){
		$temp = str_shuffle($temp.substr($temp,-5));
	}
	return md5($temp);
}


/**
* Php AES decryption function * 
* @param string $ key key 
* @param string $ encrypted encrypted string 
* @return string
 */
function des_decode($key, $encrypted){
	$encrypted = base64_decode($encrypted);
	$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, ''); //Use MCRYPT_DES algorithm, cbc mode
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	$ks = mcrypt_enc_get_key_size($td);

	mcrypt_generic_init($td, $key, $key); //Initial treatment
	$decrypted = mdecrypt_generic($td, $encrypted); //Decryption
	
	mcrypt_generic_deinit($td); //结束
	mcrypt_module_close($td);
	return pkcs5_unpad($decrypted);
} 
/**
* Php DES encryption function
  *
  * @param String $ key key
  * @param String $ text string
  * @return String
 */
function des_encode($key, $text){
	$y = pkcs5_pad($text);
	$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, ''); //Use MCRYPT_DES algorithm, cbc mode
	$ks = mcrypt_enc_get_key_size($td);

	mcrypt_generic_init($td, $key, $key); //Initial treatment
	$encrypted = mcrypt_generic($td, $y); //Decryption
	mcrypt_generic_deinit($td); //End
	mcrypt_module_close($td);
	return base64_encode($encrypted);
} 
function pkcs5_unpad($text){
	$pad = ord($text{strlen($text)-1});
	if ($pad > strlen($text)) return $text;
	if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return $text;
	return substr($text, 0, -1 * $pad);
} 
function pkcs5_pad($text, $block = 8){
	$pad = $block - (strlen($text) % $block);
	return $text . str_repeat(chr($pad), $pad);
} 
