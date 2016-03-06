<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

/**
 * System function: filesize (), file_exists (), pathinfo (), rname (), unlink (), filemtime (), is_readable (), is_wrieteable ();
 * Get file details file_info ($ file_name)
 * Get more information folder path_info ($ dir)
 * Get recursive folder information path_info_more ($ dir, & $ file_num = 0, & $ path_num = 0, & $ size = 0)
 * Get the file folder list path_list ($ dir)
 * Path of the current file [Folder] name get_path_this ($ path)
 * Get the path to the parent directory get_path_father ($ path)
 * Delete files del_file ($ file)
 * Recursive delete folders del_dir ($ dir)
 * Recursively copy a folder copy_dir ($ source, $ dest)
 * Create a directory mk_dir ($ dir, $ mode = 0777)
 * File Size Format size_format ($ bytes, $ precision = 2)
 * Determine whether the absolute path path_is_absolute ($ path)
 * The extension of the file type ext_type ($ ext)
 * File Download file_download ($ file)
 * Download the file to the server file_download_this ($ from, $ file_name)
 * Get the file (folder) permissions get_mode ($ file) // rwx_rwx_rwx [filename coding system required]
 * Upload files (single, multiple) upload ($ fileInput, $ path = './');//
 * Get the configuration file entries get_config ($ file, $ ini, $ type = "string")
 * Modify the configuration file entries update_config ($ file, $ ini, $ value, $ type = "string")
 * Write logs to LOG_PATH under write_log ( 'dd', 'default |. Self directory.', 'Log | error | warning | debug | info | db')
 */
// Parameter passed to procedure codes have heard, the application code,
// Parameters are not passed and are not related to output, then processed into incoming coding system.
function iconv_app($str){
	global $config;
	$result = iconv($config['system_charset'], $config['app_charset'], $str);
	if (strlen($result)==0) {
		$result = $str;
	}
	return $result;
}
function iconv_system($str){
	global $config;
	$result = iconv($config['app_charset'], $config['system_charset'], $str);
	if (strlen($result)==0) {
		$result = $str;
	}
	return $result;
}

function get_filesize($path){
	@$ret = abs(sprintf("%u",filesize($path))); 
	return (int)$ret;
}
/**
  * Get file details
  * Filename conversion from the program code into a coding system, incoming utf8, the system needs to function gbk
  */
function file_info($path){
	$name = get_path_this($path);
	$size = get_filesize($path);
	$info = array(
		'name'			=> iconv_app($name),
		'path'			=> iconv_app(get_path_father($path)),
		'ext'			=> get_path_ext($path),
		'type' 			=> 'file',
		'mode'			=> get_mode($path),
		'atime'			=> fileatime($path), //Last access time
		'ctime'			=> filectime($path), //Created
		'mtime'			=> filemtime($path), //Last Modified
		'is_readable'	=> intval(is_readable($path)),
		'is_writeable'	=> intval(is_writeable($path)),
		'size'			=> $size,
		'size_friendly'	=> size_format($size, 2)
	);
	return $info;
}
/**
 * Get folder information
 */
function folder_info($path){
	$info = array(
		'name'			=> iconv_app(get_path_this($path)),
		'path'			=> iconv_app(get_path_father($path)),
		'type' 			=> 'folder',
		'mode'			=> get_mode($path),
		'atime'			=> fileatime($path), //interview time
		'ctime'			=> filectime($path), //Created
		'mtime'			=> filemtime($path), //Last Modified		
		'is_readable'	=> intval(is_readable($path)),
		'is_writeable'	=> intval(is_writeable($path))
	);
	return $info;
}


/**
 * Gets a path (file folder c) the current file [Folder] name
 * test/11/ ==>11 test/1.c  ==>1.c
 */
function get_path_this($path){
    $path = str_replace('\\','/', rtrim(trim($path),'/'));
    return substr($path,strrpos($path,'/')+1);
} 
/**
 * Gets a path (file folder c) parent directory
 * /test/11/==>/test/   /test/1.c ==>/www/test/
 */
function get_path_father($path){
    $path = str_replace('\\','/', rtrim(trim($path),'/'));
    return substr($path, 0, strrpos($path,'/')+1);
}
/**
 * Get extensions
 */
