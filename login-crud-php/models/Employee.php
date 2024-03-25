<?php 
    class Employee {
        private $fullname;
        private $address;
        private $birthdate;
        private $age;
        private $gender;
        private $status;
        private $contact;
        private $salary;
        private $isActive;
    
        // Employee Setter
        function set_fullname($fullname) {
            $this->fullname = $fullname;
        }

        function set_address($address) {
            $this->address = $address;
        }
        
        function set_birthdate($birthdate) {
            $this->birthdate = $birthdate;
        }

        function set_age($age) {
            $this->age = $age;
        }

        function set_gender($gender) {
            $this->gender = $gender;
        }

        function set_status($status) {
            $this->status = $status;
        }

        function set_contact($contact) {
            $this->contact = $contact;
        }

        function set_salary($salary) {
            $this->salary = $salary;
        }

        function set_isActive($isActive) {
            $this->isActive = $isActive;
        }



        // Employee Getter
        function get_fullname() {
            return $this->fullname;
        }
    
        function get_address() {
            return $this->address;
        }
    
        function get_birthdate() {
            return $this->birthdate;
        }
        
        function get_age() {
            return $this->age;
        }

        function get_gender() {
            return $this->gender;
        }

        function get_status() {
            return $this->status;
        }

        function get_contact() {
            return $this->contact;
        }

        function get_salary() {
            return $this->salary;
        }

        function get_isActive() {
            return $this->isActive;
        }
    }
?>