<?php
require "conn/konexioa.php";
require 'session/session.php';
require 'model/instalazioa.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$textuaInstalazioa = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $izenaInstalazioa = trim($_POST['instalazioIzena']);

    if (empty($izenaInstalazioa)) {
        $textuaInstalazioa = "Sartu izen bat!";
    } else {
        Instalazioa::gehituInstalazioa($conn, $izenaInstalazioa);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTALAZIO BERRIA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/taulak.css">
    <link rel="stylesheet" href="css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>


    <?php include 'navbar/navbar.php'; ?>

    <div class="container mt-4">
        <h1>INSTALAZIO BERRIA</h1>
        <form action="" method="post" class="needs-validation animate__animated animate__fadeInUp" novalidate>
            <label for="instalazioIzena" class="form-label">INSTALAZIOAREN IZENA <span
                    style="color:red">*</span></label>
            <input type="text" class="form-control" id="instalazioIzena" name="instalazioIzena"
                value="<?= isset($izenaInstalazioa) ? $izenaInstalazioa : '' ?>" required>
            <p class="text-danger"><?= $textuaInstalazioa ?></p>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">GEHITU</button>
                <a class="btn btn-secondary w-100" href="instalazioak.php">ITZULI</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>