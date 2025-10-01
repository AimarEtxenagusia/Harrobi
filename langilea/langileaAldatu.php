<?php
require "../conn/konexioa.php";
require '../session/session.php';
require '../model/langileak.php';
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena, rol FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user["rol"] == "user") {
    header("Location: https://thatsthefinger.com/");
}

$textuaIzena = $textuaAbizena = $textuaEmaila = $textuaPasahitza = $textuaNan = "";

$id = $_GET['id'] ?? '';
$result = Langileak::aurkituLangilea($conn, $id);

if ($result->num_rows != 1) {
    die("Ez da langilerik aurkitu");
}
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $izena = trim($_POST['langileaIzena']);
    $abizena = trim($_POST['langileaAbizena']);
    $email = trim($_POST['langileaEmail']);
    $pasahitza = trim($_POST['langileaPasahitza']);
    $nan = trim($_POST['langileaNan']);


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

    if (count($errores) === 0) {
        Langileak::aldatuLangilea($conn, $izena, $abizena, $email, $pasahitza, $nan, $id);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEZEROA ALDATU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/btn.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include '../templates/navbar.php'; ?>

    <main class="container mt-4">
        <h1>LANGILEA ALDATU</h1>
        <form class="animate__animated animate__fadeInUp" action="langileaAldatu.php?id=<?= $id ?>" method="post"
            class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $id ?>">

            <label for="langileaIzena" class="form-label">IZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaIzena" name="langileaIzena"
                value="<?= ($izena ?? $row['izena']) ?>" required>
            <p class="text-danger"><?= $textuaIzena ?></p>

            <label for="langileaAbizena" class="form-label">ABIZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaAbizena" name="langileaAbizena"
                value="<?= ($abizena ?? $row['abizena']) ?>" required>
            <p class="text-danger"><?= $textuaAbizena ?></p>

            <label for="langileaEmail" class="form-label">EMAIL-A <span style="color:red">*</span></label>
            <input type="email" class="form-control" id="langileaEmail" name="langileaEmail"
                value="<?= ($email ?? $row['email']) ?>" required
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
            <p class="text-danger"><?= $textuaEmaila ?></p>

            <label for="langileaPasahitza" class="form-label">PASAHITZA <span style="color:red">*</span></label>
            <input type="password" class="form-control" id="langileaPasahitza" name="langileaPasahitza"
                value="<?= ($pasahitza ?? $row['pasahitza']) ?>" required>
            <p class="text-danger"><?= $textuaPasahitza ?></p>

            <label for="langileaNan" class="form-label">NAN-A <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="langileaNan" name="langileaNan" placeholder="Adb: 12345678A"
                value="<?= ($nan ?? $row['nan']) ?>" required pattern="^[0-9]{8}[A-Za-z]$">
            <p class="text-danger"><?= $textuaNan ?></p>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">ALDATU</button>
                <a class="btn btn-secondary w-100   " href="langilea.php">ITZULI</a>
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>