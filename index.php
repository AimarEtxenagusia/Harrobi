<?php
// DB eta modelak kargatu
require "conn/konexioa.php";
require 'model/langileak.php';
    
session_start(); // Saioa hasteko

$error_msg = ""; // Errore mezua gordetzeko

// Formulari bidali bada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pasahitza = $_POST['pasahitza'];

    // Beteko diren datuak egiaztatu
    if (empty($email) || empty($pasahitza)) {
        $error_msg = "Sartu datu guztiak";
    } else {
        // Langilearen login funtzioa erabili
        $error_msg = Langileak::login($conn, $email, $pasahitza);
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <!-- CSSak -->
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="img/harrobi.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
        </div>

        <!-- Errore mezua -->
        <?php if ($error_msg): ?>
            <div class="alert alert-danger text-center"><?= $error_msg ?></div>
        <?php endif; ?>

        <!-- Login formularioa -->
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Sartu zure email-a</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pasahitza" class="form-label">Sartu zure pasahitza</label>
                <input type="password" name="pasahitza" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Saioa hasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
