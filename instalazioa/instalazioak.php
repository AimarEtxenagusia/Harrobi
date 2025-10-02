<?php
require '../conn/konexioa.php'; // DB konexioa
require '../session/session.php'; // saio kontrola
require '../model/instalazioa.php'; // Instalazioa klasea

$userId = $_SESSION['user_id']; // saioan dagoen erabiltzailearen ID

// langilearen izena eta abizena hartu
$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // datuak array batean

// instalazio guztiak hartu
$instalazioak = Instalazioa::ikusiInstalazioa($conn);

// ezabatzeko botoia sakatu bada
if (isset($_POST['delete'])) {
    $id = $_POST['id']; // ezabatzeko ID hartu
    Instalazioa::ezabatuInstalazioa($conn, $id); // DB-tik ezabatu
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalazioak</title>
    <!-- bootstrap eta CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/taulak.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include '../templates/navbar.php'; ?> <!-- nabigazio barra -->

    <main class="container mt-5 card-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Instalazioak</h1>
            <!-- gehitu instalazio botoia -->
            <a href="gehituInstalazioa.php" class="btn btn-success btn-md animate__animated animate__bounce">Gehitu
                Instalazioa</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover rounded-3 shadow-sm table animate__animated animate__fadeIn">
                <thead class="table-dark">
                    <tr>
                        <th>Izena</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // hemen taula betetzen dugu foreach-ekin
                    foreach ($instalazioak as $instalazio) {
                        echo "<tr>";
                        echo "<td>" . $instalazio->getIzena() . "</td>"; // izena
                        // aldatu botoia
                        echo '<td><a href="instalazioaAldatu.php?id=' . $instalazio->getId() . '" class="btn btn-warning btn-sm">
                                    <img src="../img/aldatu.png" alt="Aldatu"></a></td>';
                        // ezabatu botoia form baten bidez
                        echo '<td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $instalazio->getId() . '">
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

    <?php include '../templates/footer.php'; ?> <!-- footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