function get_path_ext($path){
    $name = get_path_this($path);
    $ext = '';
    if(strstr($name,'.')){
        $ext = substr($name,strrpos($name,'.')+1);
        $ext = strtolower($ext);
    }
    if (strlen($ext)>3 && preg_match("/([\x81-\xfe][\x40-\xfe])/", $ext, $match)) {
        $ext = '';
    }
    return $ext;
}



//Does not automatically obtain duplicate files (folder) name
//If the incoming $file_add is detected the presence of the custom rename a.txt as a {$ file_add} .txt
function get_filename_auto($path,$file_add = "",$same_file_type=''){
	if (is_dir($path)) {//Folders are ignored
		return $path;
	}

	//Chong Ming treatment; replace, skip, filename auto
	if ($same_file_type == '') {
		$same_file_type = 'replace';
	}


	//Processing the same name
	if (file_exists($path)) {
		if ($same_file_type=='replace') {
			return $path;
		}else if($same_file_type=='skip'){
			return false;
		}
	}

	$i=1;
	$father = get_path_father($path);
	$name =  get_path_this($path);
	$ext = get_path_ext($name);
	if (strlen($ext)>0) {
		$ext='.'.$ext;
		$name = substr($name,0,strlen($name)-strlen($ext));
	}
	while(file_exists($path)){
		if ($file_add != '') {
			$path = $father.$name.$file_add.$ext;
			$file_add.='-';
		}else{
			$path = $father.$name.'('.$i.')'.$ext;
			$i++;
		}
	}
	return $path;
}

/**
 * Analyzing folder is writable
 */
function path_writable($path) {	
	$file = $path.'/test'.time().'.txt';
	$dir  = $path.'/test'.time();
	if(@is_writable($path) && @touch($file) && @unlink($file)) return true;
	if(@mkdir($dir,0777) && @rmdir($dir)) return true;
	return false;
}

/**
 * Get more information folder, call the folder attributes, including sub-folders, number of files, the total size
 */
function path_info($path){
	//if (!is_dir($path)) return false;
	$pathinfo = _path_info_more($path);//子目录文件大小统计信息
	$folderinfo = folder_info($path);
	return array_merge($pathinfo,$folderinfo);
}

/**
 * Check the name of legality
 */
function path_check($path){
	$check = array('/','\\',':','*','?','"','<','>','|');
	$path = rtrim($path,'/');
	$path = get_path_this($path);
	foreach ($check as $v) {
		if (strstr($path,$v)) {
			return false;
		}
	}
	return true;
}

/**
 * Get recursive folder information: the number of sub-folders, number of files, the total size
 */
function _path_info_more($dir, &$file_num = 0, &$path_num = 0, &$size = 0){
	if (!$dh = opendir($dir)) return false;
	while (($file = readdir($dh)) !== false) {
		if ($file != "." && $file != "..") {
			$fullpath = $dir . "/" . $file;
			if (!is_dir($fullpath)) {
				$file_num ++;
				$size += get_filesize($fullpath);
			} else {
				_path_info_more($fullpath, $file_num, $path_num, $size);
				$path_num ++;
			} 
		} 
	} 
	closedir($dh);
	$pathinfo['file_num'] = $file_num;
	$pathinfo['folder_num'] = $path_num;
	$pathinfo['size'] = $size;
	$pathinfo['size_friendly'] = size_format($size);
	return $pathinfo;
} 


/**
 * Get more information on the selected file, containing sub-folders, number of files, the total size of the parent directory permissions
 */
function path_info_muti($list,$time_type){
	if (count($list) == 1) {
		if ($list[0]['type']=="folder"){
	        return path_info($list[0]['path'],$time_type);
	    }else{
	        return file_info($list[0]['path'],$time_type);
	    }
	}
	$pathinfo = array(
		'file_num'		=> 0,
		'folder_num'	=> 0,
		'size'			=> 0,
		'size_friendly'	=> '',
		'father_name'	=> '',
		'mod'			=> ''
	);
	foreach ($list as $val){
		if ($val['type'] == 'folder') {
			$pathinfo['folder_num'] ++;
			$temp = path_info($val['path']);
			$pathinfo['folder_num']	+= $temp['folder_num'];
			$pathinfo['file_num']	+= $temp['file_num'];
			$pathinfo['size'] 		+= $temp['size'];
		}else{
			$pathinfo['file_num']++;
			$pathinfo['size'] += get_filesize($val['path']);
		}
	}
	$pathinfo['size_friendly'] = size_format($pathinfo['size']);
	$father_name = get_path_father($list[0]['path']);
	$pathinfo['mode'] = get_mode($father_name);
	return $pathinfo;
}

