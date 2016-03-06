<?php 
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/

class share extends Controller{
    private $sql;
    private $share_info;
    private $share_path;
    private $path;
    function __construct(){
        parent::__construct();
        $this->tpl = TEMPLATE.'share/';

        //No need to check the action
        $arr_not_check = array('common_js');
        if (!in_array(ACT,$arr_not_check)){
            $this->_check_share();
            $this->_init_info();
            $this->assign('can_download',$this->share_info['not_download']=='1'?0:1);
        }
        //You need to check permissions download Action
        $arr_check_download = array('fileDownload','zipDownload','fileProxy','fileGet');//'fileProxy','fileGet'
        if (in_array(ACT,$arr_check_download)){
            if ($this->share_info['not_download']=='1') {
                show_json($this->L['share_not_download_tips'],false);
            }
        }
        //After the download is prohibited; no preview will 'fileProxy','fileGet'
        if (ACT == 'file' && $this->share_info['not_download']=='1') {
            $this->error($this->L['share_not_download_tips']);
        }
    }
    //======//
    private function _check_share(){
        if (!isset($this->in['user']) || !isset($this->in['sid'])) {
            $this->error($this->L['share_error_param']);
        }
        //Storing the information shared infrastructure
        $share_data = USER_PATH.$this->in['user'].'/data/share.php';
        if (!file_exists($share_data)) {
            $this->error($this->L['share_error_user']);
        }
        $this->sql=new fileCache($share_data);
        $list = $this->sql->get();
        if (!isset($list[$this->in['sid']])){
            $this->error($this->L['share_error_sid']);
        }

        $this->share_info = $list[$this->in['sid']];
        $share_info = $this->share_info;
        //Check if expired
        if (isset($share_info['time'])&&
            $share_info['time'].length!=0) {
            $date = date_create_from_format('y/m/d',$share_info['time_to']);
            if (time() > $date) {
                $this->error($this->L['share_error_time']);
            }
        }
        
        //Password Detection
        if ($share_info['share_password']=='') return;
        //if ($_SESSION['kod_user']['name']==$this->in['user']) return;

        //Submit password
        if (!isset($this->in['password'])){
            //enter password
            if ($_SESSION['password_'.$this->in['sid']]==$share_info['share_password']) return;
            $this->error('password');
        }else{
            if ($this->in['password'] == $share_info['share_password']) {
                session_start();
                $_SESSION['password_'.$this->in['sid']]=$share_info['share_password'];
                show_json('success');
            }else{
                show_json($this->L['share_error_password'],false);
            }
        }
    }
    private function _init_info(){
        //Get user groups, defined according to whether the root prefix
        $member = new fileCache(USER_SYSTEM.'member.php');
        $user = $member->get($this->in['user']);
        if (!is_array($user) || !isset($user['password'])) {
            $this->error($this->L['share_error_user']);
        }        
        define('USER',USER_PATH.$user['name'].'/');
        define('USER_TEMP',USER.'data/share_temp/');

        $share_path = _DIR_CLEAR($this->share_info['path']);
        if (substr($share_path,0,strlen('*public*/')) == '*public*/') {
            $share_path = PUBLIC_PATH.str_replace('*public*/','',$share_path);
        }else{
            if ($user['role'] != 'root') {
                $share_path = USER.'home/'.$share_path;
            }else{
                $share_path = _DIR_CLEAR($this->share_info['path']);
            }
        }

        if ($this->share_info['type'] != 'file'){
            $share_path=rtrim($share_path,'/').'/';
            define('HOME',$share_path);//dir_out When used as a prefix removed; system
        }

        $share_path = iconv_system($share_path);
        if (!file_exists($share_path)) {
            $this->error($this->L['share_error_path']);
        }
        $this->share_path = $share_path;
        $path_full = isset($this->in['path'])?$this->in['path']:'';
        $this->path = $share_path.$this->_clear($path_full);
    }
    private function _clear($path){
        return  iconv_system(_DIR_CLEAR(rawurldecode($path)));
    }
    private function error($msg){
        $this->assign('msg',$msg);
        $this->display('tips.php');
        exit;
    }

