<?php 
        session_start() ;

     $servername = "localhost" ;
     $db_username = "root" ;
     $db_password = "" ; 
     $database_name = "teretana" ;

        $conn = mysqli_connect($servername, $db_username, $db_password, $database_name) ;


        if(!$conn){
            die ("Neuspesna konekcija") ;
        }