/** 
* Get a list of the information folder
  * Dir Contains Ends / d: / wwwroot / test /
  * Needs to read the incoming folder path for program code
 */
function path_list($dir,$list_file=true,$check_children=false){
	$dir = rtrim($dir,'/').'/';
	if (!is_dir($dir) || !($dh = opendir($dir))){
		return array('folderlist'=>array(),'filelist'=>array());
	}
	$folderlist = array();$filelist = array();//文件夹与文件
	while (($file = readdir($dh)) !== false) {
		if ($file != "." && $file != ".." && $file != ".svn" ) {
			$fullpath = $dir . $file;
			if (is_dir($fullpath)) {
				$info = folder_info($fullpath);
				if($check_children){
					$info['isParent'] = path_haschildren($fullpath,$list_file);
				}
				$folderlist[] = $info;
			} else if($list_file) {//是否列出文件
				$info = file_info($fullpath);
				if($check_children) $info['isParent'] = false;
				$filelist[] = $info;
			}
		}
	}
	closedir($dh);
	return array('folderlist' => $folderlist,'filelist' => $filelist);
}

// Determine whether the folder containing the file is divided into sub-content [or] considered only filter folder
function path_haschildren($dir,$check_file=false){
	$dir = rtrim($dir,'/').'/';
	if (!$dh = @opendir($dir)) return false;
	while (($file = readdir($dh)) !== false){
		if ($file != "." && $file != "..") {
			$fullpath = $dir.$file;
			if ($check_file) {//Subdirectories or files illustrate the sub-content
				if(is_file($fullpath) || is_dir($fullpath.'/')){
					return true;
				}
			}else{//There are no checks only files
				@$ret =(is_dir($fullpath.'/'));
				return (bool)$ret;
			}
		} 
	} 	
	closedir($dh);
	return false;
}

/**
 * Delete the file encoding parameters passed to the operating system encoding win -. Gbk
 */
function del_file($fullpath){
	if (!@unlink($fullpath)) { // 删除不了，尝试修改文件权限
		@chmod($fullpath, 0777);
		if (!@unlink($fullpath)) {
			return false;
		} 
	} else {
		return true;
	}
} 

/**
 * To delete a folder for incoming parameter encoding for the operating system encoding win -. Gbk
 */
function del_dir($dir){
	if (!$dh = opendir($dir)) return false;
	while (($file = readdir($dh)) !== false) {
		if ($file != "." && $file != "..") {
			$fullpath = $dir . '/' . $file;
			if (!is_dir($fullpath)) {
				if (!unlink($fullpath)) { // Not deleted, try to modify the file permissions
					chmod($fullpath, 0777);
					if (!unlink($fullpath)) {
						return false;
					} 
				} 
			} else {
				if (!del_dir($fullpath)) {
					chmod($fullpath, 0777);
					if (!del_dir($fullpath)) return false;
				} 
			} 
		} 
	}
	closedir($dh);
	if (rmdir($dir)) {
		return true;
	} else {
		return false;
	} 
} 

/**
* Copy Folder
  * Eg: to D: / wwwroot / copied to the following wordpress
  * D: / wwwroot / www / explorer / 0000 / del / 1 /
  * Do not need to add a slash at the end, if we do not address copied to the source folder name,
  * Copies the following files to the wordpress D: / wwwroot / www / explorer / 0000 / del / 1 / below
  * $ From = 'D: / wwwroot / wordpress';
  * $ To = 'D: / wwwroot / www / explorer / 0000 / del / 1 / wordpress';
 */

