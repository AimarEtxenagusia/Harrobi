<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "harrobi";

    //Konexioa egin

    $conn = new mysqli($servername,$username,$password,$dbname);
    

    if($conn->connect_error){
        die("Errorea konexioa gauzatzean".$conn->connect_error);

    }


?>