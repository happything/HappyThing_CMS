<?php
    class User {
        var $db = null; // PEAR::DB pointer
	var $failed = false; // failed login attempt
	var $date; // current date GMT
	var $id = 0; // the current user's id
        
        function User(&$db) {
            $this->db = $db;
            $this->date = $GLOBALS['date'];

            if ($_SESSION['logged']) {
                    $this->_checkSession();
            } elseif ( isset($_COOKIE['mtwebLogin']) ) {
                    $this->_checkRemembered($_COOKIE['mtwebLogin']);
            }
	}
        
        function _checkLogin($username, $password, $remember) {
            $username = $this->db->quote($username);
            $password = $this->db->quote(md5($password));

            $sql = "SELECT * FROM member WHERE " .
                    "username = $username AND " .
                    "password = $password";

            $result = $this->db->getRow($sql);

            if ( is_object($result) ) {
                    $this->_setSession($result, $remember);
                    return true;
            } else {
                    $this->failed = true;
                    $this->_logout();
                    return false;
            }
	}
        
        function _setSession(&$values, $remember, $init = true) {
           $this->id = $values->id;
           $_SESSION['uid'] = $this->id;
           $_SESSION['username'] = htmlspecialchars($values->username);
           $_SESSION['cookie'] = $values->cookie;
           $_SESSION['logged'] = true;

           if ($remember) {
              $this->updateCookie($values->cookie, true);
           }

           if ($init) {
              $session = $this->db->quote(session_id());
              $ip = $this->db->quote($_SERVER['REMOTE_ADDR']);

              $sql = "UPDATE member SET session = $session, ip = $ip WHERE " .
                 "id = $this->id";
              $this->db->query($sql);
           }
        }
        
        function updateCookie($cookie, $save) {
           $_SESSION['cookie'] = $cookie;
           if ($save) {
              $cookie = serialize(array($_SESSION['username'], $cookie) );
              set_cookie('mtwebLogin', $cookie, time() + 31104000, '/directory/');
           }
        }
        
        function _checkRemembered($cookie) {
            list($username, $cookie) = @unserialize($cookie);
            if (!$username or !$cookie) return;

            $username = $this->db->quote($username);
            $cookie = $this->db->quote($cookie);

            $sql = "SELECT * FROM member WHERE " .
                    "(username = $username) AND (cookie = $cookie)";

            $result = $this->db->getRow($sql);

            if (is_object($result) ) {
                    $this->_setSession($result, true);
            }
        }
        
        function _checkSession() {
            $username = $this->db->quote($_SESSION['username']);
            $cookie = $this->db->quote($_SESSION['cookie']);
            $session = $this->db->quote(session_id());
            $ip = $this->db->quote($_SERVER['REMOTE_ADDR']);

            $sql = "SELECT * FROM member WHERE " .
                    "(username = $username) AND (cookie = $cookie) AND " .
                    "(session = $session) AND (ip = $ip)";

            $result = $this->db->getRow($sql);

            if (is_object($result) ) {
                    $this->_setSession($result, false, false);
            } else {
                    $this->_logout();
            }
        }

    }
?>