function copy_dir($source, $dest){
	if (!$dest) return false;

	if ($source == substr($dest,0,strlen($source))) return;//Prevent the parent folder copied to a subfolder, infinite recursion
	$result = false;
	if (is_file($source)) {
		if ($dest[strlen($dest)-1] == '/') {
			$__dest = $dest . "/" . basename($source);
		} else {
			$__dest = $dest;
		} 
		$result = copy($source, $__dest); 
		chmod($__dest, 0777);
	}elseif (is_dir($source)) {
		if ($dest[strlen($dest)-1] == '/') {
			$dest = $dest . basename($source);		
		}
		if (!is_dir($dest)) {
			mkdir($dest,0777);
		}
		if (!$dh = opendir($source)) return false;
		while (($file = readdir($dh)) !== false) {
			if ($file != "." && $file != "..") {
				if (!is_dir($source . "/" . $file)) {
					$__dest = $dest . "/" . $file;
				} else {
					$__dest = $dest . "/" . $file;
				} 
				$result = copy_dir($source . "/" . $file, $__dest);
			} 
		} 
		closedir($dh);
	}
	return $result;
}

/**
 * Create a directory
 * 
 * @param string $dir 
 * @param int $mode 
 * @return bool 
 */
function mk_dir($dir, $mode = 0777){
	if (is_dir($dir) || @mkdir($dir, $mode)){		
		return true;
	}
	if (!mk_dir(dirname($dir), $mode)){		
		return false;		
	}
	return @mkdir($dir, $mode);
}

/*
* Get a list of files & folders (supports folder hierarchy)
* Path: Folder $ dir - return folder array files - files array returned
* $ Deepest is complete recursive; $ deep recursion level
*/
function recursion_dir($path,&$dir,&$file,$deepest=-1,$deep=0){
	$path = rtrim($path,'/').'/';
	if (!is_array($file)) $file=array();
	if (!is_array($dir)) $dir=array();
	if (!$dh = opendir($path)) return false;
	while(($val=readdir($dh)) !== false){
		if ($val=='.' || $val=='..') continue;
		$value = strval($path.$val);
		if (is_file($value)){
			$file[] = $value;
		}else if(is_dir($value)){
			$dir[]=$value;
			if ($deepest==-1 || $deep<$deepest){
				recursion_dir($value."/",$dir,$file,$deepest,$deep+1);
			}
		}
	}
	closedir($dh);
	return true;
}
/*
* $ Search is a string containing
  * Is_content indicates whether to search for the file contents; the default does not search
  * Is_case indicates case-insensitive, does not distinguish between the default
 */
function path_search($path,$search,$is_content=false,$file_ext='',$is_case=false){
	$ext_arr=explode("|",$file_ext);
	recursion_dir($path,$dirs,$files,-1,0);
	$strpos = 'stripos';//是否区分大小写
	if ($is_case) $strpos = 'strpos';
	
	$filelist = array();
	$folderlist = array();
	foreach($files as $f){
		$ext = get_path_ext($f);
		$path_this = get_path_this($f);
		if ($file_ext !='' && !in_array($ext,$ext_arr)) continue;//User-defined file type is not within
		if ($strpos($path_this,$search) !== false){//Search for file names; search to return; not search continues
			$filelist[] = file_info($f);
			continue;
		}
		if ($is_content && is_file($f)){
			$fp = fopen($f, "r");
			$content = @fread($fp,get_filesize($f));
			fclose($fp);
			if ($strpos($content,iconv_app($search)) !== false){
				$filelist[] = file_info($f);
			}
		}
	}
	if ($file_ext == '') {//Extension is not limited only to search folders
		foreach($dirs as $f){
			$path_this = get_path_this($f);
			if ($strpos($path_this,$search) !== false){
				$folderlist[]= array(
					'name'  => iconv_app(get_path_this($f)),
					'path'  => iconv_app(get_path_father($f))			
				);
			}
		}
	}
	return array('folderlist' => $folderlist,'filelist' => $filelist);
}

/**
* Modify the file, folder permissions
  * @param $ Path file (folder) directory
  * @return: String
 */
