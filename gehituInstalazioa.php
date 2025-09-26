<?php

require "konexioa.php";

require 'session.php';
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="bezeroa.php"><img src="img/harrobi2.png" alt="Logo" class="logo"
                style="height: 85px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="langilea.php">Langileak</a></li>
                <li class="nav-item"><a class="nav-link" href="bezeroa.php">Bezeroak</a></li>
                <li class="nav-item"><a class="nav-link active" href="instalazioak.php">Instalazioak</a></li>
            </ul>
            <a href="perfila.php" style="text-decoration: none;">
                <span class="navbar-text text-white me-3">
                    <?= htmlspecialchars($user['izena']) . ' ' . htmlspecialchars($user['abizena']) ?>
                </span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
        </div>
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['instalazioIzena'])) {
        echo "Sartu izen bat!";
    } else {
        $izenaInstalazioa = $_POST['instalazioIzena'];

        $stmt = $conn->prepare("INSERT INTO instalazioa (izena) VALUES (?)");
        $stmt->bind_param("s", $izenaInstalazioa);

        if ($stmt->execute()) {
            header("Location: instalazioak.php");
        } else {
            echo "Errorea: " . $stmt->error;
        }
    }
}



?>

</html>