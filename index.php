<?php
require "konexioa.php";
    
session_start();

$error_msg = ""; // Para guardar el mensaje de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pasahitza = $_POST['pasahitza'];

    if (empty($email) || empty($pasahitza)) {
        $error_msg = "Sartu datu guztiak";
    } else {
        $stmt = $conn->prepare("SELECT id, izena, abizena, email, pasahitza FROM langilea WHERE email = ? AND pasahitza = ?");
        $stmt->bind_param("ss", $email, $pasahitza);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user'] = $row['izena'];
            $_SESSION['user_abizena'] = $row['abizena'];
            header("Location: bezeroa.php");
            exit;
        } else {
            $error_msg = "Datuak ez dira zuzenak";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-3">
            <img src="img/harrobi.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
        </div>

        <?php if ($error_msg): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>

        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">SARTU ZURE EMAIL-A</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pasahitza" class="form-label">SARTU ZURE PASAHITZA</label>
                <input type="password" name="pasahitza" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">SAIOA HASI</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