function chmod_path($path,$mod){
	//$mod = 0777;//
	if (!isset($mod)) $mod = 0777;
	if (!is_dir($path)) return @chmod($path,$mod);
	if (!$dh = opendir($path)) return false;
	while (($file = readdir($dh)) !== false){
		if ($file != "." && $file != "..") {
			$fullpath = $path . '/' . $file;
			chmod($fullpath,$mod);
			return chmod_path($fullpath,$mod);
		} 
	}
	closedir($dh);
	return chmod($path,$mod);
} 

/**
* File size Format
  *
  * @param $: $ Bytes, int file size
  * @param $: $ Precision int decimal places
  * @return: String
 */
function size_format($bytes, $precision = 2){
	if ($bytes == 0) return "0 B";
	$unit = array(
		'TB' => 1099511627776,  // pow( 1024, 4)
		'GB' => 1073741824,		// pow( 1024, 3)
		'MB' => 1048576,		// pow( 1024, 2)
		'kB' => 1024,			// pow( 1024, 1)
		'B ' => 1,				// pow( 1024, 0)
	);
	foreach ($unit as $un => $mag) {
		if (doubleval($bytes) >= $mag)
			return round($bytes / $mag, $precision).' '.$un;
	} 
} 

/**
* Analyzing the path is not an absolute path
  * Returns true ( '/ foo / bar', 'c: \ windows').
  *
  * @return Returns true compared with the absolute path, or a relative path
 */
function path_is_absolute($path){
	if (realpath($path) == $path)// unix absolute path of / home / my
		return true;
	if (strlen($path) == 0 || $path[0] == '.')
		return false;
	if (preg_match('#^[a-zA-Z]:\\\\#', $path))// windows absolute path c: \ aaa \
		return true;
	return (bool)preg_match('#^[/\\\\]#', $path); //Absolute paths run / and \ absolute path, the other was a relative path
} 

/**
 * 获取扩展名的文件类型
 * 
 * @param  $ :$ext string 扩展名
 * @return :string;
 */
function ext_type($ext){
	$ext2type = array(
		'text' => array('txt','ini','log','asc','csv','tsv','vbs','bat','cmd','inc','conf','inf'),
		'code'		=> array('css','htm','html','php','js','c','cpp','h','java','cs','sql','xml'),
		'picture'	=> array('jpg','jpeg','png','gif','ico','bmp','tif','tiff','dib','rle'),
		'audio'		=> array('mp3','ogg','oga','mid','midi','ram','wav','wma','aac','ac3','aif','aiff','m3a','m4a','m4b','mka','mp1','mx3','mp2'),
		'flash'		=> array('swf'),
		'video'		=> array('rm','rmvb','flv','mkv','wmv','asf','avi','aiff','mp4','divx','dv','m4v','mov','mpeg','vob','mpg','mpv','ogm','ogv','qt'),
		'document'	=> array('doc','docx','docm','dotm','odt','pages','pdf','rtf','xls','xlsx','xlsb','xlsm','ppt','pptx','pptm','odp'),
		'rar_achieve'	=> array('rar','arj','tar','ace','gz','lzh','uue','bz2'),
		'zip_achieve'	=> array('zip','gzip','cab','tbz','tbz2'),
		'other_achieve' => array('dmg','sea','sit','sqx')
	);
	foreach ($ext2type as $type => $exts) {
		if (in_array($ext, $exts)) {
			return $type;
		} 
	} 
} 

/**
* Output, file download
  * Default attachment download; $ download is false when compared to the output file
 */