    //==========================
    /*
     * File Browser
     */
    public function file() {
        $this->share_view_add();
        if ($this->share_info['type']!='file') {
            $this->share_info['name'] = get_path_this($this->path);
        }
        $size = filesize($this->path);
        $this->share_info['size'] = size_format($size);
        $this->_assign_info();
        $this->display('file.php');
    }
    /*
     * Folder browsing
     */
    public function folder() {
        $this->share_view_add();
        if(isset($this->in['path']) && $this->in['path'] !=''){
            $dir = '/'._DIR_CLEAR($this->in['path']);
        }else{
            $dir = '/';//For the first time into the system, with no arguments
        }
        $dir = '/'.trim($dir,'/').'/';
        $this->_assign_info();
        $this->assign('dir',$dir);
        $this->display('explorer.php');
    }
    /*
     * Code reader
     */
    public function code_read() {
        $this->share_view_add();
        $this->_assign_info();
        $this->display('editor.php');
    }

    //==========================
    //Page unified variable injection
    private function _assign_info(){
        $user_config = new fileCache(USER.'data/config.php');
        $config = $user_config->get();
        if (count($config)<1) {
            $config = $GLOBALS['config']['setting_default'];
        }
        $this->assign('config_theme',$config['theme']);
        $this->share_info['share_password'] = '';
        $this->share_info['num_view'] = intval($this->share_info['num_view']);

        $this->share_info['num_download'] = isset($this->share_info['num_download'])?
            intval($this->share_info['num_download']):0;
        $this->share_info['path'] = get_path_this(iconv_app($this->path));
        $this->assign('share_info',$this->share_info);
    }
    //Statistics downloads
    private function share_download_add(){
        $num = abs(intval($this->share_info['num_download'])) +1;
        $this->share_info['num_download'] = $num;        
        $this->sql->update($this->in['sid'],$this->share_info);
    }
    //Views statistics
    private function share_view_add(){
        $num = abs(intval($this->share_info['num_view'])) +1;
        $this->share_info['num_view'] = $num;        
        $this->sql->update($this->in['sid'],$this->share_info);
    }
    public function common_js(){
        $config = $GLOBALS['config']['setting_default'];
        $the_config = array(
            'lang'          => LANGUAGE_TYPE,
            'is_root'       => 0,
            'web_root'      => '/',
            'web_host'      => HOST,
            'static_path'   => STATIC_PATH,
            'basic_path'    => BASIC_PATH,
            'version'       => KOD_VERSION,
            'app_host'      => APPHOST,
            'office_server' => OFFICE_SERVER,
            'json_data'     => "",
            'share_page'    => 'share',

            'theme'         => $config['theme'],           //List sorted by the field
            'list_type'     => $config['list_type'],       //List sorted by the field
            'sort_field'    => $config['list_sort_field'], //List sorted by the field
            'sort_order'    => $config['list_sort_order'], //The list is sorted in ascending or descending order
            'musictheme'    => $config['musictheme'],
            'movietheme'    => $config['movietheme']
        );

        //show_json($this->L);
        $js  = 'LNG='.json_encode($GLOBALS['L']).';';
        $js .= 'AUTH=[];';
        $js .= 'G='.json_encode($the_config).';';
        header("Content-Type:application/javascript");
        echo $js;
    }


    //========ajax function============
    public function pathInfo(){
        $info_list = json_decode($this->in['list'],true);
        foreach ($info_list as &$val) {          
            $val['path'] = $this->share_path.$this->_clear($val['path']);
        }
        $data = path_info_muti($info_list,$this->L['time_type_info']);
        _DIR_OUT($data['path']);
        show_json($data);
    }
    public function fileSave(){
        show_json($this->L['no_permission'],false);
    }

