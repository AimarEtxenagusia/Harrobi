<?php
require "konexioa.php";
require 'session.php';

$userId = $_SESSION['user_id'];

// Obtener datos del usuario logueado
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Inicializar mensaje de error
$textuaInstalazioa = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izenaInstalazioa = trim($_POST['instalazioIzena']);

    if (empty($izenaInstalazioa)) {
        $textuaInstalazioa = "Sartu izen bat!";
    } else {
        $stmt = $conn->prepare("UPDATE instalazioa SET izena = ? WHERE id = ?");
        $stmt->bind_param("si", $izenaInstalazioa, $id);

        if ($stmt->execute()) {
            header("Location: instalazioak.php");
            exit;
        } else {
            $textuaInstalazioa = "Errorea: " . $stmt->error;
        }
    }
} else {
    $id = $_GET['id'];

    $sql = "SELECT izena FROM instalazioa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        die("Ez da instalaziorik aurkitu");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>INSTALAZIOA ALDATU</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/taulak.css">
<link rel="stylesheet" href="css/form.css">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="bezeroa.php"><img src="img/harrobi2.png" alt="Logo" class="logo" style="height: 85px;"></a>
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
            <span class="navbar-text text-white me-3"><?= ($user['izena']) . ' ' . ($user['abizena']) ?></span>
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
    </div>
</nav>

<div class="container mt-4">
    <h1>INSTALAZIOA ALDATU</h1>
    <form action="" method="post" class="needs-validation" novalidate>
        <label for="instalazioIzena" class="form-label">INSTALAZIOAREN IZENA <span style="color:red">*</span></label>
        <input type="text" class="form-control" id="instalazioIzena" name="instalazioIzena"
               value="<?= isset($izenaInstalazioa) ? ($izenaInstalazioa) : ($row['izena']) ?>" required>
        <p class="text-danger"><?= $textuaInstalazioa ?></p>

        <input type="hidden" name="id" value="<?= $id; ?>">

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary w-100">ALDATU</button>
            <a class="btn btn-secondary w-100" href="instalazioak.php">ITZULI</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
