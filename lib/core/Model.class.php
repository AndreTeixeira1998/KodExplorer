<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

/**
 * Model abstract classes
 * A class on basic behavior of various models, each model must inherit this class method
 */

abstract class Model {
	var $db = null;
	var $in;
	var $config;

	/**
	 * Constructor
	 * @return Null 
	 */
	function __construct(){
		global $g_config, $in;
		$this -> in = $in;
		$this -> config = $config;
	}
	
	/**
	 * TODO db 
	 */
	function db(){
		if ($this ->db != NULL) {
			return $this ->db;
		}else{
			
		}
	}
}