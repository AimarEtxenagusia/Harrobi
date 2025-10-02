<?php
require "../conn/konexioa.php"; // DB konexioa
require '../session/session.php'; // saio kontrola
require '../model/langileak.php'; // Langileak klasea
$userId = $_SESSION['user_id']; // saioan dagoen erabiltzailearen ID

// langilearen izena, abizena eta rol-a hartu
$stmt = $conn->prepare("SELECT izena, abizena, rol FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// user rol-a badu, ezingo du sartu, beste orrialdera bidali
if ($user["rol"] == "user") {
    header("Location: https://thatsthefinger.com/");
}

// error mezuak
$textuaIzena = $textuaAbizena = $textuaEmaila = $textuaPasahitza = $textuaNan = $textuaInstalazioa = "";

// formularioa submit egin bada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // input-ak trim egin eta hartu
    $izena = trim($_POST['langileaIzena']);
    $abizena = trim($_POST['langileaAbizena']);
    $email = trim($_POST['langileaEmail']);
    $pasahitza = trim($_POST['langileaPasahitza']);
    $nan = trim($_POST['langileaNan']);

    $errores = []; // error array

    // validation-ak
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

    // errorik ez bada, langilea gehitu
    if (count($errores) === 0) {
        Langileak::gehituLangilea($conn, $izena, $abizena, $email, $pasahitza, $nan);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LANGILEA GEHITU</title>
    <!-- CSS guztiak -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/btn.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include '../templates/navbar.php'; ?> <!-- nabigazio barra -->

    <main class="container mt-4">
        <h1>Langilea Gehitu</h1>
        <!-- formularioa -->
        <form class="animate__animated animate__fadeInUp" action="langileaGehitu.php" method="post"
            class="needs-validation" novalidate>

            <!-- izena -->
            <label for="langileaIzena" class="form-label">IZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaIzena" name="langileaIzena"
                value="<?= isset($izena) ? ($izena) : '' ?>" required>
            <p class="text-danger"><?= $textuaIzena ?></p>

            <!-- abizena -->
            <label for="langileaAbizena" class="form-label">ABIZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaAbizena" name="langileaAbizena"
                value="<?= isset($abizena) ? ($abizena) : '' ?>" required>
            <p class="text-danger"><?= $textuaAbizena ?></p>

            <!-- email -->
            <label for="langileaEmail" class="form-label">EMAIL-A <span style="color:red">*</span></label>
            <input type="email" class="form-control" id="langileaEmail" name="langileaEmail"
                value="<?= isset($email) ? ($email) : '' ?>" required
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
            <p class="text-danger"><?= $textuaEmaila ?></p>

            <!-- pasahitza -->
            <label for="langileaPasahitza" class="form-label">PASAHITZA <span style="color:red">*</span></label>
            <input type="password" class="form-control" id="langileaPasahitza" name="langileaPasahitza"
                value="<?= isset($pasahitza) ? ($pasahitza) : '' ?>" required>
            <p class="text-danger"><?= $textuaPasahitza ?></p>

            <!-- NAN -->
            <label for="langileaNan" class="form-label">NAN-A <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaNan" name="langileaNan" placeholder="Adb: 12345678A"
                value="<?= isset($nan) ? ($nan) : '' ?>" required pattern="^[0-9]{8}[A-Za-z]$">
            <p class="text-danger"><?= $textuaNan ?></p>

            <!-- botoia -->
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">GEHITU</button>
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?> <!-- footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>