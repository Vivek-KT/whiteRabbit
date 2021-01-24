<?php

 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "interviewtest";
 
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
  global $conn;        
         if(! $conn ) {
            die('Could not connect: ' . mysql_error());
         }
         
mysqli_select_db($conn, $db);
   
?>