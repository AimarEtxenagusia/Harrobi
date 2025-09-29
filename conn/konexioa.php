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
<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Konexioa</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
</head>
<body>
     <!-- Aquí puedes agregar contenido si lo deseas -->
</body>
</html>