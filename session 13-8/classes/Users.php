<?php

    class Users{
        //public -> anywhere
        //private -> only in the class
        //protected - > inherited classes can access
        public $username;
        public $mail;

        public function __construct($username, $mail) {
            $this->username = $username;
            $this->mail = $mail;
        }
        public function getUsername()
        {
            return $this->username;
        }
        public function getMail()
        {
            return $this->mail;
        }
    }
?>