<?php
    class User implements \JsonSerializable {
        public $user_id;
        public $username;
        public $fullname;
        public $email;
        public $address;
        public $phone;
        public $card_number;
        public $imgPath;
        private $hpass;

        function __construct($user_id,$username,$fullname,$email,$address,$phone,$card_number,$hpass, $imgPath=null){
            $this->user_id = $user_id;
            $this->username = $username;
            $this->fullname = $fullname;
            $this->email = $email;
            $this->address = $address;
            $this->phone = $phone;
            $this->card_number = $card_number;
            $this->imgPath = $imgPath;
            $this->hpass = $hpass;
        }

        function jsonSerialize(){
            $vars = get_object_vars($this);
            unset($vars["hpass"]);
            return $vars;
        }

        public function getPassword(){
            return $this->hpass;
        }

        public function setPassword($password){
            return $this->hpass = $password;
        }
        
    }
?>