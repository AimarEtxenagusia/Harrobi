<?php

require 'konexioa.php'

    ?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
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
    <h1>INSTALAZIOAK</h1>
    <table>
        <tr>
            <th>IZENA</th>
        </tr>
        <?php
        $sql = "SELECT * FROM instalazioa";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["izena"] . "</td>";
                echo '<td id="aldatu"><a href="instalazioaAldatu.php?id=' . $row['id'] . '"><img src="img/aldatu.png" alt="Aldatu"></a></td>';
                echo '<td id="ezabatu"><a href="instalazioaEzabatu.php?id=' . $row['id'] . '"><img src="img/ezabatu.png" alt="Ezabatu"></a></td>';
                echo "</tr>";

            }
        }
        ?>
    </table>

    <a href="gehituInstalazioa.php"><button id="btn" type="submit">GEHITU INSTALAZIOA</button></a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>