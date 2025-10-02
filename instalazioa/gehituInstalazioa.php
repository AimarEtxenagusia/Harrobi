<?php
require "../conn/konexioa.php"; // DB konexioa sartzen
require '../session/session.php'; // saioa kontrolatzeko
require '../model/instalazioa.php'; // Instalazioa klasea

$userId = $_SESSION['user_id']; // saioan dagoen erabiltzailearen ID

// langilearen izena eta abizena hartu
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // datuak array batean

$textuaInstalazioa = ""; // errore mezuak

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // form bidali denean
    $izenaInstalazioa = trim($_POST['instalazioIzena']);

    if (empty($izenaInstalazioa)) { // hutsik bada
        $textuaInstalazioa = "Sartu izen bat!";
    } else {
        Instalazioa::gehituInstalazioa($conn, $izenaInstalazioa); // DB-an gehitu
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTALAZIO BERRIA</title>
    <!-- CSSak eta bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link rel="stylesheet" href="../css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include '../templates/navbar.php'; ?> <!-- nabigazio barra -->

    <main class="container mt-4">
        <h1>INSTALAZIO BERRIA</h1>
        <form action="" method="post" class="needs-validation animate__animated animate__fadeInUp" novalidate>
            <!-- input instalazio izena -->
            <label for="instalazioIzena" class="form-label">INSTALAZIOAREN IZENA <span
                    style="color:red">*</span></label>
            <input type="text" class="form-control" id="instalazioIzena" name="instalazioIzena"
                value="<?= isset($izenaInstalazioa) ? $izenaInstalazioa : '' ?>" required>
            <p class="text-danger"><?= $textuaInstalazioa ?></p> <!-- errore mezuak -->

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">GEHITU</button> <!-- gehitu botoia -->
                <a class="btn btn-secondary w-100" href="instalazioak.php">ITZULI</a> <!-- atzera -->
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?> <!-- footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
