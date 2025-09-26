<?php
require 'konexioa.php';
require 'session.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalazioak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            font-weight: 700;
        }

        .card-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table td img {
            vertical-align: middle;
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
        <a class="navbar-brand" href="bezeroa.php"><img src="img/harrobi2.png" alt="Logo" class="logo" style="height:85px;"></a>
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
                    <?= $user['izena'] . ' ' . $user['abizena'] ?>
                </span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-5 card-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Instalazioak</h1>
            <a href="gehituInstalazioa.php" class="btn btn-success btn-md">Gehitu Instalazioa</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped rounded-3 shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Izena</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM instalazioa";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["izena"] . "</td>";
                            echo '<td><a href="instalazioaAldatu.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">
                                    <img src="img/aldatu.png" alt="Aldatu"></a></td>';
                            echo '<td><a href="instalazioaEzabatu.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">
                                    <img src="img/ezabatu.png" alt="Ezabatu"></a></td>';
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