function file_put_out($file,$download=false){
	if (!is_file($file)) show_json('not a file!');
	set_time_limit(0); 
	//ob_clean();//Clear until all output buffers
	if (!file_exists($file)) show_json('file not exists',false);
	if (isset($_SERVER['HTTP_RANGE']) && ($_SERVER['HTTP_RANGE'] != "") && 
		preg_match("/^bytes=([0-9]+)-$/i", $_SERVER['HTTP_RANGE'], $match) && ($match[1] < $fsize)) { 
		$start = $match[1];
	}else{
		$start = 0;
	}
	$size = get_filesize($file);
	$mime = get_file_mime(get_path_ext($file));
	if ($download || strstr($mime,'application/')) {//Download or download application is set head
		$filename = get_path_this($file);//Download IE resolve when Chinese garbage problem
		if( preg_match('/MSIE/',$_SERVER['HTTP_USER_AGENT']) || 
			preg_match('/Trident/',$_SERVER['HTTP_USER_AGENT'])){
			if($GLOBALS['config']['system_os']!='windows'){//win the host ie browser; Chinese file download urlencode problem
				$filename = str_replace('+','%20',urlencode($filename));
			}
		}
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment;filename=".$filename);
	}

	header("Cache-Control: public");
	header("X-Powered-By: kodExplorer.");
	header("Content-Type: ".$mime);
	if ($start > 0){
		header("HTTP/1.1 206 Partial Content");
		header("Content-Ranges: bytes".$start ."-".($size - 1)."/" .$size);
		header("Content-Length: ".($size - $start));		
	}else{
		header("Accept-Ranges: bytes");
		header("Content-Length: $size");
	}

	$fp = fopen($file, "rb");
	fseek($fp, $start);
	while (!feof($fp)) {
		print (fread($fp, 1024 * 8)); //Output File  
		flush(); 
		ob_flush();
	}  
	fclose($fp);
}

/**
* Remote file is downloaded to the server
  * Support for fopen can open; support local, url
 * 
 */
function file_download_this($from, $file_name){
	set_time_limit(0);
	$fp = @fopen ($from, "rb");
	if ($fp){
		$new_fp = @fopen ($file_name, "wb");
		fclose($new_fp);

		$download_fp = @fopen ($file_name, "wb");
		while(!feof($fp)){
			if(!file_exists($file_name)){//Delete the target file; download is terminated
				fclose($download_fp);
				return false;
			}
			fwrite($download_fp, fread($fp, 1024 * 8 ), 1024 * 8);
		}
		//The download is complete, rename the temporary file to the destination
		fclose($download_fp);		
		return true;
	}else{
		return false;
	}	
}

/**
 * Get File (folder) permissions rwx_rwx_rwx
 */
function get_mode($file){
	$Mode = fileperms($file);
	$theMode = ' '.decoct($Mode);
	$theMode = substr($theMode,-4);
	$Owner = array();$Group=array();$World=array();
	if ($Mode &0x1000) $Type = 'p'; // FIFO pipe
	elseif ($Mode &0x2000) $Type = 'c'; // Character special
	elseif ($Mode &0x4000) $Type = 'd'; // Directory
	elseif ($Mode &0x6000) $Type = 'b'; // Block special
	elseif ($Mode &0x8000) $Type = '-'; // Regular
	elseif ($Mode &0xA000) $Type = 'l'; // Symbolic Link
	elseif ($Mode &0xC000) $Type = 's'; // Socket
	else $Type = 'u'; // UNKNOWN 
	// Determine les permissions par Groupe
	$Owner['r'] = ($Mode &00400) ? 'r' : '-';
	$Owner['w'] = ($Mode &00200) ? 'w' : '-';
	$Owner['x'] = ($Mode &00100) ? 'x' : '-';
	$Group['r'] = ($Mode &00040) ? 'r' : '-';
	$Group['w'] = ($Mode &00020) ? 'w' : '-';
	$Group['e'] = ($Mode &00010) ? 'x' : '-';
	$World['r'] = ($Mode &00004) ? 'r' : '-';
	$World['w'] = ($Mode &00002) ? 'w' : '-';
	$World['e'] = ($Mode &00001) ? 'x' : '-'; 
	// Adjuste pour SUID, SGID et sticky bit
	if ($Mode &0x800) $Owner['e'] = ($Owner['e'] == 'x') ? 's' : 'S';
	if ($Mode &0x400) $Group['e'] = ($Group['e'] == 'x') ? 's' : 'S';
	if ($Mode &0x200) $World['e'] = ($World['e'] == 'x') ? 't' : 'T';
	$Mode = $Type.$Owner['r'].$Owner['w'].$Owner['x'].' '.
			$Group['r'].$Group['w'].$Group['e'].' '.
			$World['r'].$World['w'].$World['e'];
	return $Mode.' ('.$theMode.') ';
} 

/**
 * Get the maximum value can upload
 * return * byte
 */
