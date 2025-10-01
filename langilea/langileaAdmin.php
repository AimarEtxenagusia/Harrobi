<?php
require '../conn/konexioa.php';
require '../session/session.php';
require '../model/langileak.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena, rol FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$langileak = Langileak::ikusiLangileak($conn);

if ($user["rol"] == "user") {
    header("Location: https://thatsthefinger.com/");
}

if (isset($_POST["delete"])) {
    $id = $_POST["id"];
    Langileak::ezabatuLangilea($conn, $id);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langileak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/taulak.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <?php include '../templates/navbar.php'; ?>

    <main class="container mt-5 card-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Langileak</h1>
            <a href="langileaGehitu.php" class="btn btn-success btn-md animate__animated animate__bounce">Gehitu Langilea</a>
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
                        <th>Aldatu</th>
                        <th>Ezabatu </th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($langileak as $langile) {
                        echo "<tr>";
                        echo "<td>" . $langile->getIzena() . "</td>";
                        echo "<td>" . $langile->getAbizena() . "</td>";
                        echo "<td>" . $langile->getEmail() . "</td>";
                        echo "<td>********</td>";
                        echo "<td>" . $langile->getNan() . "</td>";
                        echo '<td><a href="langileaAldatu.php?id=' . $langile->getId() . '" class="btn btn-warning btn-sm">
                                    <img src="../img/aldatu.png" alt="Aldatu"></a></td>';
                        echo '<td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $langile->getId() . '">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                    <img src="../img/ezabatu.png" alt="Ezabatu">
                                </button>
                            </form>
                        </td>';

                        echo "</tr>";
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