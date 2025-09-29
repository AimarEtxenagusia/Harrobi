<?php
require 'konexioa.php';
require 'session.php';
require 'model/bezeroak.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$bezeroak = Bezeroak::ikusiBezeroak($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bezeroak</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Gris clarito de fondo */
        }

        h1 {
            font-weight: 700;
        }

        .table td img {
            vertical-align: middle;
        }

        .card-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-sm img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="bezeroa.php"><img src="img/harrobi2.png" alt="Logo" class="logo"
                style="height: 85px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="langilea.php">Langileak</a></li>
                <li class="nav-item"><a class="nav-link active" href="bezeroa.php">Bezeroak</a></li>
                <li class="nav-item"><a class="nav-link" href="instalazioak.php">Instalazioak</a></li>
            </ul>
            <a href="perfila.php" style="text-decoration: none;">
                <span class="navbar-text text-white me-3">
                    <?= $user['izena'] . ' ' . $user['abizena'] ?>
                </span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm float-end">Saioa Itxi</a>
        </div>
    </nav>

    <div class="container mt-5 card-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Bezeroak</h1>
            <a href="bezeroaGehitu.php" class="btn btn-success btn-md">Gehitu Bezeroa</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover rounded-3 shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Izena</th>
                        <th>Abizena</th>
                        <th>Email-a</th>
                        <th>Pasahitza</th>
                        <th>NAN</th>
                        <th>Instalazioa</th>
                        <th>Aldatu</th>
                        <th>Ezabatu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   

                    foreach ($bezeroak as $bezero) {
                        echo "<tr>";
                        echo "<td>" . $bezero->getIzena() . "</td>";
                        echo "<td>" . $bezero->getAbizena() . "</td>";
                        echo "<td>" . $bezero->getEmail() . "</td>";
                        echo "<td>" . $bezero->getPasahitza() . "</td>";
                        echo "<td>" . $bezero->getNan() . "</td>";
                        echo "<td>" . $bezero->getInstalazioa() . "</td>";
                        echo '<td><a href="bezeroaAldatu.php?id=' . $bezero->getId() . '" class="btn btn-warning btn-sm">
                                    <img src="img/aldatu.png" alt="Aldatu"></a></td>';
                        echo '<td><a href="bezeroaEzabatu.php?id=' . $bezero->getId() . '" class="btn btn-danger btn-sm">
                                    <img src="img/ezabatu.png" alt="Ezabatu"></a></td>';
                        echo "</tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>