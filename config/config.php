<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

@date_default_timezone_set(@date_default_timezone_get());
@set_time_limit(600);//10min pathInfoMuti,search,upload,download... 
@ini_set('session.cache_expire',600);
@ini_set("display_errors","on");
@error_reporting(E_ERROR|E_WARNING|E_PARSE);
//error_reporting(E_ALL);

function P($path){return str_replace('\\','/',$path);}
$web_root = str_replace(P($_SERVER['SCRIPT_NAME']),'',P(dirname(dirname(__FILE__))).'/index.php').'/';
if (substr($web_root,-10) == 'index.php/') {//Solve part of the host incompatibilities
    $web_root = P($_SERVER['DOCUMENT_ROOT']).'/';
}
function is_HTTPS(){  
    if(!isset($_SERVER['HTTPS'])){
    	return false;
    }
    if($_SERVER['HTTPS'] === 1){  //Apache
        return true;
    }elseif($_SERVER['HTTPS'] === 'on'){ //IIS
        return true;
    }elseif($_SERVER['SERVER_PORT'] == 443){ //other
        return true;
    }
    return false;
}

define('WEB_ROOT',$web_root);
define('HOST', (is_HTTPS() ? 'https://' :'http://').$_SERVER['HTTP_HOST'].'/');
define('BASIC_PATH',    P(dirname(dirname(__FILE__))).'/');
define('APPHOST',       HOST.str_replace(WEB_ROOT,'',BASIC_PATH));//Root directory
define('TEMPLATE',		BASIC_PATH .'template/');	//Template file path
define('CONTROLLER_DIR',BASIC_PATH .'controller/'); //Controller directory
define('MODEL_DIR',		BASIC_PATH .'model/');		//Model Directory
define('LIB_DIR',		BASIC_PATH .'lib/');		//Library Directory
define('FUNCTION_DIR',	LIB_DIR .'function/');		//Library catalog
define('CLASS_DIR',		LIB_DIR .'class/');			//In the catalog
define('CORER_DIR',		LIB_DIR .'core/');			//Core directory
define('DATA_PATH',     BASIC_PATH .'data/');       //User data directory
define('LOG_PATH',      DATA_PATH .'log/');         //Log Directory
define('USER_SYSTEM',   DATA_PATH .'system/');      //User data storage directory
define('DATA_THUMB',    DATA_PATH .'thumb/');       //Thumbnail generation storage
define('LANGUAGE_PATH', DATA_PATH .'i18n/');        //Multi-language directory

define('STATIC_JS','app');  //dev (development status) || app (compressed package)
define('STATIC_LESS','css');//less (development status) || css (compressed package)
define('STATIC_PATH',"./static/");//Static file directory
//define('STATIC_PATH','http://static.kalcaddle.com/static/');//Static file system separated individually to deploy static CDN

/*
You can customize the user directory [directory] and [public]; move beyond the web directory,
  Can make the program more secure, do not limit the extension of the rights of users;
 */
define('USER_PATH',     DATA_PATH .'User/');        //User Directory
//Custom user directory; you need to first data / User to move somewhere else and then modify the configuration, for example:
//define('USER_PATH',   DATA_PATH .'/Library/WebServer/Documents/User');
define('PUBLIC_PATH',   DATA_PATH .'public/');     //Public directory
//Public shared directory, read and write permission to follow the user directory and then read and write permissions to modify the configuration, for example:
//define('PUBLIC_PATH','/Library/WebServer/Documents/Public/');

/*
* Office server configuration; the default call Microsoft interface, the program needs to be deployed to the external network.
  * Fill in the local office deployment weboffice quotes resolve the server address of the form: http:? //---/view.aspx Src =
 */
define('OFFICE_SERVER',"https://view.officeapps.live.com/op/view.aspx?src=");

include(FUNCTION_DIR.'web.function.php');
include(FUNCTION_DIR.'file.function.php');
include(CLASS_DIR.'fileCache.class.php');
include(CONTROLLER_DIR.'util.php');
include(CORER_DIR.'Application.class.php');
include(CORER_DIR.'Controller.class.php');
include(CORER_DIR.'Model.class.php');
include(FUNCTION_DIR.'common.function.php');
include(BASIC_PATH.'config/setting.php');
include(BASIC_PATH.'config/version.php');

//Data address is defined.
$config['pic_thumb']	= BASIC_PATH.'data/thumb/';		// Thumbnail generation storage address
$config['cache_dir']	= BASIC_PATH.'data/cache/';		// Cache file Address
$config['app_startTime'] = mtime();         			//Start Time

//Coding System Configuration
$config['app_charset']	 ='utf-8';			//The program as a whole unified coding
$config['check_charset'] = 'ASCII,UTF-8,GBK';//Open the file encoding auto-detection
//when edit a file ;check charset and auto converto utf-8;
if (strtoupper(substr(PHP_OS, 0,3)) === 'WIN') {
	$config['system_os']='windows';
	$config['system_charset']='gbk';//user set your server system charset
} else {
	$config['system_os']='linux';
	$config['system_charset']='utf-8';
}

$in = parse_incoming();
if(isset($in['PHPSESSID'])){//office edit post
    session_id($in['PHPSESSID']);
}

@session_start();
check_post_many();
session_write_close();//Avoid session locking problems; $ _SESSION need to be modified after the first call session_start ()
$config['autorun'] = array(
	array('controller'=>'user','function'=>'loginCheck'),
    array('controller'=>'user','function'=>'authCheck')
);
