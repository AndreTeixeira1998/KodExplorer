<?php 
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/


//Configuration data, you can change the cover in setting user.php
$config['settings'] = array(
	'download_url_time'	=> 0,			//Download the effective time, in seconds, 0 for no limit, no limit default
	'upload_chunk_size'	=> 1024*1024*2,	//Upload fragment size; default 1M
	'version_desc'		=> 'product',
);


//Initialize the system configuration
$config['setting_system_default'] = array(
	'system_password'	=> rand_string(10),
	'system_name'		=> "KodExplorer",
	'system_desc'		=> "- Mango Cloud Explorer",
	'path_hidden'		=> ".DS_Store,.gitignore",//Directory listing hidden items
	'auto_login'		=> "0",			// Whether to automatically log in; the login user is guest
	'first_in'			=> "explorer",	// After logging in to enter [explorer desktop, editor]
	'new_user_app'		=> "365 calendar, pptv live, pps, qq music, Sohu video, clock, weather, fruit ninja, calculator, watercress radio, Yin Yue Taiwan, icloud", // this may break
	'new_user_folder'	=> "download,music,image,desktop",
);

// Optional configuration value entries
$config['setting_all'] = array(
	'language' 		=> "en:English,zh_CN:简体中文,zh_TW:繁體中文",
	'themeall'		=> "default/:<b>areo blue</b>:default,simple/:<b>simple</b>:simple,metro/:<b>metro</b>:metro,metro/blue_:metro-blue:color,metro/leaf_:metro-green:color,metro/green_:metro-green+:color,metro/grey_:metro-grey:color,metro/purple_:metro-purple:color,metro/pink_:metro-pink:color,metro/orange_:metro-orange:color",
	'codethemeall'	=> "chrome,clouds,crimson_editor,eclipse,github,solarized_light,tomorrow,xcode,ambiance,idle_fingers,monokai,pastel_on_dark,solarized_dark,tomorrow_night_blue,tomorrow_night_eighties",
	'wallall'		=> "1,2,3,4,5,6,7,8,9,10,11,12,13",
	'musicthemeall'	=> "ting,beveled,kuwo,manila,mp3player,qqmusic,somusic,xdj",
	'moviethemeall'	=> "webplayer,qqplayer,vplayer,tvlive,youtube"
);

//New user initial configuration
$config['setting_default'] = array(
	'list_type'			=> "icon",		// list||icon
	'list_sort_field'	=> "name",		// name||size||ext||mtime
	'list_sort_order'	=> "up",		// asc||desc
	'theme'				=> "simple/",	// app theme [default,simple,metro/,metro/black....]
	'codetheme'			=> "clouds",	// code editor theme
	'wall'				=> "7",			// wall picture
	'musictheme'		=> "mp3player",	// music player theme
	'movietheme'		=> "webplayer"	// movie player theme
);

//Initialize the default menu configuration
$config['setting_menu_default'] = array(
	array('name'=>'desktop','type'=>'system','url'=>'index.php?desktop','target'=>'_self','use'=>'1'),
	array('name'=>'explorer','type'=>'system','url'=>'index.php?explorer','target'=>'_self','use'=>'1'),
	array('name'=>'editor','type'=>'system','url'=>'index.php?editor','target'=>'_self','use'=>'1'),
	array('name'=>'adminer','type'=>'','url'=>'./lib/plugins/adminer/','target'=>'_blank','use'=>'1')
);

// Permission configuration; needs to be done to accurately controller and method of access control
// Needs permission Certified Action; root group privileges disregard
$config['role_setting'] = array(
	'explorer'	=> array(
		'mkdir','mkfile','pathRname','pathDelete','zip','unzip','pathCopy','pathChmod',
		'pathCute','pathCuteDrag','pathCopyDrag','clipboard','pathPast','pathInfo',
		'serverDownload','fileUpload','search','pathDeleteRecycle',
		'fileDownload','zipDownload','fileDownloadRemove','fileProxy','officeView','officeSave'),
	'app'		=> array('user_app','init_app','add','edit','del'),//
	'user'		=> array('changePassword'),//You can set up the public accounts
	'editor'	=> array('fileGet','fileSave'),
	'userShare' => array('set','del'),
	'setting'	=> array('set','system_setting','php_info'),
	'fav'		=> array('add','del','edit'),
	'member'	=> array('get','add','del','edit'),
	'group'		=> array('get','add','del','edit'),
);
