<?php
include "konexioa.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $izena = $_POST['bezeroaIzena'];
        $abizena = $_POST['bezeroaAbizena'];
        $email = $_POST['bezeroaEmail'];
        $pasahitza = $_POST['bezeroaPasahitza'];
        $nan = $_POST['bezeroaNan'];
        $instalazioa = $_POST['bezeroaInstalazioa'];

        if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $nan)) {
            echo "<span style='color:red'>NAN formatu okerra! Idatzi 8 zenbaki eta letra bat (adibidez: 12345678F)</span>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<span style='color:red'>Email formatu okerra! Idatzi email zuzena (adibidez: iker@gmail.com)</span>";
        } else {
            $sql = "INSERT INTO bezeroa (izena, abizena, email, pasahitza, nan, instalazioa) VALUES ('$izena', '$abizena', '$email', '$pasahitza','$nan', '$instalazioa')";
            if (mysqli_query($conn, $sql)) {
                echo "bezeroa ondo gehitu da!";
            } else {
                echo "Errorea: " . mysqli_error($conn);
            }
        }
    }else {
        // Instalazioak lortzeko SQL kontsulta
        $instalazioak_sql = "SELECT * FROM instalazioa";
        $instalazioak_result = $conn->query($instalazioak_sql);
    }
    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEZEROA GEHITU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr8z2mbx5l1Z9gqG1skCkP0r5hXQ6tZTt3M1QF0k0" crossorigin="anonymous">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/btn.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <nav class="navbar">
            <img src="img/harrobi.png" alt="Logo" class="logo">
            <ul>
                <li><a href="index.php">Bezeroak</a></li>
                <li><a href="instalazioak.php">Instalazioak</a></li>
            </ul>
        </nav>


    </nav>
    <h1>Bezeroa Gehitu</h1>
    <form action="" method="post">
        <label for="name">IZENA</label>
        <input type="text" name="bezeroaIzena" value="" required>
        <label for="name">ABIZENA</label>
        <input type="text" name="bezeroaAbizena" value="" required>
        <label for="name">EMAIL-A</label>
        <input type="email" name="bezeroaEmail" value="" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Idatzi email formatu zuzena (adibidez: uni@uni.eus)">
        <label for="name">PASAHITZA</label>
        <input type="password" name="bezeroaPasahitza" value="" required>
        <label for="name">NAN-A</label>
        <input type="text" name="bezeroaNan" value="" required>
        <label for="name">INSTALAZIOAREN IZENA</label>
        <select id="aukera" name="bezeroaInstalazioa" required>
            <?php
            while ($instalazioa = $instalazioak_result->fetch_assoc()) {
                echo "<option value='" . $instalazioa['id'] . "'>" . $instalazioa['izena'] . "</option>";
            }
            ?>
        </select>
        <br>
        <br>
        <button type="submit" id="gehitu">GEHITU</button>
        <br>
        <br>
        <button class="btn-cancel" href="index.php">ITZULI</a>
    </form>

 
</body>

</html>