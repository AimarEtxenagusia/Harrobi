<?php
// DB eta saioak kargatu
require "../conn/konexioa.php";
require '../session/session.php';
require '../model/langileak.php';

// Egungo erabiltzailearen ID
$id = $_SESSION['user_id'];

// Langilearen datuak DBtik atera
$sql = "SELECT izena, abizena, email, pasahitza, nan FROM langilea WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Kontrola: langilerik aurkitu ez bada
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    die("Ez da langilerik aurkitu");
}

// Saioaren datuak berriz lortu (gehiegi agian, baina segurua)
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Mezua hutsik hasierako
$textuaIzena = $textuaAbizena = $textuaEmaila = $textuaPasahitza = $textuaNan = "";

// Form submit egon bada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $izena = $_POST['langileaIzena'];
    $abizena = $_POST['langileaAbizena'];
    $email = $_POST['langileaEmail'];
    $pasahitza = $_POST['langileaPasahitza'];
    $nan = $_POST['langileaNan'];

    $errores = [];

    // Balidazioak
    if (empty($izena)) {
        $textuaIzena = "Sartu izena.";
        $errores[] = $textuaIzena;
    }

    if (empty($abizena)) {
        $textuaAbizena = "Sartu abizena.";
        $errores[] = $textuaAbizena;
    }

    if (empty($email)) {
        $textuaEmaila = "Sartu emaila.";
        $errores[] = $textuaEmaila;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $textuaEmaila = "Emaila ez da zuzena.";
        $errores[] = $textuaEmaila;
    }

    if (empty($pasahitza)) {
        $textuaPasahitza = "Sartu pasahitza.";
        $errores[] = $textuaPasahitza;
    }

    if (empty($nan)) {
        $textuaNan = "Sartu NAN-a.";
        $errores[] = $textuaNan;
    } elseif (!preg_match('/^[0-9]{8}[A-Za-z]$/', $nan)) {
        $textuaNan = "NAN-ak 9 karaktere izan behar ditu.";
        $errores[] = $textuaNan;
    }

    // Dena ondo bada, perfila aldatu
    if (count($errores) === 0) {
        Langileak::aldatuPerfila($conn, $izena, $abizena, $email, $pasahitza, $nan, $id);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIRE PERFILA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/taulak.css">
    <link rel="stylesheet" href="../css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include '../templates/navbar.php'; ?>

    <main class="container mt-4">
        <h1>NIRE PERFILA</h1>
        <form action="perfila.php" method="post" class="animate__animated animate__fadeInUp" novalidate>
            <!-- Izena -->
            <div class="mb-3">
                <label for="langileaIzena" class="form-label">Izena</label>
                <input type="text" name="langileaIzena" id="langileaIzena" class="form-control"
                    value="<?= htmlspecialchars($izena ?? $row['izena']) ?>" required>
                <p class="text-danger"><?= $textuaIzena ?></p>
            </div>

            <!-- Abizena -->
            <div class="mb-3">
                <label for="langileaAbizena" class="form-label">Abizena</label>
                <input type="text" name="langileaAbizena" id="langileaAbizena" class="form-control"
                    value="<?= htmlspecialchars($abizena ?? $row['abizena']) ?>" required>
                <p class="text-danger"><?= $textuaAbizena ?></p>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="langileaEmail" class="form-label">Email-a</label>
                <input type="email" name="langileaEmail" id="langileaEmail" class="form-control"
                    value="<?= htmlspecialchars($email ?? $row['email']) ?>" required>
                <p class="text-danger"><?= $textuaEmaila ?></p>
            </div>

            <!-- Pasahitza -->
            <div class="mb-3">
                <label for="langileaPasahitza" class="form-label">Pasahitza</label>
                <input type="text" name="langileaPasahitza" id="langileaPasahitza" class="form-control"
                    value="<?= htmlspecialchars($pasahitza ?? $row['pasahitza']) ?>" required>
                <p class="text-danger"><?= $textuaPasahitza ?></p>
            </div>

            <!-- NAN -->
            <div class="mb-3">
                <label for="langileaNan" class="form-label">NAN-a</label>
                <input placeholder="Adb: 12345678A" type="text" name="langileaNan" id="langileaNan" class="form-control"
                    value="<?= htmlspecialchars($nan ?? $row['nan']) ?>" required pattern="^[0-9]{8}[A-Za-z]$">
                <p class="text-danger"><?= $textuaNan ?></p>
            </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">ALDATU</button>
            </div>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
