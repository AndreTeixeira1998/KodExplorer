<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

/**
* Route program processing class
  * This class is determined outside calls an internal method parameters
 */
class Application {
	public $default_controller = null;	//The default class name
	public $default_do = null;			//The default method name
	public $sub_dir ='';				//The controller subdirectory
	public $model = '';				//The controller corresponds to the model object.
	
	/**
	 * Set the default class name
	 * @param string $default_controller 
	 */
	public function setDefaultController($default_controller){
		$this -> default_controller = $default_controller;
	} 

	/**
	 * Set the default method name
	 * @param string $default_action 
	 */
	public function setDefaultAction($default_action){
		$this -> default_action = $default_action;
	} 

	/**
	 * Set the controller subdirectory
	 * @param string $dir 
	 */
	public function setSubDir($dir){
		$this -> sub_dir = $dir;
	} 

	/**
	 * Run controller method
	 * @param $class , controller The class name。
	 * @param $function , Method name
	 */
	public function appRun($class,$function){
		$sub_dir = $this -> sub_dir ? $this -> sub_dir . '/' : '';
		$class_file = CONTROLLER_DIR . $sub_dir.$class.'.class.php';
		if (!is_file($class_file)) {
			pr($class.' controller not exists!',1);
		}
		require_once $class_file;
		if (!class_exists($class)) {
			pr($class.' class not exists',1);
		}
		$instance = new $class();
		if (!method_exists($instance, $function)) {
			pr($function.' method not exists',1);
		}
		return $instance -> $function();
	}


	/**
	 * The controller runs automatically load
	 */
	private function autorun(){
		global $config; 
		if (count($config['autorun']) > 0) {
			foreach ($config['autorun'] as $key => $var) {
				$this->appRun($var['controller'],$var['function']);				
			}
		} 
	}

	/**
	 * Called entity classes and methods
	 */
	public function run(){
		$URI = $GLOBALS['in']['URLremote'];
		if (!isset($URI[0]) || $URI[0] == '') $URI[0] = $this->default_controller;
		if (!isset($URI[1]) || $URI[1] == '') $URI[1] = $this->default_action;
		define('ST',$URI[0]);
		define('ACT',$URI[1]);
		//Automatically load and run the class.
		$this->autorun();
		$this->appRun(ST,ACT);
	}
} 