    // Single-file editor
    public function edit(){
        $default = array(
            'font_size'     => '14px',
            'theme'         => 'clouds',
            'auto_wrap'     => 0,
            'display_char'  => 0,
            'auto_complete' => 1,
            'function_list' => 1
        );
        $this->_assign_info();
        $this->assign('editor_config',$default);//Being editor configuration information
        $this->display('edit.php');
    }
    public function pathList(){
        $list=$this->path($this->path);
        show_json($list);
    }
    public function treeList(){
        $path=$this->path;
        if (isset($this->in['project'])) {
            $path = $this->share_path.$this->_clear($this->in['project']);
        }
        if (isset($this->in['name'])){
            $path=$path.'/'.$this->_clear($this->in['name']);
        }
        $list_file = ($this->in['app'] == 'editor'?true:false);//List the files in the Editor
        $list=$this->path($path,$list_file,true);
        function sort_by_key($a, $b){
            if ($a['name'] == $b['name']) return 0;
            return ($a['name'] > $b['name']) ? 1 : -1;
        }
        usort($list['folderlist'], "sort_by_key");
        usort($list['filelist'], "sort_by_key");

        $result = array_merge($list['folderlist'],$list['filelist']);
        if ($this->in['app'] != 'editor') {
            $result =$list['folderlist'];
        }
        if ($this->in['type']=='init') {
            $result = array(
                array(
                    'name'=>iconv_app(get_path_this($path)),
                    'children'=>$result,
                    'menuType'=>"menuTreeRoot",
                    'open'=>true,
                    'this_path'=> '/',
                    'isParent'=>count($result)>0?true:false
                )
            );
        }
        show_json($result);
    }

    public function search(){
        if (!isset($this->in['search'])) show_json($this->L['please_inpute_search_words'],false);
        $is_content = false;
        $is_case    = false;
        $ext        = '';
        if (isset($this->in['is_content'])) $is_content = true;
        if (isset($this->in['is_case'])) $is_case = true;
        if (isset($this->in['ext'])) $ext= str_replace(' ','',$this->in['ext']);
        $list = path_search(
            $this->path,
            iconv_system($this->in['search']),
            $is_content,$ext,$is_case);
        _DIR_OUT($list);
        show_json($list);
    }

    //Generate temporary key file
    public function officeView(){
        if (!file_exists($this->path)) {
            show_tips("file not exists!");
        }
        if (file_exists(LIB_DIR.'plugins/officeView')) {
            include(LIB_DIR.'plugins/officeView/index.php');
            exit;
        }
        $file_url = $this->_make_file_proxy($this->path);
        $host = $_SERVER['server_name'];
        //Preview Microsoft interface calls
        if (strstr($host,'10.10.') ||
            strstr($host,'192.168.')||
            strstr($host,'127.0.') ||
            !strstr($host,'.')) {
            $local_tips = $this->L['unknow_file_office'].
            ', <a href="http://kalcaddle.com/help.html#office" target="_blank">'.
            $this->L['more'].'>></a>';
            show_tips($local_tips);
        }else{
            $office_url = OFFICE_SERVER.rawurlencode($file_url);
            header("location:".$office_url);
        }
    }
    

    //Agent output
    public function fileProxy(){
        $mime = get_file_mime(get_path_ext($this->path));
        if($mime == 'text/plain'){//Then turn text encoding
            $filecontents = file_get_contents($this->path);
            $charset=get_charset($filecontents);
            if ($charset!='' || $charset!='utf-8') {
                $filecontents=mb_convert_encoding($filecontents,'utf-8',$charset);
            }
            echo $filecontents;
            return;
        }
        file_put_out($this->path);
    }
    public function fileDownload(){
        $this->share_download_add();
        file_put_out($this->path,true);
    }
    //After deleting the file download for download folder
    public function fileDownloadRemove(){
        if ($this->share_info['not_download']=='1') {
            show_json($this->L['share_not_download_tips'],false);
        }
        $path = rawurldecode(_DIR_CLEAR($this->in['path']));
        $path = USER_TEMP.iconv_system($path);
        file_put_out($path,true);
        del_file($path);
    }
    public function zipDownload(){
        $this->share_download_add();
        if(!file_exists(USER_TEMP)){
            mkdir(USER_TEMP);
        }else{  // Clear the temporary files are not deleted, the day before
            $list = path_list(USER_TEMP,true,false);
            $max_time = 3600*24;
            if ($list['filelist']>=1) {
                for ($i=0; $i < count($list['filelist']); $i++) { 
                    $create_time = $list['filelist'][$i]['mtime']; //Last Modified
                    if(time() - $create_time >$max_time){
                        del_file($list['filelist'][$i]['path'].$list['filelist'][$i]['name']);
                    }
                }
            }
        }
        $zip_file = $this->zip(USER_TEMP);
        show_json($this->L['zip_success'],true,get_path_this($zip_file));
    }
    private function zip($zip_path){
        if (!isset($zip_path)) {
            show_json($this->L['share_not_download_tips'],false);
        }
        load_class('pclzip');
        ini_set('memory_limit', '2028M');//2G;
        $zip_list = json_decode($this->in['list'],true);
        $list_num = count($zip_list);
        for ($i=0; $i<$list_num; $i++) { 
            $zip_list[$i]['path'] = _DIR_CLEAR($this->path.$this->_clear($zip_list[$i]['path']));
        }
        
        //Specified directory
        if ($list_num == 1) {
            $path_this_name=get_path_this($zip_list[0]['path']);
        }else{
            $path_this_name=get_path_this(get_path_father($zip_list[0]['path']));
        }
        $zipname = $zip_path.$path_this_name.'.zip';
        $zipname = get_filename_auto($zipname,date(' h.i.s'));
        $files = array();
        for ($i=0; $i < $list_num; $i++) {
            $files[] = $zip_list[$i]['path'];
        }
        $remove_path_pre = get_path_father($zip_list[0]['path']);
        $archive = new PclZip($zipname);
        $v_list = $archive->create(implode(',',$files),PCLZIP_OPT_REMOVE_PATH,$remove_path_pre);
        return iconv_app($zipname);
    }

