<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class ForRegistry {

    var $_entries;
    var $_locks;
    var $_dirname;

    function __construct($dirname = '') {
        $this->_dirname = $dirname;
        $this->_entries = array();
        $this->_locks = array();
    }

    function &getInstance() {
        static $instance = false;
        if (!$instance) {
            $instance = new ForRegistry();
        }
        return $instance;
    }

    function setEntry($key, $item) {
        if ($this->isLocked($key) == true) {
            trigger_error('Unable to set entry `' . $key . '`. Entry is locked.', E_USER_WARNING);
            return false;
        }

        $this->_entries[$this->_dirname][$key] = $item;
        return true;
    }

    function unsetEntry($key) {
        unset($this->_entries[$key]);
    }

    function getEntry($key) {
        if (isset($this->_entries[$this->_dirname][$key]) == false) {
            return null;
        }

        return $this->_entries[$this->_dirname][$key];
    }

    function isEntry($key) {
        return ($this->getEntry($key) !== null);
    }

    function lockEntry($key) {
        $this->_locks[$this->_dirname][$key] = true;
        return true;
    }

    function unlockEntry($key) {
        unset($this->_locks[$this->_dirname][$key]);
    }

    function isLocked($key) {
        return (isset($this->_locks[$this->_dirname][$key]) == true);
    }

    function unsetAll() {
        $this->_entries = array();
        $this->_locks = array();
    }
}

?>
