<?php
    class Users extends Model{
        private $_loggedIn,$_sessionName, $_cookieName;
        public static $currentLoggedInUser =null;

        public function __construct($user=''){
            $table = 'users';
            parent::__construct($table);
            $this->_sessionName = CURRENT_USER_SESSION_NAME;
            $this->cookieName = REMEMBER_ME_COOKIE_NAME;
            $this->softDelete = true;
            if($user!=''){
                $u =$this->$_db->find
            }
        }
    }