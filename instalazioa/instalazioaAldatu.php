<?php
require "../conn/konexioa.php"; // DB konexioa
require '../session/session.php'; // saio kontrola
require '../model/instalazioa.php'; // Instalazioa klasea

$userId = $_SESSION['user_id']; // saioan dagoen erabiltzailearen ID

// langilearen izena eta abizena hartu
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // datuak array batean

$textuaInstalazioa = ""; // errore mezuak

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // form bidali bada
    $id = $_POST['id']; // hau ID ezkutua formetik
    $izenaInstalazioa = trim($_POST['instalazioIzena']);

    if (empty($izenaInstalazioa)) { // hutsik bada
        $textuaInstalazioa = "Sartu izen bat!"; // mezu txikia
    } else {
        Instalazioa::aldatuInstalazioa($conn, $izenaInstalazioa, $id); // DB-an aldatu
    }
} else { // lehenengo aldiz kargatzen bada
    $id = $_GET['id']; // GETetik ID hartu

    $sql = "SELECT izena FROM instalazioa WHERE id = ?"; // DBtik izena hartu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); // hau hemen hartu datuak
    } else {
        die("Ez da instalaziorik aurkitu"); // ez badago, gelditu
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTALAZIOA ALDATU</title>
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
        <h1>INSTALAZIOA ALDATU</h1>
        <form action="" method="post" class="needs-validation animate__animated animate__fadeInUp" novalidate>
            <!-- input instalazio izena -->
            <label for="instalazioIzena" class="form-label">INSTALAZIOAREN IZENA <span
                    style="color:red">*</span></label>
            <input type="text" class="form-control" id="instalazioIzena" name="instalazioIzena"
                value="<?= isset($izenaInstalazioa) ? ($izenaInstalazioa) : ($row['izena']) ?>" required>
            <p class="text-danger"><?= $textuaInstalazioa ?></p> <!-- errore mezuak -->

            <!-- ID ezkutu formetik bidaltzeko -->
            <input type="hidden" name="id" value="<?= $id; ?>">

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">ALDATU</button> <!-- aldatu botoia -->
                <a class="btn btn-secondary w-100" href="instalazioak.php">ITZULI</a> <!-- atzera -->
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?> <!-- footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
