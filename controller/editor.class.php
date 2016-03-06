<?php 
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
* @secured by Ben Khlifa Fahmi
*/

class editor extends Controller{
	function __construct()    {
		parent::__construct();
		$this->tpl = TEMPLATE . 'editor/';
	}

	// Multi-file editor
	public function index(){
		$this->display('editor.php');
	}
	// Single-file editor
	public function edit(){
		$this->assign('editor_config',$this->getConfig());//Being editor configuration information
		$this->display('edit.php');
	}

	// Get file data
	public function fileGet(){
		$filename=_DIR($this->in['filename']);
		if (!is_readable($filename)) show_json($this->L['no_permission_read'],false);
		if (filesize($filename) >= 1024*1024*20) show_json($this->L['edit_too_big'],false);

		$filecontents=file_get_contents($filename);//document content
		$charset=get_charset($filecontents);
		if ($charset!='' || $charset!='utf-8') {
			$filecontents=mb_convert_encoding($filecontents,'utf-8',$charset);
		}
		$data = array(
			'ext'		=> get_path_ext($filename),
			'name'      => iconv_app(get_path_this($filename)),
			'filename'	=> rawurldecode($this->in['filename']),
			'charset'	=> $charset,
			'content'	=> $filecontents			
		);
		show_json($data);
	}
	public function fileSave(){
		 if ($_SERVER['HTTP_REFERER'] != $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
       $filestr = rawurldecode($this->in['filestr']);
		$charset = $this->in['charset'];
		$path =_DIR($this->in['path']);
		if (!is_writable($path)) show_json($this->L['no_permission_write_file'],false);
		
		if ($charset !='' || $charset != 'utf-8') {
			$filestr=mb_convert_encoding($filestr,$this->in['charset'],'utf-8');
		}
		$fp=fopen($path,'wb');
		fwrite($fp,$filestr);
		fclose($fp);
		show_json($this->L['save_success']);
}}else{
	header('Location: index.php');
}
	}

	/*
	* Being editor configuration information
	*/
	public function getConfig(){
		$default = array(
			'font_size'		=> '15px',
			'theme'			=> 'clouds',
			'auto_wrap'		=> 0,
			'display_char'	=> 0,
			'auto_complete'	=> 1,
			'function_list' => 1
		);
		$config_file = USER.'data/editor_config.php';		
		if (!file_exists($config_file)) {//It does not exist, create
			$sql=new fileCache($config_file);
			$sql->reset($default);
		}else{
			$sql=new fileCache($config_file);
			$default = $sql->get();
		}
		if (!isset($default['function_list'])) {
			$default['function_list'] = 1;
		}
		return json_encode($default);
    }
	/*
	* Being editor configuration information
	*/
	public function setConfig(){
		$file = USER.'data/editor_config.php';	
        if (!is_writeable($file)) {//Configuration can not be written
            show_json($this->L['no_permission_write_file'],false);
        }
		$key= $this->in['k'];
		$value = $this->in['v'];
        if ($key !='' && $value != '') {
        	$sql=new fileCache($file);
        	if(!$sql->update($key,$value)){
        		$sql->add($key,$value);//Not then add a
        	}
            show_json($this->L["setting_success"]);
        }else{
            show_json($this->L['error'],false);
        }
    }

    //-----------------------------------------------
	/*
	* Get string encoding
	* @param:$ext Incoming string
	*/
	private function _get_charset(&$str) {
		if ($str == '') return 'utf-8';
		//The success of the previously detected automatically ignore the back
		$charset=strtolower(mb_detect_encoding($str,$this->config['check_charset']));
		if (substr($str,0,3)==chr(0xEF).chr(0xBB).chr(0xBF)){
			$charset='utf-8';
		}else if($charset=='cp936'){
			$charset='gbk';
		}
		if ($charset == 'ascii') $charset = 'utf-8';
		return strtolower($charset);
	}
}
