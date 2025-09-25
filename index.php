<?php

    require "konexioa.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $pasahitza = $_POST['pasahitza'];
        if(empty($email) || empty($pasahitza)){
            echo "Sartu datu guztiak.";
        }else{
            
        }
    }
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-XXXX" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <img src="img/harrobi.png" alt="">

    <form action="login.php" method="post">
        <label for="name" name="email">SARTU ZURE EMAIL-A</label>
        <input type="mail" name="email">
        <label for="name" name="pasahitza">SARTU ZURE PASAHITZA</label>
        <input type="password" name="pasahitza">
        <input type="submit" value="SAIOA HASI">
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YYYY" crossorigin="anonymous"></script>

</body>

</html>