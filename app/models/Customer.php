<?php
    class Customer extends Model{
        protected $customer_id, $first_name, $last_name;
        protected $_loggedIn, $_sessionName, $_cookieName;
        public static $currentLoggedInUser = null;

        public function __construct(/*$table*/){
            //$table = 'customers';
            parent::__construct(/*$table*/);
            //$this->_sessionName = CURRENT_USER_SESSION_NAME;
            //$this->cookieName = REMEMBER_ME_COOKIE_NAME;          
        }

        public function set_table_name($table){
            parent::set_table_name($table);
        }

        public function insert($fields){
            return parent::insert($fields);
        }

        public function get_last_insert_id(){
            parent:: get_last_insert_id();
        }
    }