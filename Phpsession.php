<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Phpsession {
var $_flash = array();

    // constructor
    function __construct() {
        session_start();
        $this->flashinit();
    }

    /* Save a session variable.
     * @paramstringName of variable to save
     * @parammixedValue to save
     * @paramstring  (optional) Namespace to use. Defaults to 'default'. 'flash' is reserved.
    */
    function save($var, $val, $namespace = 'default') {
        if ($var == null) {
            $_SESSION[$namespace] = $val;
        } else {
            $_SESSION[$namespace][$var] = $val;
        }
    }
		
		function set($var, $val, $namespace = 'default') {
        if ($var == null) {
            $_SESSION[$namespace] = $val;
        } else {
            $_SESSION[$namespace][$var] = $val;
        }
    }

    /* Get the value of a session variabe
     * @paramstring  Name of variable to load. null loads all variables in namespace (associative array)
     * @paramstring(optional) Namespace to use, defaults to 'default'
    */
    function get($var = null, $namespace = 'default') {
        if(isset($var))
            return isset($_SESSION[$namespace][$var]) ? $_SESSION[$namespace][$var] : null;
        else
            return isset($_SESSION[$namespace]) ? $_SESSION[$namespace] : null;
    }

    /* Clears all variables in a namespace
     */
    function clear($var = null, $namespace = 'default') {
        if(isset($var) && ($var !== null))
            unset($_SESSION[$namespace][$var]);
        else
            unset($_SESSION[$namespace]);
    }

    /* Initializes the flash variable routines
     */
    function flashinit() {
        $this->_flash = $this->get(null, 'flash');
        $this->clear(null, 'flash');
    }

    /* Saves a flash variable. These are only saved for one page load
     * @paramstringVariable name to save
     * @parammixedValue to save
     */
    function flashsave($var, $val) {
        $this->save($var, $val, 'flash');
    }

    /* Gets the value of a flash variable. These are only saved for one page load, so the variable must
     * have either been set or had flashkeep() called on the previous page load
     * @paramstringVariable name to get
     */
    function flashget($var) {
        if (isset($this->_flash[$var])) {
            return $this->_flash[$var];
        } else {
            return null;
        }
    }

    /* Keeps the value of a flash variable for another page load.
     * @paramstring(optional) Variable name to keep, or null to keep all. Defaults to keep all (null)
     */
    function flashkeep($var = null) {
        if ($var != null) {
            $this->flashsave($var, $this->flashget($var));
        } else {
            $this->save(null, $this->_flash, 'flash');
        }
    }
    public function set_userdata($data, $value = NULL)
    {
        if (is_array($data))
        {
            foreach ($data as $key => &$value)
            {
                $_SESSION[$key] = $value;
            }

            return;
        }

        $_SESSION[$data] = $value;
    }

    public function userdata($key = NULL)
    {
        if (isset($key))
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
        }
        elseif (empty($_SESSION))
        {
            return array();
        }

        $userdata = array();
        $_exclude = array_merge(
            array('__ci_vars'),
            $this->get_flash_keys(),
            $this->get_temp_keys()
        );

        foreach (array_keys($_SESSION) as $key)
        {
            if ( ! in_array($key, $_exclude, TRUE))
            {
                $userdata[$key] = $_SESSION[$key];
            }
        }

        return $userdata;
    }
    

}
?>