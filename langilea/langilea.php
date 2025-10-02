<?php
require '../conn/konexioa.php'; // DB konexioa
require '../session/session.php'; // saio kontrola
require '../model/langileak.php'; // Langileak klasea

$userId = $_SESSION['user_id']; // saioan dagoen erabiltzailearen ID

// langilearen izena, abizena eta rol-a hartu
$stmt = $conn->prepare("SELECT izena, abizena, rol FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // datuak array batean

// langile guztiak DB-tik hartu
$langileak = Langileak::ikusiLangileak($conn);

// admin bada, beste orrialdera bidali
if ($user["rol"] == "admin") {
    header("Location: ../langilea/langileaAdmin.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langileak</title>
    <!-- bootstrap eta CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../templates/navbar.php'; ?> <!-- nabigazio barra -->

    <main class="container mt-5 card-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Langileak</h1> <!-- orrialdearen izena -->
        </div>

        <div class="table-responsive">
            <table class="table table-hover rounded-3 shadow-sm table animate__animated animate__fadeIn">
                <thead class="table-dark">
                    <tr>
                        <th>Izena</th>
                        <th>Abizena</th>
                        <th>Email-a</th>
                        <th>Pasahitza</th>
                        <th>NAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // hemen betetzen dugu taula foreach-ekin
                    foreach ($langileak as $langile) {
                        echo "<tr>";
                        echo "<td>" . $langile->getIzena() . "</td>";
                        echo "<td>" . $langile->getAbizena() . "</td>";
                        echo "<td>" . $langile->getEmail() . "</td>";
                        echo "<td>********</td>"; // pasahitza ez erakutsi
                        echo "<td>" . $langile->getNan() . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?> <!-- footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