    // Get file data
    public function fileGet(){
        $name = $this->_clear($this->in['filename']);
        $filename= $this->share_path.$name;
        if (filesize($filename) >= 1024*1024*20) show_json($this->L['edit_too_big'],false);

        $filecontents=file_get_contents($filename);//document content
        $charset=$this->_get_charset($filecontents);
        if ($charset!='' || $charset!='utf-8') {
            $filecontents=mb_convert_encoding($filecontents,'utf-8',$charset);
        }
        $data = array(
            'ext'       => get_path_ext($name),
            'name'      => iconv_app($name),
            'filename'  => $name,
            'charset'   => $charset,
            'content'   => $filecontents            
        );
        show_json($data);
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

    public function image(){
        if (filesize($this->path) <= 1024*10) {//Less than 10k longer to generate thumbnails
            file_put_out($this->path);
        }
        load_class('imageThumb');
        $image= $this->path;
        $image_thum = DATA_THUMB.md5($image).'.png';
        if (!is_dir(DATA_THUMB)){
            mkdir(DATA_THUMB,"0777");
        }
        if (!file_exists($image_thum)){//If assembled into the url does not exist, it does not generate too
            if ($_SESSION['this_path']==DATA_THUMB){//Thumbnails will not be generated in the current directory
                $image_thum=$this->path;
            }else {
                $cm=new CreatMiniature();
                $cm->SetVar($image,'file');
                //$cm->Prorate($image_thum,72,64);//Thumbnail generation ratio
                $cm->BackFill($image_thum,72,64,true);//Proportional thumbnails, fill the space filled with a transparent color
            }
        }
        if (!file_exists($image_thum) || filesize($image_thum)<100){//Thumbnail generation fails with the default icon
            $image_thum=STATIC_PATH.'images/image.png';
        }
        file_put_out($image_thum);
    }

    //Get a list of files & oh exe file parsing json
    private function path($dir,$list_file=true,$check_children=false){
        $list = path_list($dir,$list_file,$check_children);
        
        $file_parem = array('filelist'=>array(),'folderlist'=>array());
        $path_hidden = $this->config['setting_system']['path_hidden'];
        $ex_name = explode(',',$path_hidden);
        foreach ($list['filelist'] as $key => $val) {
            if (in_array($val['name'],$ex_name)) continue;
            if ($val['ext'] == 'oexe'){
                $path = iconv_system($val['path']).'/'.iconv_system($val['name']);
                $json = json_decode(file_get_contents($path),true);
                if(is_array($json)) $val = array_merge($val,$json);
            }
            $file_parem['filelist'][] = $val;
        }
        foreach ($list['folderlist'] as $key => $val) {
            if (in_array($val['name'],$ex_name)) continue;
            $file_parem['folderlist'][] = $val;
        }
        _DIR_OUT($file_parem);
        return $file_parem;
    }
}