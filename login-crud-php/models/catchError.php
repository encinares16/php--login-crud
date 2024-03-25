<?php 
    class catchError {
        private $errorMessage;
        private $successMessage;

        // Error Setter
        function set_error($errorMessage) {
            $this->errorMessage = $errorMessage;
        }

        function set_sucessMessage($successMessage) {
            $this->successMessage = $successMessage;
        }

        // Error Getter
        function get_error() {
            return $this->errorMessage;
        }

        function get_successMessage() {
            return $this->successMessage;
        }
    
    }
?>