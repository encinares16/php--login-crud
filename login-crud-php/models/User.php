<?php 
    class User {
        private $username;
        private $name;
        private $email;
        private $password;
        private $confirm_password;

        // Setter
        function set_username($username) {
            $this->username = $username;
        }

        function set_name($name) {
            $this->name = $name;
        }

        function set_email($email) {
            $this->email = $email;
        }

        function set_password($password) {
            $this->password = $password;
        }

        function set_confirmPassword($confirm_password) {
            $this->confirm_password = $confirm_password;
        }
        

        // Getter
        function get_username() {
            return $this->username;
        }

        function get_name() { 
            return $this->name; 
        }
        
        function get_email() { 
            return $this->email; 
        }
        
        function get_password() { 
            return $this->password; 
        }

        function get_confirmPassword() { 
            return $this->confirm_password; 
        }
    }
?>