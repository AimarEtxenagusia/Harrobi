<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasiera</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-XXXX" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <img src="img/harrobi.png" alt="">

    <form action="index.php" method="post">
        <label for="name" name="email">SARTU ZURE EMAIL-A</label>
        <input type="mail" name="email">
        <label for="name" name="pasahitza">SARTU ZURE PASAHITZA</label>
        <input type="password" name="pasahitza">
        <input type="submit" value="SAIOA HASI">
        <input type="number" name="id" hidden>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YYYY"
        crossorigin="anonymous"></script>

</body>
<?php

require "konexioa.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pasahitza = $_POST['pasahitza'];
    if (empty($email) || empty($pasahitza)) {
        echo '<p style="color: red; font-size: 25px; text-align: center;">Sartu datu guztiak</p>';
    } else {
        $stmt = $conn->prepare("SELECT id, email, pasahitza FROM langilea WHERE email = ? AND pasahitza = ?");

        $stmt->bind_param("ss", $email, $pasahitza);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                header("Location: bezeroa.php?id=" . $row['id']);
                exit; 

            }
        } else {
            echo '<p style="color: red; font-size: 25px; text-align: center;">Datuak ez dira zuzenak</p>';

        }

    }
}
?>

</html>