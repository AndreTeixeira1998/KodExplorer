<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

/**
 * The controller abstract class
 */
abstract class Controller {
	public $in;
	public $db;
	public $config;	// Global Configuration
	public $tpl;	// Template directory
	public $values;	// Template Variables
	public $L;

	/**
	 * Constructor
	 */
	function __construct(){
		global $in,$config,$db,$L;

		$this -> db  = $db;
		$this -> L 	 = $L;
		$this -> config = &$config;
		$this -> in = &$in;	
		$this -> values['config'] = &$config;
		$this -> values['in'] = &$in;
	} 

	/**
	 * Load Model
	 * @param string $class 
	 */
	public function loadModel($class){
		$args = func_get_args();
		$this -> $class = call_user_func_array('init_model', $args);
		return $this -> $class;
	} 

	/**
	 * Load library file
	 * @param string $class 
	 */
	public function loadClass($class){
		if (1 === func_num_args()) {
			$this -> $class = new $class;
		} else {
			$reflectionObj = new ReflectionClass($class);
			$args = func_get_args();
			array_shift($args);
			$this -> $class = $reflectionObj -> newInstanceArgs($args);
		}
		return $this -> $class;
	}

	/**
	 * Show Templates
	 * 
	 * TODO smarty
	 * @param
	 */
	protected function assign($key,$value){
		$this->values[$key] = $value;
	} 
	/**
	 * Show Templates
	 * @param
	 */
	protected function display($tpl_file){
		global $L,$LNG;
		extract($this->values);
		require($this->tpl.$tpl_file);
	} 
} 
