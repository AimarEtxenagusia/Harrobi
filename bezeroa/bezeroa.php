<?php
// konexioa, sesioa eta bezeroaren modeloa ekartzen ditugu
require '../conn/konexioa.php';
require '../session/session.php';
require '../model/bezeroak.php';

// Base URL definituta
define('BASE_URL', '/Ariketak%20vsCode/Harrobi/');

// Saioa hasi duen erabiltzailearen ID-a hartzen dut
$userId = $_SESSION['user_id'];

// erabiltzailearen datuak lortzeko kontsulta prestatzen dut
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// bezero guztiak lortzen ditugu
$bezeroak = Bezeroak::ikusiBezeroak($conn);

// bezero bat ezabatzeko botoia sakatzen bada
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    Bezeroak::ezabatuBezeroa($conn, $id); // hemen datu basetik ezabatzen dut
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bezeroak</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include '../templates/navbar.php'; ?>

    <main class="container mt-5 card-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Bezeroak</h1>
            <!-- Bezero berria gehitzeko botoia -->
            <a href="bezeroaGehitu.php" class="btn btn-success btn-md animate__animated animate__bounce">Gehitu
                Bezeroa</a>
        </div>

        <div class="table-responsive">
            <!-- Taula: bezeroen informazioa erakusten da -->
            <table class="table table-hover rounded-3 shadow-sm table animate__animated animate__fadeIn">
                <thead class="table-dark">
                    <tr>
                        <th>Izena</th>
                        <th>Abizena</th>
                        <th>Email-a</th>
                        <th>Pasahitza</th>
                        <th>NAN</th>
                        <th>Instalazioa</th>
                        <th>Aldatu</th>
                        <th>Ezabatu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // bezero bakoitza taulan erakusten dut
                    foreach ($bezeroak as $bezero) {
                        echo "<tr>";
                        echo "<td>" . $bezero->getIzena() . "</td>";
                        echo "<td>" . $bezero->getAbizena() . "</td>";
                        echo "<td>" . $bezero->getEmail() . "</td>";
                        echo "<td>" . $bezero->getPasahitza() . "</td>";
                        echo "<td>" . $bezero->getNan() . "</td>";
                        echo "<td>" . $bezero->getInstalazioa() . "</td>";

                        // Aldatzeko botoia (bezeroaAldatu.php-ra eramaten du)
                        echo '<td><a href="bezeroaAldatu.php?id=' . $bezero->getId() . '" class="btn btn-warning btn-sm">
                                    <img src="../img/aldatu.png" alt="Aldatu"></a></td>';

                        // Ezabatzeko formularioa
                        echo '<td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $bezero->getId() . '">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                    <img src="../img/ezabatu.png" alt="Ezabatu">
                                </button>
                            </form>
                        </td>';

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