function get_post_max(){
	$upload = ini_get('upload_max_filesize');
	$upload = $upload==''?ini_get('upload_max_size'):$upload;
    $post = ini_get('post_max_size');
	$upload = intval($upload)*1024*1024;
	$post = intval($post)*1024*1024;
	return $upload<$post?$upload:$post;
}

/**
 * Handling file uploads. Single file upload, multiple in multiple requests
 *Call demo
 * upload('file','D:/www/');
 */
function upload($fileInput, $path = './'){
	global $config,$L;
	$file = $_FILES[$fileInput];
	if (!isset($file)) show_json($L['upload_error_null'],false);
	
	$file_name = iconv_system($file['name']);
	$save_path = get_filename_auto($path.$file_name);
	if(move_uploaded_file($file['tmp_name'],$save_path)){
		show_json($L['upload_success'],true,iconv_app($save_pathe));
	}else {
		show_json($L['move_error'],false);
	}
}

//Fragment upload process
function upload_chunk($fileInput, $path = './',$temp_path){
	global $config,$L;
	$file = $_FILES[$fileInput];
	$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
	if (!isset($file)) show_json($L['upload_error_null'],false);
	$file_name = iconv_system($file['name']);

	if ($chunks>1) {//Concurrent upload, not necessarily the order
		$temp_file_pre = $temp_path.md5($temp_path.$file_name).'.part';
		if (get_filesize($file['tmp_name']) ==0) {
			show_json($L['upload_success'],false,'chunk_'.$chunk.' error!');
		}
		if(move_uploaded_file($file['tmp_name'],$temp_file_pre.$chunk)){
			$done = true;
			for($index = 0; $index<$chunks; $index++ ){
			    if (!file_exists($temp_file_pre.$index)) {
			        $done = false;
			        break;
			    }
			}
			if (!$done){				
				show_json($L['upload_success'],true,'chunk_'.$chunk.' success!');
			}

			$save_path = $path.$file_name;
			$out = fopen($save_path, "wb");
			if ($done && flock($out, LOCK_EX)) {
		        for( $index = 0; $index < $chunks; $index++ ) {
		            if (!$in = fopen($temp_file_pre.$index,"rb")) break;
		            while ($buff = fread($in, 4096)) {
		                fwrite($out, $buff);
		            }
		            fclose($in);
		            unlink($temp_file_pre.$index);
		        }
		        flock($out, LOCK_UN);
			    fclose($out);
			}
			show_json($L['upload_success'],true,iconv_app($save_path));
		}else {
			show_json($L['move_error'],false);
		}
	}

	//Normal upload
	$save_path = get_filename_auto($path.$file_name); //Auto Rename
	if(move_uploaded_file($file['tmp_name'],$save_path)){
		show_json($L['upload_success'],true,iconv_app($save_path));
	}else {
		show_json($L['move_error'],false);
	}
}

/**
* Write log
  * @param String $ log log information
  * @param String $ type log type [system | app | ...]
  * @param String $ level log level
 * @return boolean
 */
function write_log($log, $type = 'default', $level = 'log'){
	$now_time = date('[y-m-d H:i:s]');
	$now_day  = date('Y_m_d');
	// Depending on the type Set the log destination
	$target   = LOG_PATH . strtolower($type) . '/';
	mk_dir($target, 0777);
	if (! is_writable($target)) exit('path can not write!');
	switch($level){// 分级写日志
		case 'error':	$target .= 'Error_' . $now_day . '.log';break;
		case 'warning':	$target .= 'Warning_' . $now_day . '.log';break;
		case 'debug':	$target .= 'Debug_' . $now_day . '.log';break;
		case 'info':	$target .= 'Info_' . $now_day . '.log';break;
		case 'db':		$target .= 'Db_' . $now_day . '.log';break;
		default:		$target .= 'Log_' . $now_day . '.log';break;
	}
	//Test log file size exceeds the configured size rename
	if (file_exists($target) && get_filesize($target) <= 100000) {
		$file_name = substr(basename($target),0,strrpos(basename($target),'.log')).'.log';
		rename($target, dirname($target) .'/'. $file_name);
	}
	clearstatcache();
	return error_log("$now_time $log\n", 3, $target);
}