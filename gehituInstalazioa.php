<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">

</head>

<body>
    <nav>
        <nav class="navbar">
            <img src="img/harrobi.png" alt="Logo" class="logo">
            <ul>
                <li><a href="bezeroa.php">Bezeroak</a></li>
                <li><a href="instalazioak.php">Instalazioak</a></li>
                <li><a href="index.php">Saioa Itxi</a></li>
            </ul>
        </nav>


    </nav>
    <h1>INSTALAZIO BERRIA</h1>
    <form action="gehituInstalazioa.php" method="post">

        <label for="name">INSTALAZIOAREN IZENA</label>
        <input type="text" name="instalazioIzena">

        <input type="submit" value="GEHITU">
        <a class="btn-cancel" href="instalazioak.php">ITZULI</a>
    </form>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

<?php

require "konexioa.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['instalazioIzena'])) {
        echo "Sartu izen bat!";
    } else {
        $izenaInstalazioa = $_POST['instalazioIzena'];

        $stmt = $conn->prepare("INSERT INTO instalazioa (izena) VALUES (?)");
        $stmt->bind_param("s", $izenaInstalazioa);

        if ($stmt->execute()) {
            echo "Instalazioa gehitu da!";
        } else {
            echo "Errorea: " . $stmt->error;
        }
    }
}



?>

</html>