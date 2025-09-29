<?php
require "konexioa.php";
require 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izena = $_POST['langileaIzena'];
    $abizena = $_POST['langileaAbizena'];
    $email = $_POST['langileaEmail'];
    $pasahitza = $_POST['langileaPasahitza'];
    $nan = $_POST['langileaNan'];

    $stmt = $conn->prepare("UPDATE langilea SET izena = ?, abizena = ?, email = ?, pasahitza = ?, nan = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $izena, $abizena, $email, $pasahitza, $nan, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Errorea: " . $stmt->error;
    }
} else {
    $id = $_SESSION['user_id'];

    $sql = "SELECT izena, abizena, email, pasahitza, nan FROM langilea WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        die("Ez da langilerik aurkitu");
    }

    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NIRE PERFILA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <li class="nav-item"><a class="nav-link" href="instalazioak.php">Instalazioak</a></li>
        </ul>
        <a href="perfila.php" style="text-decoration: none;">
            <span class="navbar-text text-white me-3"><?= $user['izena'] . ' ' . $user['abizena'] ?></span>
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Saioa Itxi</a>
    </div>
</nav>

<div class="container mt-4">
    <h1>NIRE PERFILA</h1>
    <form action="perfila.php" method="post">
        <div class="mb-3">
            <label for="langileaIzena" class="form-label">Izena</label>
            <input type="text" name="langileaIzena" id="langileaIzena" class="form-control" value="<?php echo $row['izena'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="langileaAbizena" class="form-label">Abizena</label>
            <input type="text" name="langileaAbizena" id="langileaAbizena" class="form-control" value="<?php echo $row['abizena'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="langileaEmail" class="form-label">Email-a</label>
            <input type="email" name="langileaEmail" id="langileaEmail" class="form-control" value="<?php echo $row['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="langileaPasahitza" class="form-label">Pasahitza</label>
            <input type="text" name="langileaPasahitza" id="langileaPasahitza" class="form-control" value="<?php echo $row['pasahitza'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="langileaNan" class="form-label">NAN-a</label>
            <input type="text" name="langileaNan" id="langileaNan" class="form-control" value="<?php echo $row['nan'] ?>" required>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">ALDATU</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
