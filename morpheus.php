<?php

    require_once 'connection.php';

    class Morpheus
    {   
        private $dbConnection;

        // This is your constructor
        public function __construct ()
        {
            $this->dbConnection = new DatabaseConnection();
        }

        // It's good practice to close your resources on destruct.
        function __destruct ()
        {
            
        }
        
    }

?>