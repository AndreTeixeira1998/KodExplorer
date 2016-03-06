<?php
/*
 * @link http://www.kalcaddle.com/
 * @author warlee | e-mail:kalcaddle@qq.com
 * @copyright warlee 2014.(Shanghai)Co.,Ltd
 * @license http://kalcaddle.com/tools/licenses/license.txt
 * @Security : Ben Khlifa Fahmi - Tunisian Whitehats Security / https://www.benkhlifa.com/
 */

class member extends Controller
{
    private $sql;
    function __construct()
    {
        parent::__construct();
        $this->tpl = TEMPLATE . 'member/';
        $this->sql = new fileCache(USER_SYSTEM . 'member.php');
    }
    
    /**
     * Get a list of user data
     */
    public function get()
    {
        show_json($this->sql->get());
    }
    /**
     * Adding users
     */
    public function add()
    {
        if (!$this->in['name'] || !$this->in['password'] || !$this->in['role'])
            show_json($this->L["data_not_full"], false);
        if ($_SERVER['HTTP_REFERER'] != $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                $this->in['name']     = rawurldecode($this->in['name']);
                $this->in['password'] = rawurldecode($this->in['password']);
                $user                 = array(
                    'name' => rawurldecode($this->in['name']),
                    'password' => md5(rawurldecode($this->in['password'])),
                    'role' => $this->in['role'],
                    'status' => 0
                );
                if ($this->sql->add($this->in['name'], $user)) {
                    $this->_initUser($this->in['name']);
                    show_json($referer);
                }
                show_json($this->L['error_repeat'], false);
            }
        } else {
            header('Location: 403.php');
        }
    }
    
    /**
     * Edit
     */
    public function edit()
    {
        if (!$this->in['name'] || !$this->in['name_to'] || !$this->in['role_to'])
            show_json($this->L["data_not_full"], false);
        if ($_SERVER['HTTP_REFERER'] != $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                
                $this->in['name']        = rawurldecode($this->in['name']);
                $this->in['name_to']     = rawurldecode($this->in['name_to']);
                $this->in['password_to'] = rawurldecode($this->in['password_to']);
                if ($this->in['name'] == 'admin')
                    show_json($this->L['default_user_can_not_do'], false);
                
                //Find a record, modified to the array
                $user         = $this->sql->get($this->in['name']);
                $user['name'] = $this->in['name_to'];
                $user['role'] = $this->in['role_to'];
                
                if (strlen($this->in['password_to']) >= 1) {
                    $user['password'] = md5($this->in['password_to']);
                }
                if ($this->sql->replace_update($this->in['name'], $user['name'], $user)) {
                    rename(USER_PATH . $this->in['name'], USER_PATH . $this->in['name_to']);
                    show_json($this->L['success']);
                }
                show_json($this->L['error_repeat'], false);
            }
        } else {
            header('Location: 403.php');
        }
    }
    
    /**
     * Delete
     */
    public function del()
    {
        $name = $this->in['name'];
        if (!$name)
            show_json($this->L["username_can_not_null"], false);
        if ($name == 'admin')
            show_json($this->L['default_user_can_not_do'], false);
        if ($_SERVER['HTTP_REFERER'] != $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                
                if ($this->sql->delete($name)) {
                    del_dir(USER_PATH . $name . '/');
                    show_json($this->L['success']);
                }
                show_json($this->L['error'], false);
            }
        } else {
            header('Location: 403.html');
        }
    }
    
    //============Internal handler=============
    /**
     *User data initialization and configuration.
     */
    public function _initUser($name)
    {
        $root            = array(
            'home',
            'recycle',
            'data'
        );
        $new_user_folder = $this->config['setting_system']['new_user_folder'];
        $home            = explode(',', $new_user_folder);
        
        $user_path = USER_PATH . $name . '/';
        mk_dir($user_path);
        foreach ($root as $dir) {
            mk_dir($user_path . $dir);
        }
        foreach ($home as $dir) {
            mk_dir($user_path . 'home/' . $dir);
        }
        fileCache::save($user_path . 'data/config.php', $this->config['setting_default']);
    }
}
