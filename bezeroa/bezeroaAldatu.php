<?php
// konexioa, sesioa eta bezeroaren modeloa ekartzen ditugu
require "../conn/konexioa.php";
require '../session/session.php';
require '../model/bezeroak.php';

// Saioa hasi duen erabiltzailearen ID-a hartzen dut
$userId = $_SESSION['user_id'];

// langilearen datuak lortzen ditut (goian navbarrean erakusteko adibidez)
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// errorerako testuak hasieratzen ditut
$textuaIzena = $textuaAbizena = $textuaEmaila = $textuaPasahitza = $textuaNan = $textuaInstalazioa = "";

// GET bidez bidalitako bezeroaren ID-a
$id = $_GET['id'] ?? '';
$result = Bezeroak::aurkituBezeroa($conn, $id);

// bezeroa existitzen ez bada, hemen mozten dut
if ($result->num_rows != 1) {
    die("Ez da bezerorik aurkitu");
}
$row = $result->fetch_assoc();

// instalazio guztiak lortzen ditut (bezeroari esleitzeko aukeran)
$instalazioak_sql = "SELECT id, izena FROM instalazioa";
$instalazioak_result = $conn->query($instalazioak_sql);

// formularioa bidaltzen bada (POST bidez)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $izena = trim($_POST['bezeroaIzena']);
    $abizena = trim($_POST['bezeroaAbizena']);
    $email = trim($_POST['bezeroaEmail']);
    $pasahitza = trim($_POST['bezeroaPasahitza']);
    $nan = trim($_POST['bezeroaNan']);
    $instalazioa_id = $_POST['bezeroaInstalazioa'];

    // instalazioaren izena lortzen dut ID-aren arabera
    $instalazioa = "";
    if ($instalazioa_id != "") {
        $instalazioa_query = "SELECT izena FROM instalazioa WHERE id = '$instalazioa_id'";
        $instalazioa_result_temp = $conn->query($instalazioa_query);
        if ($instalazioa_result_temp && $instalazioa_result_temp->num_rows > 0) {
            $instalazioa_row = $instalazioa_result_temp->fetch_assoc();
            $instalazioa = $instalazioa_row['izena'];
        }
    }

    // hemen balidazio txikiak egiten ditut
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

    // errorerik ez badago → bezeroa aldatzen dut
    if (count($errores) === 0) {
        Bezeroak::aldatuBezeroa($conn, $izena, $abizena, $email, $pasahitza, $nan, $instalazioa, $id);
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
        <h1>BEZEROA ALDATU</h1>
        <!-- formularioan bezeroaren datuak erakusten dira eta hemen aldatzeko aukera dago -->
        <form class="animate__animated animate__fadeInUp" action="bezeroaAldatu.php?id=<?= $id ?>" method="post"
            class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $id ?>">

            <label for="bezeroaIzena" class="form-label">IZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaIzena" name="bezeroaIzena"
                value="<?= ($izena ?? $row['izena']) ?>" required>
            <p class="text-danger"><?= $textuaIzena ?></p>

            <label for="bezeroaAbizena" class="form-label">ABIZENA <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaAbizena" name="bezeroaAbizena"
                value="<?= ($abizena ?? $row['abizena']) ?>" required>
            <p class="text-danger"><?= $textuaAbizena ?></p>

            <label for="bezeroaEmail" class="form-label">EMAIL-A <span style="color:red">*</span></label>
            <input type="email" class="form-control" id="bezeroaEmail" name="bezeroaEmail"
                value="<?= ($email ?? $row['email']) ?>" required
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
            <p class="text-danger"><?= $textuaEmaila ?></p>

            <label for="bezeroaPasahitza" class="form-label">PASAHITZA <span style="color:red">*</span></label>
            <input type="password" class="form-control" id="bezeroaPasahitza" name="bezeroaPasahitza"
                value="<?= ($pasahitza ?? $row['pasahitza']) ?>" required>
            <p class="text-danger"><?= $textuaPasahitza ?></p>

            <label for="bezeroaNan" class="form-label">NAN-A <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="bezeroaNan" name="bezeroaNan" placeholder="Adb: 12345678A"
                value="<?= ($nan ?? $row['nan']) ?>" required pattern="^[0-9]{8}[A-Za-z]$">
            <p class="text-danger"><?= $textuaNan ?></p>

            <label for="bezeroaInstalazioa" class="form-label">INSTALAZIOAREN IZENA <span
                    style="color:red">*</span></label>
            <select class="form-select" id="bezeroaInstalazioa" name="bezeroaInstalazioa" required>
                <?php
                // instalazio guztiak select-ean erakusten ditut
                if ($instalazioak_result && $instalazioak_result->num_rows > 0) {
                    foreach ($instalazioak_result as $instalazioa_opt) {
                        $selected_id = $instalazioa_id ?? '';
                        $selected_name = $instalazioa ?? $row['instalazioa'];
                        $selected = ($instalazioa_opt['izena'] == $selected_name) ? 'selected' : '';
                        echo "<option value='" . $instalazioa_opt['id'] . "' $selected>" . $instalazioa_opt['izena'] . "</option>";
                    }
                }
                ?>
            </select>
            <p class="text-danger"><?= $textuaInstalazioa ?></p>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary w-100">ALDATU</button>
                <a class="btn btn-secondary w-100" href="bezeroa.php">ITZULI</a>
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
