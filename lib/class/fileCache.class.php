<?php
/*
* @link http://www.kalcaddle.com/
* @author warlee | e-mail:kalcaddle@qq.com
* @copyright warlee 2014.(Shanghai)Co.,Ltd
* @license http://kalcaddle.com/tools/licenses/license.txt
*/


/**
* Cache storage class data; key => value mode; value can be any type of data.
* The full flow test; minimum read 5000 times / s write containing 1000 / s
* Add to add a single data; it exists, false
* Reset Reset all data; the data does not pass parameter represents Empty
* Get: access to data; catchall; Get the specified key data; a plurality of key for the specified data; find ways to obtain a plurality of data
* 1. get ();
* 2. get ( "demo")
* 3. get (array ( 'demo', 'admin'))
* 4. get ( 'group', '', 'root')
* Update: update data; updates the specified key data; a plurality of key for the specified data; find ways to update multiple data
* 1. update ( "demo", array ( 'name' => 'ddd', ...))
* 2. update (array ( 'demo', 'admin'), array (array ( 'name' ...), array ( 'name' ...)))
* 3. update ( 'group', 'system', 'root')
*
* Replace_update ($ key_old, $ key_new, $ value_new) alternative update; meet key needs updating
*
* Delete: access to data; catchall; Get the specified key data; a plurality of key for the specified data; find ways to obtain a plurality of data
* 1. delete ( "demo")
* 2. delete (array ( 'demo', 'admin'))
* 3. delete ( 'group', '', 'root')
* For example: ====================================
* [ 'Sss': [ 'name': 'sss', 'group': 'root'], 'bbb': [ 'name': 'bbb', 'group': 'root']
*, 'Ccc': [ 'name': 'ccc', 'group': 'system'], 'ddd': [ 'name': 'ddd', 'group': 'root']
* Find ways to delete delete ( 'group', '', 'root');
* Find ways to update update ( 'group', 'system', 'root');
* Find a way to get get ( 'group', '', 'root');
*/
define('CONFIG_EXIT', '<?php exit;?>');
class fileCache
{
    private $data;
    private $file;
    function __construct($file) {
        $this->file = $file;
        $this->data= self::load($file);
    }
    
    /**
    * Reset all data; the data does not pass parameter represents Empty
    */
    public function reset($list=array()){
        $this->data = $list;
        self::save($this->file,$this->data);
    }

    /**
    * Add a data, can not be repeated; if it exists return false; 1k times / s
    */
    public function add($k,$v){
        if (!isset($this->data[$k])) {
            $this->data[$k] = $v;
            self::save($this->file,$this->data);
            return true;
        }
        return false;
    }

    /**
* Get data; there is no return false; 100w times / s
     * $ K null is returned does not pass all;
     * $ K string is a string; then get data according to key, only one data
     * $ Search_value when set; representation to find a way to filter data filter condition $ key = $ k $ search_value value data; a plurality of    */
    public function get($k = '',$v='',$search_value=false){
        if ($k === '') return $this->data;
        
        $search = array();
        if ($search_value === false) {
            if (is_array($k)) {
                //A plurality of data acquisition
                $num = count($k);
                for ($i=0; $i < $num; $i++) {
                    $search[$k[$i]] = $this->data[$k[$i]];
                }
                return $search;
            }else if(isset($this->data[$k])){
                //A single data acquisition
                return $this->data[$k];
            }
        }else{
            //Find a way to get a single content data; a plurality of return
            foreach ($this->data as $key => $val) {
                if ($val[$k] == $search_value) {
                    $search[$key] = $this->data[$key];
                }
            }
            return $search;
        }
        return false;
    }

    /**
* Update data; absence; or any one does not exist return false; not be saved
     * $ K $ v string is a string; then update the data based on only one key
     * $ K $ v array array ($ key1, $ key2, ...), array ($ value1, $ value2, ...)
     * Indicates a plurality of data update
     * $ Search_value set; represents the data to find ways to update data
    */
    public function update($k,$v,$search_value=false){
        if ($search_value === false) {
            if (is_array($k)) {
                //A plurality of data update
                $num = count($k);
                for ($i=0; $i < $num; $i++) { 
                    $this->data[$k[$i]] = $v[$i];
                }
                self::save($this->file,$this->data);
                return true;
            }else if(isset($this->data[$k])){
                //A single data update
                $this->data[$k] = $v;
                self::save($this->file,$this->data);
                return true;
            }
        }else{
            //Find a way to update; update multiple
            foreach ($this->data as $key => $val) {
                if ($val[$k] == $search_value) {
                    $this->data[$key][$k] = $v;
                }
            }
            self::save($this->file,$this->data);
            return true;
        }
        return false;
    }

    /*
    * Update alternatives; meet key needs updating
    */
    public function replace_update($key_old,$key_new,$value_new){
        if(isset($this->data[$key_old])){
            $value = $this->data[$key_old];
            unset($this->data[$key_old]);
            $this->data[$key_new] = $value_new;
            self::save($this->file,$this->data);
            return true;
        }
        return false;
    }
    
    /**
    * Delete; return false does not exist
    */
    public function delete($k,$v='',$search_value=false){
        if ($search_value === false) {
            if (is_array($k)) {
                //A plurality of data update
                $num = count($k);
                for ($i=0; $i < $num; $i++) { 
                    unset($this->data[$k[$i]]);
                }
                self::save($this->file,$this->data);
                return true;
            }else if(isset($this->data[$k])){
                //Single data deletion
                unset($this->data[$k]);
                self::save($this->file,$this->data);
                return true;
            }
        }else{
            //Find a way to delete the contents of the data; delete multiple
            foreach ($this->data as $key => $val) {
                if ($val[$k] == $search_value){
                    unset($this->data[$key]);
                }
            }
            self::save($this->file,$this->data);
            return true;
        }
        return false;
    }

    

    //=====================================================
    /**
    * Sequence
    */
    public static function arr_sort(&$arr,$key, $type = 'asc'){
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$key];
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
    * Load data; and parse the data into the program
    */
    public static function load($file){//10,000 times the amount of data required 4s little difference.
        if (!file_exists($file)) touch($file);
        $str = file_get_contents($file);
        $str = substr($str, strlen(CONFIG_EXIT));
        $data= json_decode($str,true);
        if (is_null($data)) $data = array();
        return $data;
    }
    /**
    * save data;
    */
    public static function save($file,$data){//10000 need 6s 
        if (!$file) return;
        if (file_exists($file) && !is_writable($file)) {
            show_json('the path "data/" can not write!',false);
        }
        if($fp = fopen($file, "w")){
            if (flock($fp, LOCK_EX)) {  // Perform exclusive locking type
                $str = CONFIG_EXIT.json_encode($data);
                fwrite($fp, $str);
                fflush($fp);            // flush output before releasing the lock
                flock($fp, LOCK_UN);    // Release the lock
            }
            fclose($fp);            
        }
    }
}