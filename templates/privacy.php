<?php
require "../conn/konexioa.php";
require '../session/session.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT izena, abizena FROM langilea WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pribatutasun-politika</title>
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body, html {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    main{
        flex: 1;
    }
</style>
<body>
    <?php include '../templates/navbar.php'; ?>

    <main class="container mt-4">
        <h1>Pribatutasun-politika</h1>
        <p>
            Zure pribatutasuna oso garrantzitsua da guretzat. Bildutako datu pertsonalak administrazio helburuetarako
            bakarrik erabiltzen dira eta ez dira hirugarrenei partekatuko zure baimenik gabe.
        </p>
        <h2>Bildutako datuak</h2>
        <ul>
            <li>Izen eta abizenak</li>
            <li>Email helbidea</li>
            <li>Kontakturako informazioa</li>
        </ul>
        <h2>Informazioaren erabilera</h2>
        <p>
            Datuak kontuak kudeatzeko, informazio garrantzitsua bidaltzeko eta gure zerbitzuak hobetzeko erabiltzen
            dira.
        </p>
        <h2>Erabiltzailearen eskubideak</h2>
        <p>
            Zure datuetara sarbidea izan dezakezu, aldatu edo ezabatu nahi duzunean, gure taldearekin harremanetan
            jarriz.
        </p>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>

</html>