<?php
include "konexioa.php";
require 'session.php';
$userId = $_SESSION['user_id'];

// Obtener datos del usuario logueado
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Inicializar variables de error
$textuaIzena = $textuaAbizena = $textuaEmaila = $textuaPasahitza = $textuaNan = $textuaInstalazioa = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $izena = trim($_POST['bezeroaIzena']);
    $abizena = trim($_POST['bezeroaAbizena']);
    $email = trim($_POST['bezeroaEmail']);
    $pasahitza = trim($_POST['bezeroaPasahitza']);
    $nan = trim($_POST['bezeroaNan']);
    $instalazioa_id = $_POST['bezeroaInstalazioa'];

    $instalazioa = "";
    if ($instalazioa_id != "") {
        $instalazioa_query = "SELECT izena FROM instalazioa WHERE id = '$instalazioa_id'";
        $instalazioa_result = $conn->query($instalazioa_query);
        if ($instalazioa_result && $instalazioa_result->num_rows > 0) {
            $instalazioa_row = $instalazioa_result->fetch_assoc();
            $instalazioa = $instalazioa_row['izena'];
        }
    }

    // Validación
    $errores = [];
    if (empty($izena)) {
        $textuaIzena = "'Izena' jarri behar duzu.";
        $errores[] = $textuaIzena;
    }
    if (empty($abizena)) {
        $textuaAbizena = "'Abizena' jarri behar duzu.";
        $errores[] = $textuaAbizena;
    }
    if (empty($email)) {
        $textuaEmaila = "'Emaila' jarri behar duzu.";
        $errores[] = $textuaEmaila;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $textuaEmaila = "'Emaila' ez da zuzena.";
        $errores[] = $textuaEmaila;
    }
    if (empty($pasahitza)) {
        $textuaPasahitza = "'Pasahitza' jarri behar duzu.";
        $errores[] = $textuaPasahitza;
    }
    if (empty($nan)) {
        $textuaNan = "'Nan-a' jarri behar duzu.";
        $errores[] = $textuaNan;
    } elseif (!preg_match('/^[0-9]{8}[A-Za-z]$/', $nan)) {
        $textuaNan = "'Nan-ak' 9 karaktere izan behar ditu.";
        $errores[] = $textuaNan;
    }
    if (empty($instalazioa_id)) {
        $textuaInstalazioa = "'Instalazioa' aukeratu behar duzu.";
        $errores[] = $textuaInstalazioa;
    }

    // Insertar si no hay errores
    if (count($errores) === 0) {
        $stmt = $conn->prepare("INSERT INTO bezeroa (izena, abizena, email, pasahitza, nan, instalazioa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $izena, $abizena, $email, $pasahitza, $nan, $instalazioa);
        if ($stmt->execute()) {
            header("Location: bezeroa.php");
            exit;
        } else {
            echo '<div class="alert alert-danger mt-3">Errorea: ' . $stmt->error . '</div>';
        }
    }
}

// Obtener instalaciones
$instalazioak_sql = "SELECT * FROM instalazioa";
$instalazioak_result = $conn->query($instalazioak_sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BEZEROA GEHITU</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/taulak.css">
<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="css/btn.css">
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
            <li class="nav-item"><a class="nav-link active" href="bezeroa.php">Bezeroak</a></li>
            <li class="nav-item"><a class="nav-link" href="instalazioak.php">Instalazioak</a></li>
        </ul>
        <a href="perfila.php" style="text-decoration: none;">
            <span class="navbar-text text-white me-3"><?= ($user['izena']) . ' ' . ($user['abizena']) ?></span>
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
    </div>
</nav>

<div class="container mt-4">
<h1>Bezeroa Gehitu</h1>
<form action="" method="post" class="needs-validation" novalidate>

    <label for="bezeroaIzena" class="form-label">IZENA <span style="color:red">*</span></label>
    <input type="text" class="form-control" id="bezeroaIzena" name="bezeroaIzena" value="<?= isset($izena) ? ($izena) : '' ?>" required>
    <p class="text-danger"><?= $textuaIzena ?></p>

    <label for="bezeroaAbizena" class="form-label">ABIZENA <span style="color:red">*</span></label>
    <input type="text" class="form-control" id="bezeroaAbizena" name="bezeroaAbizena" value="<?= isset($abizena) ? ($abizena) : '' ?>" required>
    <p class="text-danger"><?= $textuaAbizena ?></p>

    <label for="bezeroaEmail" class="form-label">EMAIL-A <span style="color:red">*</span></label>
    <input type="email" class="form-control" id="bezeroaEmail" name="bezeroaEmail" value="<?= isset($email) ? ($email) : '' ?>" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
    <p class="text-danger"><?= $textuaEmaila ?></p>

    <label for="bezeroaPasahitza" class="form-label">PASAHITZA <span style="color:red">*</span></label>
    <input type="password" class="form-control" id="bezeroaPasahitza" name="bezeroaPasahitza" value="<?= isset($pasahitza) ? ($pasahitza) : '' ?>" required>
    <p class="text-danger"><?= $textuaPasahitza ?></p>

    <label for="bezeroaNan" class="form-label">NAN-A <span style="color:red">*</span></label>
    <input type="text" class="form-control" id="bezeroaNan" name="bezeroaNan" placeholder="Adb: 12345678A" value="<?= isset($nan) ? ($nan) : '' ?>" required pattern="^[0-9]{8}[A-Za-z]$">
    <p class="text-danger"><?= $textuaNan ?></p>

    <label for="bezeroaInstalazioa" class="form-label">INSTALAZIOAREN IZENA <span style="color:red">*</span></label>
    <select class="form-select" id="bezeroaInstalazioa" name="bezeroaInstalazioa" required>
        <option value="">Aukeratu instalazioa</option>
        <?php
        if ($instalazioak_result && $instalazioak_result->num_rows > 0) {
            foreach ($instalazioak_result as $instalazioa) {
                $selected = (isset($instalazioa_id) && $instalazioa_id == $instalazioa['id']) ? 'selected' : '';
                echo "<option value='" . $instalazioa['id'] . "' $selected>" . $instalazioa['izena'] . "</option>";
            }
        }
        ?>
    </select>
    <p class="text-danger"><?= $textuaInstalazioa ?></p>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary w-100">GEHITU</button>
    </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
